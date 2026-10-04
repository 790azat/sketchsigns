<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use App\Support\Catalog;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ShopBrowser extends Component
{
    use WithPagination;

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

    public function updating($property): void
    {
        if (in_array($property, ['search', 'category', 'sort'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $category = $this->category ? Category::where('slug', $this->category)->first() : null;
        $like = config('database.default') === 'pgsql' ? 'ilike' : 'like';

        $products = Product::active()
            ->when($category, fn ($q) => $q->whereHas('categories', fn ($c) => $c->whereIn('categories.id', $category->descendantIds())))
            ->when(trim($this->search) !== '', fn ($q) => $q->where(fn ($q) => $q
                ->where('name', $like, '%'.trim($this->search).'%')
                ->orWhere('short_description', $like, '%'.trim($this->search).'%')))
            ->when($this->sort === 'price-asc', fn ($q) => $q->orderBy('price_min'))
            ->when($this->sort === 'price-desc', fn ($q) => $q->orderByDesc('price_min'))
            ->when($this->sort === 'name', fn ($q) => $q->orderBy('name'))
            ->orderBy('position')
            ->paginate(24);

        return view('livewire.shop-browser', [
            'products' => $products,
            'categories' => Catalog::navCategories(),
        ]);
    }
}
