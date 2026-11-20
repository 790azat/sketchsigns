<x-layout title="FAQ: Orders, Turnaround & Artwork" description="Answers about turnaround times, artwork files, shipping, installation and payment for custom signs and banners from Sketch Signs in Los Angeles." :schema="[\App\Support\Seo::faq(config('site.faq'))]">
    <x-page-hero title="Frequently asked questions" eyebrow="Help center" :crumbs="['FAQ' => null]" />
    <section class="container-x max-w-3xl py-12">
        <x-faq :items="config('site.faq')" />
        <p class="mt-8 text-center text-ink-soft">Didn't find your answer? <a href="{{ route('contact') }}" class="font-semibold text-brand-600">Contact us</a>.</p>
    </section>
</x-layout>
