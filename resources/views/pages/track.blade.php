<x-layout title="Track Your Order">
    <x-page-hero title="Track your order" eyebrow="Order status" :crumbs="['Track Your Order' => null]">
        Once your order ships, you'll receive a tracking number by email so you can follow your delivery in real time.
    </x-page-hero>
    <section class="container-x max-w-3xl py-12">
        <div class="rounded-3xl bg-paper p-8">
            <h2 class="text-xl font-bold">Need an update on your order?</h2>
            <p class="mt-2 text-ink-soft">Call or email us with your order number (it starts with <span class="font-mono">SS-</span>) and we'll check its status right away.</p>
            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ config('site.phone_href') }}" class="btn-primary">Call {{ config('site.phone') }}</a>
                <a href="mailto:{{ config('site.email') }}?subject=Order%20status" class="btn-ghost">Email {{ config('site.email') }}</a>
            </div>
        </div>
    </section>
</x-layout>
