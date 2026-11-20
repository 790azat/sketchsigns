<?php

namespace App\Support;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

/**
 * Titles, descriptions, canonical URLs and schema.org data for search engines.
 * Admin-entered SEO fields win; otherwise text is built from the product or category.
 */
class Seo
{
    public const TITLE_MAX = 60;

    public const DESCRIPTION_MAX = 160;

    /** Absolute URL on the public domain (the test site still points search engines at sketchsigns.com). */
    public static function url(string $path = '/'): string
    {
        $base = rtrim(config('site.canonical_url'), '/');

        if (str_starts_with($path, 'http')) {
            $app = rtrim(url('/'), '/');
            if (! str_starts_with($path, $app)) {
                return $path;
            }
            $path = substr($path, strlen($app));
        }

        $path = '/'.ltrim((string) $path, '/');

        return $path === '/' ? $base : $base.rtrim($path, '/');
    }

    public static function text(?string $html, int $limit = self::DESCRIPTION_MAX): string
    {
        $text = trim(preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags((string) $html), ENT_QUOTES | ENT_HTML5)));

        return Str::limit($text, $limit - 1, '…', preserveWords: true);
    }

    /** "Name | Sketch Signs Los Angeles", shortened when it would not fit in search results. */
    public static function title(string $name, ?string $suffix = null): string
    {
        $brand = config('site.name');
        foreach (array_filter([$suffix ? "$name $suffix | $brand" : null, "$name | $brand Los Angeles", "$name | $brand"]) as $title) {
            if (mb_strlen($title) <= self::TITLE_MAX) {
                return $title;
            }
        }

        return $name;
    }

    public static function productTitle(Product $product): string
    {
        return filled($product->seo_title) ? $product->seo_title : static::title($product->name);
    }

    public static function productDescription(Product $product): string
    {
        if (filled($product->seo_description)) {
            return $product->seo_description;
        }

        $text = static::text($product->short_description) ?: static::text($product->description);
        $pitch = 'Order online from Sketch Signs in Los Angeles: instant pricing, free art check, fast turnaround.';

        if (mb_strlen($text) < 70) {
            return static::text(trim(($text ?: "Custom {$product->name}.").' '.$pitch));
        }

        return $text;
    }

    public static function categoryTitle(Category $category): string
    {
        return filled($category->seo_title) ? $category->seo_title : static::title($category->name, 'in Los Angeles');
    }

    public static function categoryDescription(Category $category): string
    {
        if (filled($category->seo_description)) {
            return $category->seo_description;
        }

        return static::text($category->description)
            ?: static::text('Shop custom '.Str::lower($category->name).' online at Sketch Signs. Instant pricing, free art check, fast production and shipping across California, or installation in Los Angeles.');
    }

    // ---- schema.org (JSON-LD) ----

    public static function organization(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            '@id' => static::url('/').'/#business',
            'name' => config('site.name'),
            'url' => static::url('/'),
            'logo' => static::url(Catalog::media(config('site.logo'))),
            'image' => static::url(Catalog::media(config('site.logo'))),
            'description' => config('site.description'),
            'telephone' => '+1-213-753-2121',
            'email' => config('site.email'),
            'priceRange' => '$$',
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => 'Los Angeles',
                'addressRegion' => 'CA',
                'addressCountry' => 'US',
            ],
            'areaServed' => ['@type' => 'State', 'name' => 'California'],
            'openingHoursSpecification' => [[
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                'opens' => '07:00',
                'closes' => '19:00',
            ]],
            'sameAs' => array_values(array_filter(config('site.social', []), fn ($url) => ! str_contains($url, 'trustpilot.com/evaluate'))),
        ];
    }

    public static function website(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => config('site.name'),
            'url' => static::url('/'),
            'publisher' => ['@id' => static::url('/').'/#business'],
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => ['@type' => 'EntryPoint', 'urlTemplate' => static::url('/shop').'?q={search_term_string}'],
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    /** @param array<string, string|null> $crumbs label => URL (null = current page) */
    public static function breadcrumbs(array $crumbs): array
    {
        $items = [];
        $position = 1;
        foreach (['Home' => route('home')] + $crumbs as $label => $url) {
            $items[] = array_filter([
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $label,
                'item' => $url ? static::url($url) : null,
            ]);
        }

        return ['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => $items];
    }

    public static function product(Product $product): array
    {
        $images = collect([$product->image])->merge($product->gallery ?? [])->filter()->unique()
            ->map(fn ($image) => static::url(Catalog::media($image)))->values()->all();

        $availability = 'https://schema.org/'.($product->in_stock ? 'InStock' : 'OutOfStock');
        $price = fn (int $cents) => number_format($cents / 100, 2, '.', '');

        $offers = $product->price_max > $product->price_min
            ? ['@type' => 'AggregateOffer', 'lowPrice' => $price($product->price_min), 'highPrice' => $price($product->price_max), 'offerCount' => max(1, $product->variations->count())]
            : ['@type' => 'Offer', 'price' => $price($product->price_min)];

        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $product->name,
            'url' => static::url(route('product', $product)),
            'image' => $images,
            'description' => static::text($product->description ?: $product->short_description, 500),
            'sku' => $product->slug,
            'brand' => ['@type' => 'Brand', 'name' => config('site.name')],
            'category' => $product->categories->first()?->name,
            'offers' => $offers + [
                'priceCurrency' => 'USD',
                'availability' => $availability,
                'url' => static::url(route('product', $product)),
                'seller' => ['@id' => static::url('/').'/#business'],
            ],
        ]);
    }

    /** @param array<array{q: string, a: string}> $items */
    public static function faq(array $items): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => array_map(fn ($item) => [
                '@type' => 'Question',
                'name' => $item['q'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => static::text($item['a'], 2000)],
            ], $items),
        ];
    }
}
