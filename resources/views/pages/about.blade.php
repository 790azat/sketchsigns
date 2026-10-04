<x-layout title="About Sketch Signs">
    <x-page-hero title="Hello, we're Sketch Signs" eyebrow="Your signage partner from concept to completion" :crumbs="['About' => null]" />
    <section class="container-x grid items-center gap-12 py-16 lg:grid-cols-2">
        <div>
            <p class="eyebrow">Who we are</p>
            <h2 class="mt-2 text-3xl font-extrabold tracking-tight">A Los Angeles sign shop that makes businesses visible</h2>
            <p class="mt-4 text-ink-soft">Sketch Signs is a trusted sign-making company based in Los Angeles, California. We manufacture high-quality custom signs for businesses — from illuminated letters to printed marketing materials.</p>
            <p class="mt-4 text-ink-soft">We believe every business has a story that deserves to be seen. Our custom signs and printing help businesses strengthen their brand, stand apart from competitors and engage customers — with banners, flags, channel letters, wall graphics and more for real estate, restaurants, hospitality, retail, corporate offices, construction and healthcare.</p>
        </div>
        <x-img src="2026/02/custom_design-1000x800.jpg" alt="Professional printing machine during the production of brand graphic designs" class="aspect-[5/4] w-full rounded-3xl object-cover" />
    </section>
    <section class="bg-paper py-16">
        <div class="container-x grid gap-6 md:grid-cols-3">
            @foreach (['High Quality' => 'We use premium-quality materials to ensure long-lasting displays for both indoor and outdoor use.', 'Attention to Detail' => 'We strive to provide professional business signs that align with your brand down to the last pixel.', 'Customer-Driven Attitude' => 'Our customer support specialists are just a call away, ready to guide you through every step.'] as $t => $d)
                <div class="rounded-3xl bg-white p-8"><h3 class="text-xl font-bold">{{ $t }}</h3><p class="mt-2 text-ink-soft">{{ $d }}</p></div>
            @endforeach
        </div>
        <ul class="container-x mt-10 grid gap-3 text-sm font-semibold sm:grid-cols-2 lg:grid-cols-4">
            @foreach (['Free art check on every order', 'Production in 2–4 business days on most products', 'Fast shipping across California', 'Secure checkout'] as $b)
                <li class="flex items-center gap-2 rounded-2xl bg-white px-4 py-3"><span class="text-brand-500">✓</span>{{ $b }}</li>
            @endforeach
        </ul>
    </section>
    <x-cta-band />
</x-layout>
