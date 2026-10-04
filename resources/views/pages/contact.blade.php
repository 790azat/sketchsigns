<x-layout title="Contact Us">
    <x-page-hero title="Contact Sketch Signs" eyebrow="We're a call away" :crumbs="['Contact' => null]">
        Questions about an order, a quote or an installation? Reach out — our team answers fast.
    </x-page-hero>
    <section class="container-x grid gap-10 py-12 lg:grid-cols-3">
        <aside class="space-y-4">
            <div class="rounded-2xl bg-paper p-5"><p class="text-sm text-ink-soft">Phone</p><a href="{{ config('site.phone_href') }}" class="text-xl font-bold hover:text-brand-600">{{ config('site.phone') }}</a></div>
            <div class="rounded-2xl bg-paper p-5"><p class="text-sm text-ink-soft">Email</p><a href="mailto:{{ config('site.email') }}" class="text-xl font-bold hover:text-brand-600">{{ config('site.email') }}</a></div>
            <div class="rounded-2xl bg-paper p-5"><p class="text-sm text-ink-soft">Hours</p><p class="font-bold">{{ config('site.hours') }}</p></div>
            <div class="rounded-2xl bg-paper p-5"><p class="text-sm text-ink-soft">Address</p><p class="font-bold">532 Acacia Ave, Glendale, CA 91205</p><p class="text-sm text-ink-soft">Serving {{ config('site.service_area') }}</p></div>
        </aside>
        <div class="lg:col-span-2"><livewire:quote-form heading="Send us a message" /></div>
    </section>
</x-layout>
