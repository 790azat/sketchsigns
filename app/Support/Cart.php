<?php

namespace App\Support;

use Illuminate\Support\Str;

/**
 * Session-backed cart. Sessions use the cookie driver, so the cart survives
 * Vercel's stateless functions. Amounts are in cents.
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
        $items[(string) Str::uuid()] = static::withTotal($item);
        session([self::KEY => $items]);
    }

    public static function updateQuantity(string $id, int $quantity): void
    {
        $items = static::items();

        if (isset($items[$id])) {
            $items[$id] = static::withTotal(['quantity' => max(1, min(9999, $quantity))] + $items[$id]);
            session([self::KEY => $items]);
        }
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

    public static function subtotal(): int
    {
        return array_sum(array_column(static::items(), 'total'));
    }

    private static function withTotal(array $item): array
    {
        $item['total'] = $item['unit'] * $item['quantity'] + ($item['artwork'] === 'design' ? config('site.design_fee') * 100 : 0);

        return $item;
    }
}
