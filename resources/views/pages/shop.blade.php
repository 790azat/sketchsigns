<x-layout title="Shop All Products">
    <x-page-hero title="Shop all products" eyebrow="Instant pricing" :crumbs="['Shop' => null]">
        Signs, banners, flags, window graphics, event displays and print — pick a product, set your options and see your price instantly.
    </x-page-hero>
    <section class="container-x py-12">
        <livewire:shop-browser />
    </section>
    <x-cta-band />
</x-layout>
