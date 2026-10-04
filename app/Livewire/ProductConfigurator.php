<?php

namespace App\Livewire;

use App\Support\Cart;
use App\Support\Catalog;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ProductConfigurator extends Component
{
    #[Locked]
    public string $slug;

    public string $size = '';

    public ?float $width = 24;

    public ?float $height = 36;

    public array $options = [];

    public int $quantity = 1;

    public string $artwork = 'upload-later';

    public string $notes = '';

    public bool $added = false;

    public function mount(string $slug): void
    {
        $this->slug = $slug;
        $product = $this->product;

        $this->size = array_key_first(Catalog::sizes($product));

        // Options are keyed by position: group names like "# of Sides" are not safe wire:model paths.
        foreach (array_values($product['options'] ?? []) as $i => $choices) {
            $this->options[$i] = array_key_first($choices);
        }
    }

    /**
     * @return array<string, string> group name => chosen value
     */
    protected function namedOptions(): array
    {
        $groups = array_keys($this->product['options'] ?? []);

        return collect($groups)->mapWithKeys(fn ($group, $i) => [$group => $this->options[$i] ?? null])->all();
    }

    #[Computed]
    public function product(): array
    {
        return Catalog::product($this->slug) ?? abort(404);
    }

    #[Computed]
    public function price(): array
    {
        $price = Catalog::price(
            $this->product,
            $this->size,
            $this->namedOptions(),
            max(1, (int) $this->quantity),
            $this->width,
            $this->height,
        );

        if ($this->artwork === 'design') {
            $price['total'] += config('catalog.design_fee');
        }

        return $price;
    }

    public function updated(): void
    {
        $this->added = false;
    }

    public function addToCart(): void
    {
        $this->validate($this->rules());

        $product = $this->product;
        $price = $this->price;
        $sizeLabel = $this->size === 'custom'
            ? "{$this->width}\" x {$this->height}\" (custom)"
            : Catalog::sizes($product)[$this->size];

        Cart::add([
            'product' => $this->slug,
            'name' => $product['name'],
            'image' => $product['image'],
            'size' => $this->size,
            'size_label' => $sizeLabel,
            'width' => $this->size === 'custom' ? $this->width : null,
            'height' => $this->size === 'custom' ? $this->height : null,
            'options' => $this->namedOptions(),
            'artwork' => $this->artwork,
            'notes' => $this->notes,
            'quantity' => (int) $this->quantity,
            'unit' => $price['unit'],
            'total' => $price['total'],
        ]);

        $this->added = true;
        $this->dispatch('cart-updated');
    }

    protected function rules(): array
    {
        $product = $this->product;
        $rules = [
            'size' => ['required', Rule::in(array_keys(Catalog::sizes($product)))],
            'quantity' => ['required', 'integer', 'min:1', 'max:1000'],
            'artwork' => ['required', 'in:upload-later,have,design'],
            'notes' => ['nullable', 'string', 'max:500'],
        ];

        if ($this->size === 'custom') {
            $rules['width'] = ['required', 'numeric', 'min:6', 'max:1740'];
            $rules['height'] = ['required', 'numeric', 'min:6', 'max:114'];
        }

        foreach (array_values($product['options'] ?? []) as $i => $choices) {
            $rules['options.'.$i] = ['required', Rule::in(array_keys($choices))];
        }

        return $rules;
    }

    public function render()
    {
        return view('livewire.product-configurator', [
            'sizes' => Catalog::sizes($this->product),
        ]);
    }
}
