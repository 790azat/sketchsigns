@php use App\Support\Catalog; @endphp
<x-layout :title="$product->name" :description="$product->summary()">
    <section class="container-x py-8 sm:py-12">
        <nav class="mb-6 text-sm text-ink-soft" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-ink">Home</a>
            @if ($category)
                <span class="mx-1.5">/</span>
                <a href="{{ route('category', $category) }}" class="hover:text-ink">{{ $category->name }}</a>
            @endif
            <span class="mx-1.5">/</span>
            <span class="text-ink">{{ $product->name }}</span>
        </nav>

        <div class="grid gap-10 lg:grid-cols-2">
            <div x-data="{ active: @js(Catalog::media($product->image)) }" class="lg:sticky lg:top-28 lg:self-start">
                <div class="overflow-hidden rounded-3xl bg-paper">
                    <img :src="active" src="{{ Catalog::media($product->image) }}" alt="{{ $product->name }}" class="aspect-square w-full object-cover"
                         onerror="this.onerror=null;this.src='{{ asset('images/placeholder.svg') }}'">
                </div>
                @if (count($product->gallery ?? []) > 1)
                    <div class="mt-3 grid grid-cols-5 gap-2">
                        @foreach ($product->gallery as $image)
                            <button type="button" @click="active = @js(Catalog::media($image))" class="overflow-hidden rounded-xl border-2 transition" :class="active === @js(Catalog::media($image)) ? 'border-brand-500' : 'border-transparent'">
                                <x-img :src="$image" :alt="$product->name.' photo '.$loop->iteration" class="aspect-square w-full object-cover" />
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>
            <div>
                @if ($category)
                    <p class="eyebrow">{{ $category->name }}</p>
                @endif
                <h1 class="mt-2 text-3xl font-extrabold tracking-tight sm:text-4xl">{{ $product->name }}</h1>
                <p class="mt-4 text-sm">
                    @if ($product->price_max > $product->price_min)
                        <span class="text-2xl font-extrabold">{{ Catalog::money($product->price_min) }} – {{ Catalog::money($product->price_max) }}</span>
                    @else
                        <span class="text-2xl font-extrabold">{{ Catalog::money($product->price_min) }}</span>
                    @endif
                    · <span class="{{ $product->in_stock ? 'text-emerald-700' : 'text-brand-700' }}">{{ $product->in_stock ? 'In stock' : 'Out of stock' }}</span>
                </p>
                @if ($product->short_description)
                    <div class="rich mt-4 text-ink-soft">{!! $product->short_description !!}</div>
                @endif

                <div class="mt-8">
                    <livewire:product-configurator :product="$product" />
                </div>

                <div class="mt-6 grid gap-3 sm:grid-cols-2">
                    <div class="rounded-2xl bg-paper p-4 text-sm"><p class="font-bold">Need design help?</p><p class="text-ink-soft">Our designers can create your artwork. The {{ Catalog::money(config('site.design_fee') * 100) }} design fee is credited toward your order.</p></div>
                    <div class="rounded-2xl bg-paper p-4 text-sm"><p class="font-bold">Buy now, upload later</p><p class="text-ink-soft">Lock in your order today and send artwork within 60 days.</p></div>
                </div>
                <p class="mt-6 text-sm text-ink-soft">Need a size or material you don't see? <a href="{{ route('quote') }}" class="font-semibold text-brand-600">Request a free quote →</a></p>
            </div>
        </div>

        @if ($product->description)
            <article class="rich prose-page mt-16 max-w-3xl border-t border-slate-200 pt-10">
                {!! $product->description !!}
            </article>
        @endif
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
