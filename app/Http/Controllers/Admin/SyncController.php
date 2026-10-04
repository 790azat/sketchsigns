<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Services\WooImporter;
use App\Support\Catalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

/**
 * Token-protected endpoints to run migrations and the catalog import on Vercel,
 * where there is no shell. Each call does a small batch to stay within function time limits.
 */
class SyncController extends Controller
{
    public function __construct(Request $request)
    {
        $token = config('services.admin_token');
        abort_unless($token && hash_equals($token, (string) $request->query('token')), 404);
    }

    public function migrate()
    {
        Artisan::call('migrate', ['--force' => true]);

        return response()->json(['output' => Artisan::output()]);
    }

    public function categories(WooImporter $importer)
    {
        return response()->json(['categories' => $importer->importCategories()]);
    }

    public function products(Request $request, WooImporter $importer)
    {
        set_time_limit(300);
        $result = $importer->importProducts((int) $request->query('page', 1), (int) $request->query('per_page', 5));

        return response()->json($result + [
            'products_total' => Product::count(),
            'next' => $result['page'] < $result['total_pages'] ? $result['page'] + 1 : null,
        ]);
    }

    public function siteMedia(WooImporter $importer)
    {
        $urls = collect(Catalog::siteMediaUrls())->mapWithKeys(fn ($src) => [$src => $importer->mirror($src, 'site')]);

        return response()->json(['site_media' => $urls]);
    }

    public function remirror(Request $request, WooImporter $importer)
    {
        set_time_limit(300);
        $result = $importer->remirror((int) $request->query('page', 1), (int) $request->query('per_page', 20));

        return response()->json($result + ['next' => $result['page'] < $result['total_pages'] ? $result['page'] + 1 : null]);
    }

    /** Every mirrored image: where it came from and its path in storage (used to build public/media). */
    public function mediaMap()
    {
        return response()->json(\App\Models\Media::orderBy('id')->get()->map(fn ($m) => [
            'source' => $m->source_url,
            'path' => ltrim(parse_url($m->url, PHP_URL_PATH), '/'),
        ]));
    }

    /** Create or reset an admin-panel login; the new password is shown once in the response. */
    public function adminUser(Request $request)
    {
        $data = $request->validate(['email' => 'required|email', 'name' => 'nullable|string|max:120']);
        $password = \Illuminate\Support\Str::password(16, symbols: false);

        $user = \App\Models\User::updateOrCreate(
            ['email' => strtolower($data['email'])],
            ['name' => $data['name'] ?? 'Admin', 'password' => $password],
        );

        return response()->json(['email' => $user->email, 'password' => $password, 'login' => url('/admin/login')]);
    }

    public function status()
    {
        return response()->json([
            'categories' => Category::count(),
            'products' => Product::count(),
            'without_blob_image' => Product::where('image', 'not like', '%blob.vercel-storage.com%')->count(),
            'missing_configured_slugs' => $this->missingSlugs(),
        ]);
    }

    /** Product slugs named in config/site.php that the catalog doesn't have. */
    private function missingSlugs(): array
    {
        $slugs = collect(config('site.industries'))->pluck('products')->flatten()
            ->merge(config('site.featured_products'))->unique();

        return $slugs->diff(Product::whereIn('slug', $slugs)->pluck('slug'))->values()->all();
    }
}
