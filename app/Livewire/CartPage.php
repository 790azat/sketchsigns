<?php

namespace App\Livewire;

use App\Support\Cart;
use Livewire\Component;

class CartPage extends Component
{
    public function increment(string $id): void
    {
        $item = Cart::items()[$id] ?? null;
        if ($item) {
            Cart::updateQuantity($id, $item['quantity'] + 1);
            $this->dispatch('cart-updated');
        }
    }

    public function decrement(string $id): void
    {
        $item = Cart::items()[$id] ?? null;
        if ($item && $item['quantity'] > 1) {
            Cart::updateQuantity($id, $item['quantity'] - 1);
            $this->dispatch('cart-updated');
        }
    }

    public function remove(string $id): void
    {
        Cart::remove($id);
        $this->dispatch('cart-updated');
    }

    public function render()
    {
        return view('livewire.cart-page', [
            'items' => Cart::items(),
            'subtotal' => Cart::subtotal(),
        ]);
    }
}
