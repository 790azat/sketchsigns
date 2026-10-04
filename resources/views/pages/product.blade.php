@php use App\Support\Catalog; @endphp
<x-layout :title="$product['name']" :description="$product['summary']">
    <section class="container-x py-8 sm:py-12">
        <nav class="mb-6 text-sm text-ink-soft" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-ink">Home</a>
            <span class="mx-1.5">/</span>
            <a href="{{ route('category', $category['slug']) }}" class="hover:text-ink">{{ $category['name'] }}</a>
            <span class="mx-1.5">/</span>
            <span class="text-ink">{{ $product['name'] }}</span>
        </nav>

        <div class="grid gap-10 lg:grid-cols-2">
            <div>
                <div class="overflow-hidden rounded-3xl bg-paper lg:sticky lg:top-28">
                    <x-img :src="$product['image']" :alt="$product['name']" class="aspect-[5/4] w-full object-cover" loading="eager" />
                </div>
            </div>
            <div>
                <p class="eyebrow">{{ $category['name'] }}</p>
                <h1 class="mt-2 text-3xl font-extrabold tracking-tight sm:text-4xl">{{ $product['name'] }}</h1>
                <p class="mt-3 text-lg text-ink-soft">{{ $product['summary'] }}</p>
                <p class="mt-4 text-sm">From <span class="text-2xl font-extrabold">{{ Catalog::money($product['from']) }}</span> · <span class="text-emerald-700">In stock</span> · Production {{ $product['turnaround'] }}</p>

                <ul class="mt-6 grid gap-2 sm:grid-cols-2">
                    @foreach ($product['features'] as $feature)
                        <li class="flex items-start gap-2 text-sm"><span class="mt-0.5 text-brand-500">✓</span>{{ $feature }}</li>
                    @endforeach
                </ul>

                <div class="mt-8">
                    <livewire:product-configurator :slug="$product['slug']" />
                </div>

                <div class="mt-6 grid gap-3 sm:grid-cols-2">
                    <div class="rounded-2xl bg-paper p-4 text-sm"><p class="font-bold">Need design help?</p><p class="text-ink-soft">Our designers can create your artwork. The {{ Catalog::money(config('catalog.design_fee')) }} design fee is credited toward your order.</p></div>
                    <div class="rounded-2xl bg-paper p-4 text-sm"><p class="font-bold">Buy now, upload later</p><p class="text-ink-soft">Lock in your order today and send artwork within 60 days.</p></div>
                </div>
                <p class="mt-6 text-sm text-ink-soft">Need a size or material you don't see? <a href="{{ route('quote') }}" class="font-semibold text-brand-600">Request a free quote →</a></p>
            </div>
        </div>
    </section>

    @if ($related->isNotEmpty())
        <section class="bg-paper py-16">
            <div class="container-x">
                <x-section-heading title="You may also like" />
                <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
                    @foreach ($related as $item)
                        <x-product-card :product="$item" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-layout>
