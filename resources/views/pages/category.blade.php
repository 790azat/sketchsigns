<x-layout :title="'Custom '.$category['name']" :description="$category['intro']">
    <x-page-hero :title="$category['name']" eyebrow="From {{ \App\Support\Catalog::money($category['from']) }}" :crumbs="['Shop' => route('shop'), $category['name'] => null]">
        {{ $category['intro'] }}
    </x-page-hero>
    <section class="container-x py-12">
        <livewire:shop-browser :category="$category['slug']" />
    </section>
    <x-cta-band />
</x-layout>
