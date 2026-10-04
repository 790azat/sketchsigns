@props(['product'])
<a href="{{ route('product', $product['slug']) }}" class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white transition hover:-translate-y-0.5 hover:border-brand-300 hover:shadow-lg">
    <div class="aspect-[5/4] overflow-hidden bg-paper">
        <x-img :src="$product['image']" :alt="$product['name']" class="h-full w-full object-cover transition duration-300 group-hover:scale-105" />
    </div>
    <div class="flex flex-1 flex-col p-4">
        <h3 class="font-semibold text-ink group-hover:text-brand-600">{{ $product['name'] }}</h3>
        <p class="mt-1 line-clamp-2 text-sm text-ink-soft">{{ $product['summary'] }}</p>
        <p class="mt-auto pt-3 text-sm text-ink-soft">From <span class="text-base font-bold text-ink">{{ \App\Support\Catalog::money($product['from']) }}</span></p>
    </div>
</a>
