<x-layout title="Professional Sign Installation" description="Professional sign installation for storefronts, offices, restaurants, retail and events across Los Angeles.">
    <x-page-hero title="Professional sign installation" eyebrow="Design · Print · Installation" :crumbs="['Sign Installation' => null]">
        A great sign needs more than quality production — it needs proper installation. We install storefront, office, restaurant, retail and event signage across Los Angeles.
    </x-page-hero>
    <section class="container-x grid gap-12 py-16 lg:grid-cols-2">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight">Need professional sign installation?</h2>
            <p class="mt-4 text-ink-soft">Our team can visit your location, take measurements, review installation requirements and make sure your signage is installed cleanly, safely and correctly.</p>
            <div class="mt-6 flex flex-wrap gap-2">
                @foreach (['On-Site Consultations', 'Professional Installation', 'On-Time Completion'] as $b)
                    <span class="rounded-full bg-brand-50 px-4 py-2 text-sm font-semibold text-brand-700">{{ $b }}</span>
                @endforeach
            </div>
            <h3 class="mt-10 text-xl font-bold">Installation services include</h3>
            <ul class="mt-4 grid gap-2 sm:grid-cols-2">
                @foreach (['Storefront Sign Installation', 'Channel Letter Installation', 'Window Graphic Installation', 'Lobby Sign Installation', 'Vinyl Decal Installation', 'Banner Installation', 'Event Display Installation', 'Dimensional Letter Installation'] as $s)
                    <li class="flex gap-2"><span class="text-brand-500">✓</span>{{ $s }}</li>
                @endforeach
            </ul>
            <div class="mt-10 grid gap-4 sm:grid-cols-2">
                <div class="rounded-3xl bg-paper p-6"><h3 class="font-bold">Interior installations</h3><p class="mt-2 text-sm text-ink-soft">Interior graphics, wall wraps, dimensional logos and branded environments for offices, retail, restaurants and commercial interiors.</p></div>
                <div class="rounded-3xl bg-paper p-6"><h3 class="font-bold">Licensed & insured team</h3><p class="mt-2 text-sm text-ink-soft">Experienced installers, professional equipment and safety standards for commercial projects throughout Los Angeles.</p></div>
            </div>
        </div>
        <div>
            <livewire:quote-form heading="Schedule a site visit" />
        </div>
    </section>
    <section class="bg-paper py-16">
        <div class="container-x max-w-3xl">
            <x-section-heading title="Common questions" />
            <x-faq :items="[
                ['q' => 'Do you provide on-site consultations?', 'a' => 'Yes. Our team can visit your location to review measurements, installation conditions, and recommend the best signage solution for your space.'],
                ['q' => 'Do you handle sign installation permits?', 'a' => 'Yes. We can assist with city permits and installation requirements depending on your location and project type.'],
                ['q' => 'Can you install signs we already purchased?', 'a' => 'In many cases, yes. Contact us with your project details and we\'ll review compatibility and installation requirements.'],
                ['q' => 'Do you remove existing signs?', 'a' => 'Yes. We offer removal and replacement services for storefront signs, channel letters, wall graphics, and more.'],
                ['q' => 'How long does installation take?', 'a' => 'Installation timelines depend on the project size and location, but most standard installations are completed within one to three days after production approval.'],
                ['q' => 'Do you offer interior sign installation?', 'a' => 'Yes. We install wall graphics, dimensional letters, office branding, window vinyl, and other interior signage solutions.'],
            ]" />
        </div>
    </section>
</x-layout>
