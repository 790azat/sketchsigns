<x-layout title="Page not found">
    <section class="container-x py-24 text-center">
        <p class="eyebrow">404</p>
        <h1 class="mt-2 text-4xl font-extrabold tracking-tight">We couldn't find that page</h1>
        <p class="mx-auto mt-3 max-w-lg text-ink-soft">The page may have moved when we rebuilt our site. Browse the shop or tell us what you need.</p>
        <div class="mt-8 flex justify-center gap-3">
            <a href="{{ route('shop') }}" class="btn-primary">Shop All Products</a>
            <a href="{{ route('quote') }}" class="btn-ghost">Get a Quote</a>
        </div>
    </section>
</x-layout>
