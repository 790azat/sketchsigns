<?php

namespace App\Livewire;

use App\Models\Order;
use App\Support\Cart;
use App\Support\Catalog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Checkout extends Component
{
    #[Validate('required|string|max:120')]
    public string $name = '';

    #[Validate('required|email|max:160')]
    public string $email = '';

    #[Validate('required|string|max:40')]
    public string $phone = '';

    #[Validate('nullable|string|max:120')]
    public string $company = '';

    #[Validate('required|in:ship,pickup,install')]
    public string $delivery = 'ship';

    #[Validate('required_if:delivery,ship,install|nullable|string|max:255')]
    public string $address = '';

    #[Validate('nullable|string|max:2000')]
    public string $notes = '';

    public ?string $orderNumber = null;

    public function placeOrder()
    {
        $items = Cart::items();

        if (empty($items)) {
            return $this->redirectRoute('cart', navigate: true);
        }

        $data = $this->validate();
        $this->orderNumber = 'SS-'.now()->format('ymd').'-'.Str::upper(Str::random(4));

        $lines = collect($items)->map(function ($item) {
            $options = collect($item['options'])->map(fn ($v, $k) => "$k: $v")->implode(', ');

            return "- {$item['quantity']} × {$item['name']} ({$options}) — artwork: {$item['artwork']} — ".Catalog::money($item['total'])
                .($item['notes'] ? "\n  Notes: {$item['notes']}" : '');
        })->implode("\n");

        $body = "Order {$this->orderNumber}\n\n"
            .collect($data)->filter(fn ($v) => filled($v))->map(fn ($v, $k) => Str::title($k).": $v")->implode("\n")
            ."\n\nItems:\n{$lines}\n\nSubtotal: ".Catalog::money(Cart::subtotal());

        Order::create($data + [
            'number' => $this->orderNumber,
            'items' => array_values($items),
            'subtotal' => Cart::subtotal(),
        ]);

        try {
            Mail::raw($body, fn ($m) => $m
                ->to(config('site.email'))
                ->cc($data['email'])
                ->replyTo($data['email'], $data['name'])
                ->subject("New order {$this->orderNumber}"));
        } catch (\Throwable $e) {
            Log::error('Order email failed', ['error' => $e->getMessage(), 'order' => $body]);
        }

        Cart::clear();
        $this->dispatch('cart-updated');
    }

    public function render()
    {
        return view('livewire.checkout', [
            'items' => Cart::items(),
            'subtotal' => Cart::subtotal(),
        ]);
    }
}
