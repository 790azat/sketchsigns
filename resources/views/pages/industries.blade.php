<x-layout title="Industries We Serve">
    <x-page-hero title="Industries we serve" eyebrow="Signage for every business" :crumbs="['Industries' => null]">
        We make signs, banners, displays and print for businesses all over Los Angeles. Find the products that work best for yours.
    </x-page-hero>
    <section class="container-x grid gap-4 py-12 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($industries as $industry)
            <a href="{{ route('industry', $industry['slug']) }}" class="group rounded-3xl border border-slate-200 p-6 transition hover:border-brand-300 hover:shadow-lg">
                <h2 class="text-xl font-bold group-hover:text-brand-600">{{ $industry['name'] }}</h2>
                <p class="mt-2 text-ink-soft">{{ $industry['intro'] }}</p>
                <p class="mt-4 text-sm font-semibold text-brand-600">See products →</p>
            </a>
        @endforeach
    </section>
    <x-cta-band />
</x-layout>
