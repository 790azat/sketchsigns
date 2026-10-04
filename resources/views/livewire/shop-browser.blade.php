<div>
    <div class="mb-8 flex flex-col gap-3 rounded-2xl border border-slate-200 bg-paper p-3 sm:flex-row sm:items-center">
        <div class="relative flex-1">
            <svg class="pointer-events-none absolute top-1/2 left-3.5 size-5 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
            <input type="search" wire:model.live.debounce.250ms="search" placeholder="Search banners, metal signs, decals…" class="field !rounded-full pl-11" aria-label="Search products">
        </div>
        @unless ($lockCategory)
            <select wire:model.live="category" class="field !w-auto !rounded-full" aria-label="Category">
                <option value="">All categories</option>
                @foreach ($categories as $c)
                    <option value="{{ $c['slug'] }}">{{ $c['name'] }}</option>
                @endforeach
            </select>
        @endunless
        <select wire:model.live="sort" class="field !w-auto !rounded-full" aria-label="Sort">
            <option value="featured">Featured</option>
            <option value="price-asc">Price: low to high</option>
            <option value="price-desc">Price: high to low</option>
            <option value="name">Name A–Z</option>
        </select>
    </div>

    <p class="mb-4 text-sm text-ink-soft" wire:loading.class="opacity-50">{{ $products->total() }} {{ Str::plural('product', $products->total()) }}</p>

    @if ($products->isEmpty())
        <div class="rounded-2xl border border-dashed border-slate-300 p-12 text-center">
            <p class="font-semibold">No products match “{{ $search }}”.</p>
            <p class="mt-1 text-sm text-ink-soft">Can't find it? We make custom orders every day.</p>
            <a href="{{ route('quote') }}" class="btn-primary mt-5">Request a Quote</a>
        </div>
    @else
        <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4" wire:loading.class="opacity-60">
            @foreach ($products as $product)
                <x-product-card :product="$product" wire:key="{{ $product->slug }}" />
            @endforeach
        </div>
        <div class="mt-8">{{ $products->links() }}</div>
    @endif
</div>
