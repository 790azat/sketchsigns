@php use App\Support\Catalog; @endphp
<x-layout>
    {{-- Hero --}}
    <section class="relative overflow-hidden bg-ink text-white">
        <div class="absolute inset-0 opacity-25">
            <x-img src="2026/06/aurum-and-co-storefront-metal-sign-installation-1000x800.jpg" alt="" class="h-full w-full object-cover" loading="eager" />
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-ink via-ink/90 to-ink/40"></div>
        <div class="relative container-x grid gap-12 py-20 lg:grid-cols-2 lg:py-28">
            <div>
                <p class="eyebrow text-brand-300">Los Angeles sign shop · Order online</p>
                <h1 class="mt-4 text-4xl font-extrabold tracking-tight sm:text-6xl">Custom Signs, Banners, Displays &amp; Printing</h1>
                <p class="mt-6 max-w-xl text-lg text-white/80">Choose your product, see your price instantly, upload your artwork and check out. Fast turnaround and shipping across California.</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('shop') }}" class="btn-primary !px-8 !py-4 text-base">Shop All Products</a>
                    <a href="{{ route('quote') }}" class="btn border border-white/40 !px-8 !py-4 text-base text-white hover:bg-white/10">Get a Free Quote in 15 Minutes</a>
                </div>
                <dl class="mt-10 grid max-w-lg grid-cols-3 gap-6 border-t border-white/15 pt-6 text-sm">
                    @foreach (config('site.perks') as $perk)
                        <div><dt class="font-bold text-white">{{ $perk['title'] }}</dt></div>
                    @endforeach
                </dl>
            </div>
            <div class="hidden grid-cols-2 gap-4 lg:grid">
                @foreach ($categories->take(4) as $c)
                    <a href="{{ route('category', $c['slug']) }}" class="group relative overflow-hidden rounded-3xl bg-white/5 ring-1 ring-white/10 {{ $loop->odd ? 'translate-y-6' : '' }}">
                        <x-img :src="$c->image ?? $c->products()->value('image')" :alt="$c['name']" class="aspect-square w-full object-cover opacity-90 transition group-hover:scale-105 group-hover:opacity-100" />
                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 p-4">
                            <p class="font-bold">{{ $c['name'] }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Perks --}}
    <section class="border-b border-slate-200 bg-paper">
        <div class="container-x grid gap-6 py-10 md:grid-cols-3">
            @foreach (config('site.perks') as $perk)
                <div class="flex gap-4">
                    <div class="grid size-11 shrink-0 place-items-center rounded-2xl bg-brand-500 font-bold text-white">{{ $loop->iteration }}</div>
                    <div>
                        <h3 class="font-bold">{{ $perk['title'] }}</h3>
                        <p class="text-sm text-ink-soft">{{ $perk['text'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Categories --}}
    <section class="container-x py-16 sm:py-20">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <x-section-heading eyebrow="Shop by category" title="Everything your business needs to get noticed" class="!mb-0" />
            <a href="{{ route('shop') }}" class="btn-ghost">Shop All Products</a>
        </div>
        <div class="mt-10 grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4">
            @foreach ($categories as $c)
                <a href="{{ route('category', $c['slug']) }}" class="group overflow-hidden rounded-2xl border border-slate-200 bg-white transition hover:border-brand-300 hover:shadow-lg">
                    <div class="aspect-square overflow-hidden bg-paper">
                        <x-img :src="$c->image ?? $c->products()->value('image')" :alt="'Shop '.$c['name']" class="h-full w-full object-cover transition duration-300 group-hover:scale-105" />
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold group-hover:text-brand-600">{{ $c['name'] }}</h3>
                    </div>
                </a>
            @endforeach
            <a href="{{ route('quote') }}" class="flex flex-col justify-between rounded-2xl bg-brand-500 p-6 text-white transition hover:bg-brand-600">
                <span class="text-sm font-semibold text-white/80">Something else?</span>
                <span class="text-2xl font-extrabold leading-tight">Need a custom size? Get a quote →</span>
            </a>
        </div>
    </section>

    {{-- Best sellers --}}
    <section class="bg-paper py-16 sm:py-20">
        <div class="container-x">
            <x-section-heading eyebrow="Best sellers" title="Popular products" center>Instant pricing on every product — pick a size and options and see your total before you check out.</x-section-heading>
            <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4">
                @foreach ($featured as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- How it works --}}
    <section class="container-x py-16 sm:py-20">
        <x-section-heading eyebrow="How it works" title="From idea to installed in three steps" center />
        <ol class="grid gap-6 md:grid-cols-3">
            @foreach (config('site.steps') as $step)
                <li class="relative rounded-3xl border border-slate-200 p-8">
                    <span class="text-5xl font-extrabold text-brand-500/20">0{{ $loop->iteration }}</span>
                    <h3 class="mt-2 text-xl font-bold">{{ $step['title'] }}</h3>
                    <p class="mt-2 text-ink-soft">{{ $step['text'] }}</p>
                </li>
            @endforeach
        </ol>
    </section>

    {{-- Industries --}}
    <section class="bg-ink py-16 text-white sm:py-20">
        <div class="container-x">
            <div class="mb-10 max-w-2xl">
                <p class="eyebrow text-brand-300">Industries we serve</p>
                <h2 class="mt-2 text-3xl font-extrabold tracking-tight sm:text-4xl">Signage made for your kind of business</h2>
            </div>
            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($industries as $industry)
                    <a href="{{ route('industry', $industry['slug']) }}" class="group flex items-center justify-between rounded-2xl border border-white/10 bg-white/5 px-5 py-4 transition hover:border-brand-400 hover:bg-white/10">
                        <span class="font-semibold">{{ $industry['name'] }}</span>
                        <span class="text-brand-300 transition group-hover:translate-x-1">→</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Projects --}}
    <section class="container-x py-16 sm:py-20">
        <x-section-heading eyebrow="Recent projects" title="Installed around Los Angeles" />
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach (config('site.projects') as $project)
                <figure class="group relative overflow-hidden rounded-3xl bg-paper">
                    <x-img :src="$project['image']" :alt="$project['title'].' – Los Angeles, CA'" class="aspect-[5/4] w-full object-cover transition duration-500 group-hover:scale-105" />
                    <figcaption class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 p-5 text-white">
                        <p class="font-bold">{{ $project['title'] }}</p>
                        <p class="text-sm text-white/70">Los Angeles, CA</p>
                    </figcaption>
                </figure>
            @endforeach
        </div>
    </section>

    {{-- FAQ --}}
    <section class="bg-paper py-16 sm:py-20">
        <div class="container-x grid gap-10 lg:grid-cols-3">
            <div>
                <p class="eyebrow">FAQ</p>
                <h2 class="mt-2 text-3xl font-extrabold tracking-tight">Frequently asked questions</h2>
                <p class="mt-3 text-ink-soft">Still have questions? Call <a href="{{ config('site.phone_href') }}" class="font-semibold text-brand-600">{{ config('site.phone') }}</a> or email <a href="mailto:{{ config('site.email') }}" class="font-semibold text-brand-600">{{ config('site.email') }}</a>.</p>
                <a href="{{ route('faq') }}" class="btn-ghost mt-6">All FAQs</a>
            </div>
            <div class="lg:col-span-2">
                <x-faq :items="array_slice(config('site.faq'), 0, 4)" />
            </div>
        </div>
    </section>

    <x-cta-band />
</x-layout>
