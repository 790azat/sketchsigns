<?php

namespace App\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Catalog
{
    public static function categories(): Collection
    {
        return collect(config('catalog.categories'))
            ->map(fn (array $category, string $slug) => $category + ['slug' => $slug]);
    }

    public static function category(string $slug): ?array
    {
        return static::categories()->get($slug);
    }

    public static function products(): Collection
    {
        return collect(config('catalog.products'))
            ->map(fn (array $product, string $slug) => $product + [
                'slug' => $slug,
                'from' => static::fromPrice($product),
            ]);
    }

    public static function product(string $slug): ?array
    {
        return static::products()->get($slug);
    }

    public static function inCategory(string $category): Collection
    {
        return static::products()->where('category', $category);
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

    /**
     * Size choices for a product as [key => label].
     */
    public static function sizes(array $product): array
    {
        $pricing = $product['pricing'];

        if ($pricing['type'] === 'fixed') {
            return array_combine(array_keys($pricing['sizes']), array_keys($pricing['sizes']));
        }

        $sizes = [];
        foreach ($pricing['sizes'] as [$w, $h]) {
            $sizes["{$w}x{$h}"] = "{$w}\" x {$h}\"";
        }

        if ($pricing['custom'] ?? false) {
            $sizes['custom'] = 'Custom size';
        }

        return $sizes;
    }

    /**
     * Price of a single item before quantity discounts.
     *
     * @param  array<string, string>  $options  group => choice
     */
    public static function unitPrice(array $product, string $size, array $options = [], ?float $width = null, ?float $height = null): float
    {
        $pricing = $product['pricing'];

        if ($pricing['type'] === 'fixed') {
            $base = (float) ($pricing['sizes'][$size] ?? reset($pricing['sizes']));
        } else {
            if ($size !== 'custom' && str_contains($size, 'x')) {
                [$width, $height] = array_map('floatval', explode('x', $size));
            }
            $width = max(1, (float) $width);
            $height = max(1, (float) $height);
            $base = max($pricing['min'], $width * $height / 144 * $pricing['rate']);
        }

        $multiplier = 1.0;
        $add = 0.0;

        foreach ($product['options'] ?? [] as $group => $choices) {
            $choice = $options[$group] ?? array_key_first($choices);
            $modifier = $choices[$choice] ?? 0;

            if (is_string($modifier) && str_starts_with($modifier, 'x')) {
                $multiplier *= (float) substr($modifier, 1);
            } else {
                $add += (float) $modifier;
            }
        }

        return round($base * $multiplier + $add, 2);
    }

    public static function discountFor(int $quantity): float
    {
        $discount = 0.0;
        foreach (config('catalog.quantity_discounts') as $min => $rate) {
            if ($quantity >= $min) {
                $discount = $rate;
            }
        }

        return $discount;
    }

    /**
     * @return array{unit: float, discount: float, total: float}
     */
    public static function price(array $product, string $size, array $options, int $quantity, ?float $width = null, ?float $height = null): array
    {
        $quantity = max(1, $quantity);
        $unit = static::unitPrice($product, $size, $options, $width, $height);
        $discount = static::discountFor($quantity);
        $total = round($unit * $quantity * (1 - $discount), 2);

        return ['unit' => $unit, 'discount' => $discount, 'total' => $total];
    }

    public static function fromPrice(array $product): float
    {
        $pricing = $product['pricing'];

        if ($pricing['type'] === 'fixed') {
            $base = min($pricing['sizes']);
        } else {
            $base = collect($pricing['sizes'])
                ->map(fn ($s) => max($pricing['min'], $s[0] * $s[1] / 144 * $pricing['rate']))
                ->min();
        }

        $add = collect($product['options'] ?? [])
            ->map(fn ($choices) => Arr::first($choices))
            ->filter(fn ($m) => is_numeric($m))
            ->sum();

        return round($base + $add, 2);
    }

    public static function money(float $amount): string
    {
        return '$'.number_format($amount, 2);
    }
}
