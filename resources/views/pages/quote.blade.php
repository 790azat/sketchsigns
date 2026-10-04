<x-layout title="Get a Free Quote">
    <x-page-hero title="Get a free quote in 15 minutes" eyebrow="Request a quote" :crumbs="['Get a Free Quote' => null]">
        Sign design, printing, banners, window graphics and installation — tell us about your project and we'll get you exact pricing.
    </x-page-hero>
    <section class="container-x grid gap-10 py-12 lg:grid-cols-3">
        <div class="lg:col-span-2"><livewire:quote-form /></div>
        <aside class="space-y-4">
            @foreach (['Free design support' => 'Our designers check every file and can create artwork from scratch.', 'Fast turnaround' => 'Most orders are produced in 2–4 business days after approval.', 'Professional installation' => 'Licensed & insured installers across Greater Los Angeles.'] as $t => $d)
                <div class="rounded-2xl bg-paper p-5"><p class="font-bold">{{ $t }}</p><p class="mt-1 text-sm text-ink-soft">{{ $d }}</p></div>
            @endforeach
            <div class="rounded-2xl border border-slate-200 p-5 text-sm">
                <p class="font-bold">Prefer to talk?</p>
                <p class="mt-1"><a href="{{ config('site.phone_href') }}" class="text-brand-600">{{ config('site.phone') }}</a> · <a href="mailto:{{ config('site.email') }}" class="text-brand-600">{{ config('site.email') }}</a></p>
                <p class="text-ink-soft">{{ config('site.hours') }}</p>
            </div>
        </aside>
    </section>
</x-layout>
