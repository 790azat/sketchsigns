<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Support\Catalog;
use App\Support\Seo;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function sitemap(): Response
    {
        $urls = collect();
        $add = fn (string $path, $lastmod = null, string $priority = '0.5') => $urls->push([
            'loc' => Seo::url($path), 'lastmod' => $lastmod?->toAtomString(), 'priority' => $priority,
        ]);

        $add('/', null, '1.0');
        $add(route('shop'), null, '0.9');

        foreach (Category::whereHas('products', fn ($q) => $q->active())->orderBy('position')->get() as $category) {
            $add(route('category', $category), $category->updated_at, '0.8');
        }

        foreach (Product::active()->with('categories')->orderBy('position')->get() as $product) {
            $add(route('product', $product), $product->updated_at, '0.7');
        }

        $add(route('industries'), null, '0.6');
        foreach (Catalog::industries() as $industry) {
            $add(route('industry', $industry['slug']), null, '0.6');
        }

        foreach (['installation', 'design', 'quote', 'about', 'contact', 'faq'] as $page) {
            $add(route($page));
        }
        foreach (['turnaround-policy', 'refund-policy', 'terms-and-conditions', 'privacy-policy'] as $page) {
            $add(route('legal', $page), null, '0.3');
        }

        return response()->view('seo.sitemap', ['urls' => $urls], 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }

    public function robots(): Response
    {
        $lines = config('site.indexable')
            ? [
                'User-agent: *',
                'Disallow: /admin',
                'Disallow: /cart',
                'Disallow: /checkout',
                'Disallow: /*?*sort=',
                'Allow: /',
                '',
                'Sitemap: '.Seo::url('/sitemap.xml'),
            ]
            : [
                '# Test copy of sketchsigns.com: closed to search engines until launch (SITE_INDEXABLE=true).',
                'User-agent: *',
                'Disallow: /',
            ];

        return response(implode("\n", $lines)."\n", 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }
}
