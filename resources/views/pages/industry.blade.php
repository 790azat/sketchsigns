<x-layout :title="$industry['name'].' Signs & Printing'" :description="$industry['intro']">
    <x-page-hero :title="$industry['name']" eyebrow="Industries we serve" :crumbs="['Industries' => route('industries'), $industry['name'] => null]">
        {{ $industry['intro'] }}
    </x-page-hero>
    <section class="container-x py-12">
        <x-section-heading title="Recommended products" />
        <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
            @foreach ($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </section>
    <x-cta-band />
</x-layout>
