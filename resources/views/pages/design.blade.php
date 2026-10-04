<x-layout title="Graphic Design Services">
    <x-page-hero title="Transform your brand with professional graphic design" eyebrow="Graphic design services" :crumbs="['Graphic Design' => null]">
        Your signs, banners and branded graphics are often the first impression customers have of your business. We design striking, brand-consistent, production-ready artwork.
    </x-page-hero>
    <section class="container-x grid gap-12 py-16 lg:grid-cols-2">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight">Design for every medium</h2>
            <p class="mt-4 text-ink-soft">From storefront signs and vehicle graphics to trade show displays and promotional materials, we create designs that are both visually impactful and ready for production.</p>
            <h3 class="mt-8 text-xl font-bold">We design for</h3>
            <div class="mt-4 grid grid-cols-2 gap-3">
                @foreach (['Retail Stores', 'Restaurants', 'Real Estate Firms', 'Trade Shows & Events'] as $s)
                    <div class="rounded-2xl bg-paper px-4 py-3 font-semibold">{{ $s }}</div>
                @endforeach
            </div>
            <p class="mt-8 rounded-2xl border border-brand-200 bg-brand-50 p-5 text-sm">Ordering online? Choose <strong>“Design it for me”</strong> on any product page. The {{ \App\Support\Catalog::money(config('catalog.design_fee')) }} design fee is credited toward your order.</p>
            <div class="mt-10">
                <x-faq :items="[
                    ['q' => 'Can you work with my existing branding?', 'a' => 'Yes. We can follow your existing brand guidelines or help refresh your visual identity.'],
                    ['q' => 'Do you provide print-ready artwork?', 'a' => 'Absolutely. All final designs are prepared to production specifications.'],
                    ['q' => 'Can you design large-format graphics?', 'a' => 'Yes. We specialize in large-format design for signs, banners, wraps, and displays.'],
                    ['q' => 'Do you offer revisions?', 'a' => 'Yes. We include collaborative revisions to ensure the final design meets your expectations.'],
                ]" />
            </div>
        </div>
        <div><livewire:quote-form heading="Let's create something exceptional" /></div>
    </section>
</x-layout>
