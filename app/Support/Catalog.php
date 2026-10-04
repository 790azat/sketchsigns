<?php

namespace App\Support;

use App\Models\Category;
use App\Models\Media;
use App\Models\Product;
use Illuminate\Support\Collection;
use Throwable;

class Catalog
{
    /** Top-level categories for the header, footer and home page. */
    public static function navCategories(): Collection
    {
        return once(function () {
            try {
                $query = Category::whereNull('parent_id')->whereHas('products');
                $preferred = config('site.nav_categories', []);

                if ($preferred) {
                    $found = Category::whereIn('slug', $preferred)->get()->sortBy(fn ($c) => array_search($c->slug, $preferred))->values();
                    if ($found->isNotEmpty()) {
                        return $found;
                    }
                }

                return $query->withCount('products')->orderByDesc('products_count')->limit(8)->get()->sortBy('position')->values();
            } catch (Throwable) {
                return collect(); // database not migrated yet
            }
        });
    }

    public static function products(array $slugs): Collection
    {
        if (! $slugs) {
            return collect();
        }

        return Product::active()->whereIn('slug', $slugs)->get()
            ->sortBy(fn ($p) => array_search($p->slug, $slugs))->values();
    }

    public static function industries(): Collection
    {
        return collect(config('site.industries'))
            ->map(fn (array $industry, string $slug) => $industry + ['slug' => $slug]);
    }

    public static function industry(string $slug): ?array
    {
        return static::industries()->get($slug);
    }

    public static function media(?string $path): string
    {
        if (! $path) {
            return asset('images/placeholder.svg');
        }

        $url = str_starts_with($path, 'http') ? $path : config('site.media_url').'/'.ltrim($path, '/');

        $url = static::mirrored()[$url] ?? $url;

        if (str_contains($url, '.blob.vercel-storage.com/')) {
            // Images committed to public/media (see .github/workflows/media.yml) keep their Blob paths.
            if (config('site.local_media')) {
                return asset('media/'.ltrim(parse_url($url, PHP_URL_PATH), '/'));
            }

            // While the Blob store is unavailable, serve the original WordPress copy instead.
            if (config('services.blob.serve_origin')) {
                return static::origins()[$url] ?? $url;
            }
        }

        return $url;
    }

    private static function origins(): array
    {
        return once(function () {
            try {
                return Media::pluck('source_url', 'url')->all();
            } catch (Throwable) {
                return [];
            }
        });
    }

    /** Old-site image URLs already copied to Blob storage (see admin/sync/site-media). */
    public static function siteMediaUrls(): array
    {
        return collect([config('site.logo')])
            ->merge(collect(config('site.projects'))->pluck('image'))
            ->filter()->unique()
            ->map(fn (string $path) => config('site.media_url').'/'.ltrim($path, '/'))
            ->values()->all();
    }

    private static function mirrored(): array
    {
        return once(function () {
            try {
                return Media::whereIn('source_url', static::siteMediaUrls())->pluck('url', 'source_url')->all();
            } catch (Throwable) {
                return [];
            }
        });
    }

    public static function money(int|float $cents): string
    {
        return '$'.number_format($cents / 100, 2);
    }
}
