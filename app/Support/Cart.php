<?php

namespace App\Support;

use Illuminate\Support\Str;

/**
 * Session-backed cart. Sessions use the cookie driver, so the cart survives
 * Vercel's stateless serverless functions without a database.
 */
class Cart
{
    private const KEY = 'cart';

    public static function items(): array
    {
        return session(self::KEY, []);
    }

    public static function add(array $item): void
    {
        $items = static::items();
        $items[(string) Str::uuid()] = $item;
        session([self::KEY => $items]);
    }

    public static function updateQuantity(string $id, int $quantity): void
    {
        $items = static::items();

        if (! isset($items[$id])) {
            return;
        }

        $product = Catalog::product($items[$id]['product']);
        if (! $product) {
            static::remove($id);

            return;
        }

        $item = $items[$id];
        $price = Catalog::price($product, $item['size'], $item['options'], max(1, $quantity), $item['width'] ?? null, $item['height'] ?? null);
        $items[$id] = array_merge($item, ['quantity' => max(1, $quantity), 'unit' => $price['unit'], 'total' => $price['total']]);
        session([self::KEY => $items]);
    }

    public static function remove(string $id): void
    {
        $items = static::items();
        unset($items[$id]);
        session([self::KEY => $items]);
    }

    public static function clear(): void
    {
        session()->forget(self::KEY);
    }

    public static function count(): int
    {
        return array_sum(array_column(static::items(), 'quantity'));
    }

    public static function subtotal(): float
    {
        return round(array_sum(array_column(static::items(), 'total')), 2);
    }
}
