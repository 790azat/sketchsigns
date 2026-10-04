<?php

namespace App\Support;

use App\Models\Category;
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

        return str_starts_with($path, 'http') ? $path : config('site.media_url').'/'.ltrim($path, '/');
    }

    public static function money(int|float $cents): string
    {
        return '$'.number_format($cents / 100, 2);
    }
}
