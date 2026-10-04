<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Variation;
use App\Support\Cart;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ProductConfigurator extends Component
{
    #[Locked]
    public int $productId;

    /** Chosen term slug per option group, keyed by position (group names aren't safe wire:model paths). */
    public array $selected = [];

    public int $quantity = 1;

    public string $artwork = 'upload-later';

    public string $notes = '';

    public bool $added = false;

    public function mount(Product $product): void
    {
        $this->productId = $product->id;

        $first = $product->variations->sortBy('price')->first();
        foreach ($product->optionGroups() as $i => $group) {
            $wanted = $first?->options[$group['name']] ?? '';
            $this->selected[$i] = $wanted !== '' ? $wanted : ($group['terms'][0]['slug'] ?? '');
        }
    }

    #[Computed]
    public function product(): Product
    {
        return Product::with('variations')->findOrFail($this->productId);
    }

    /** @return array<string, string> option name => chosen term slug */
    protected function named(): array
    {
        return collect($this->product->optionGroups())
            ->mapWithKeys(fn ($group, $i) => [$group['name'] => $this->selected[$i] ?? ''])
            ->all();
    }

    #[Computed]
    public function variation(): ?Variation
    {
        return $this->product->findVariation($this->named());
    }

    #[Computed]
    public function total(): ?int
    {
        if (! $this->variation) {
            return null;
        }

        return $this->variation->price * max(1, $this->quantity)
            + ($this->artwork === 'design' ? config('site.design_fee') * 100 : 0);
    }

    public function updated(): void
    {
        $this->added = false;
    }

    public function addToCart(): void
    {
        $product = $this->product;
        $rules = [
            'quantity' => ['required', 'integer', 'min:1', 'max:9999'],
            'artwork' => ['required', Rule::in(['upload-later', 'have', 'design'])],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
        foreach ($product->optionGroups() as $i => $group) {
            $rules['selected.'.$i] = ['required', Rule::in(array_column($group['terms'], 'slug'))];
        }
        $this->validate($rules);

        if (! $this->variation) {
            $this->addError('selected', 'This combination is not available. Please choose different options.');

            return;
        }

        $labels = collect($product->optionGroups())->mapWithKeys(function ($group, $i) {
            $term = collect($group['terms'])->firstWhere('slug', $this->selected[$i] ?? null);

            return [$group['name'] => $term['name'] ?? ''];
        })->all();

        Cart::add([
            'product' => $product->slug,
            'name' => $product->name,
            'image' => $product->image,
            'variation' => $this->variation->id,
            'options' => $labels,
            'artwork' => $this->artwork,
            'notes' => $this->notes,
            'quantity' => $this->quantity,
            'unit' => $this->variation->price,
        ]);

        $this->added = true;
        $this->dispatch('cart-updated');
    }

    public function render()
    {
        return view('livewire.product-configurator');
    }
}
