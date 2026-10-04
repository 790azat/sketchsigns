<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Media;
use App\Models\Product;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

/**
 * Copies the catalog from the old WooCommerce site (public Store API) into the database
 * and mirrors every image into Vercel Blob, so the new site no longer depends on WordPress.
 */
class WooImporter
{
    public function __construct(private BlobStorage $blob) {}

    private function api(string $path, array $query = []): Response
    {
        return Http::baseUrl(rtrim(config('services.woo.url'), '/'))
            ->acceptJson()
            ->timeout(30)
            ->retry(2, 1000)
            ->get($path, $query);
    }

    /** @return int number of categories imported */
    public function importCategories(): int
    {
        $rows = [];
        for ($page = 1; $page < 20; $page++) {
            $batch = $this->api('products/categories', ['per_page' => 100, 'page' => $page])->json();
            if (empty($batch)) {
                break;
            }
            $rows = array_merge($rows, $batch);
            if (count($batch) < 100) {
                break;
            }
        }

        foreach ($rows as $i => $row) {
            Category::updateOrCreate(['wp_id' => $row['id']], [
                'slug' => $row['slug'],
                'name' => $this->text($row['name']),
                'description' => $row['description'] ?: null,
                'image' => isset($row['image']['src']) ? $this->mirror($row['image']['src'], 'categories') : null,
                'position' => $i,
            ]);
        }

        // Second pass once every parent exists.
        $byWpId = Category::pluck('id', 'wp_id');
        foreach ($rows as $row) {
            Category::where('wp_id', $row['id'])->update(['parent_id' => $byWpId[$row['parent']] ?? null]);
        }

        return count($rows);
    }

    /**
     * Import one page of products.
     *
     * @return array{imported: int, page: int, total_pages: int}
     */
    public function importProducts(int $page = 1, int $perPage = 5): array
    {
        $response = $this->api('products', ['per_page' => $perPage, 'page' => $page, 'orderby' => 'menu_order', 'order' => 'asc']);
        $totalPages = (int) $response->header('X-WP-TotalPages') ?: $page;
        $categoryIds = Category::pluck('id', 'wp_id');

        $imported = 0;
        foreach ($response->json() ?? [] as $i => $row) {
            try {
                $this->importProduct($row, ($page - 1) * $perPage + $i, $categoryIds->all());
                $imported++;
            } catch (Throwable $e) {
                Log::error('Product import failed', ['slug' => $row['slug'] ?? null, 'error' => $e->getMessage()]);
            }
        }

        return ['imported' => $imported, 'page' => $page, 'total_pages' => $totalPages];
    }

    public function importProduct(array $row, int $position, array $categoryIds): Product
    {
        $images = collect($row['images'] ?? [])->pluck('src')->filter()->values();
        $mirrored = $images->map(fn ($src) => $this->mirror($src, 'products'))->all();

        $options = collect($row['attributes'] ?? [])->map(fn ($a) => [
            'name' => $this->text($a['name']),
            'terms' => collect($a['terms'] ?? [])->map(fn ($t) => ['slug' => $t['slug'], 'name' => $this->text($t['name'])])->values()->all(),
        ])->values()->all();

        $prices = $row['prices'];
        $unit = 10 ** (int) ($prices['currency_minor_unit'] ?? 2) / 100;

        return DB::transaction(function () use ($row, $position, $categoryIds, $mirrored, $options, $prices, $unit) {
            $product = Product::updateOrCreate(['wp_id' => $row['id']], [
                'slug' => $row['slug'],
                'name' => $this->text($row['name']),
                'type' => $row['type'],
                'short_description' => $this->html($row['short_description'] ?? ''),
                'description' => $this->html($row['description'] ?? ''),
                'price_min' => (int) round(($prices['price_range']['min_amount'] ?? $prices['price']) / $unit),
                'price_max' => (int) round(($prices['price_range']['max_amount'] ?? $prices['price']) / $unit),
                'image' => $mirrored[0] ?? null,
                'gallery' => $mirrored,
                'options' => $options,
                'in_stock' => (bool) ($row['is_in_stock'] ?? true),
                'is_active' => true,
                'position' => $position,
            ]);

            $product->categories()->sync(
                collect($row['categories'] ?? [])->map(fn ($c) => $categoryIds[$c['id']] ?? null)->filter()->all()
            );

            $this->importVariations($product, $row, $unit);

            return $product;
        });
    }

    private function importVariations(Product $product, array $row, float $unit): void
    {
        $variations = collect($row['variations'] ?? []);

        if ($variations->isEmpty()) {
            $product->variations()->delete();
            $product->variations()->create([
                'wp_id' => null,
                'options' => (object) [],
                'price' => $product->price_min,
            ]);

            return;
        }

        // The Store API lists a variable product's variations (with their prices) as products of type "variation".
        $prices = [];
        foreach ($variations->pluck('id')->chunk(100) as $ids) {
            foreach ($this->api('products', ['type' => 'variation', 'include' => $ids->implode(','), 'per_page' => 100])->json() ?? [] as $v) {
                $prices[$v['id']] = (int) round($v['prices']['price'] / $unit);
            }
        }

        $keep = [];
        foreach ($variations as $v) {
            $keep[] = $v['id'];
            $product->variations()->updateOrCreate(['wp_id' => $v['id']], [
                'options' => collect($v['attributes'])->mapWithKeys(fn ($a) => [$this->text($a['name']) => (string) $a['value']])->all(),
                'price' => $prices[$v['id']] ?? $product->price_min,
            ]);
        }
        $product->variations()->whereNotIn('wp_id', $keep)->delete();
    }

    /** Copy an image into Vercel Blob once; returns the URL to use. */
    public function mirror(string $src, string $folder): string
    {
        if (! $this->blob->enabled()) {
            return $src;
        }

        $existing = Media::where('source_url', $src)->value('url');
        if ($existing) {
            return $existing;
        }

        try {
            $file = Http::timeout(30)->retry(2, 500)->get($src);
            $type = Str::before($file->header('Content-Type') ?: 'image/jpeg', ';');
            $name = Str::slug(pathinfo(parse_url($src, PHP_URL_PATH), PATHINFO_FILENAME)).'.'.(pathinfo(parse_url($src, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg');
            $url = $this->blob->put("{$folder}/{$name}", $file->body(), $type);
        } catch (Throwable $e) {
            Log::warning('Image mirror failed, keeping original URL', ['src' => $src, 'error' => $e->getMessage()]);

            return $src;
        }

        Media::create(['source_url' => $src, 'url' => $url]);

        return $url;
    }

    private function text(string $value): string
    {
        return trim(html_entity_decode(strip_tags($value), ENT_QUOTES | ENT_HTML5));
    }

    /** Keep the old site's formatting but drop anything executable. */
    private function html(string $value): string
    {
        $value = preg_replace('#<(script|style|iframe)\b[^>]*>.*?</\1>#is', '', $value);
        $value = preg_replace('/\s(on\w+|style)="[^"]*"/i', '', $value);

        return trim($value);
    }
}
