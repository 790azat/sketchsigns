<?php

namespace App\Livewire;

use App\Support\Catalog;
use Illuminate\Support\Str;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Url;
use Livewire\Component;

class ShopBrowser extends Component
{
    #[Url(as: 'q', except: '')]
    public string $search = '';

    #[Url(except: '')]
    public string $category = '';

    #[Url(except: 'featured')]
    public string $sort = 'featured';

    #[Locked]
    public bool $lockCategory = false;

    public function mount(?string $category = null): void
    {
        if ($category) {
            $this->category = $category;
            $this->lockCategory = true;
        }
    }

    public function render()
    {
        $products = Catalog::products()
            ->when($this->category, fn ($p) => $p->where('category', $this->category))
            ->when(trim($this->search) !== '', function ($p) {
                $needle = Str::lower(trim($this->search));

                return $p->filter(fn ($product) => Str::contains(Str::lower($product['name'].' '.$product['summary']), $needle));
            });

        $products = match ($this->sort) {
            'price-asc' => $products->sortBy('from'),
            'price-desc' => $products->sortByDesc('from'),
            'name' => $products->sortBy('name'),
            default => $products,
        };

        return view('livewire.shop-browser', [
            'products' => $products,
            'categories' => Catalog::categories(),
        ]);
    }
}
