@props(['title' => null, 'description' => null])
@php
    use App\Support\Catalog;
    $categories = Catalog::navCategories();
    $industries = Catalog::industries();
    $pageTitle = $title ? $title.' | '.config('site.name') : config('site.name').' — Custom Signs, Banners & Displays in Los Angeles';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $description ?? config('site.description') }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $description ?? config('site.description') }}">
    <meta property="og:type" content="website">
    @php $canonical = rtrim(config('site.canonical_url'), '/').'/'.ltrim(request()->path(), '/'); @endphp
    <meta property="og:url" content="{{ rtrim($canonical, '/') ?: config('site.canonical_url') }}">
    <link rel="canonical" href="{{ rtrim($canonical, '/') ?: config('site.canonical_url') }}">
    @unless (config('site.indexable'))
        <meta name="robots" content="noindex, nofollow">
    @endunless
    <link rel="icon" href="{{ Catalog::media(config('site.logo')) }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-white font-sans text-ink antialiased" x-data="{ mobile: false }">

    {{-- Announcement bar --}}
    <div class="bg-ink text-white">
        <div class="container-x flex h-10 items-center justify-between gap-4 text-xs sm:text-sm">
            <p class="truncate">{{ config('site.announcement') }} <a href="{{ route('shop') }}" class="font-semibold text-brand-300 underline-offset-2 hover:underline">Shop Now</a></p>
            <div class="hidden items-center gap-5 sm:flex">
                <a href="{{ config('site.phone_href') }}" class="hover:text-brand-300">{{ config('site.phone') }}</a>
                <span class="text-white/50">{{ config('site.hours') }}</span>
            </div>
        </div>
    </div>

    {{-- Header --}}
    <header class="sticky top-0 z-40 border-b border-slate-200 bg-white/95 backdrop-blur">
        <div class="container-x flex h-18 items-center gap-6 py-3 xl:hidden">
            <a href="{{ route('home') }}" class="flex shrink-0 items-center gap-2.5">
                <img src="{{ Catalog::media(config('site.logo')) }}" alt="" class="size-10 rounded-lg" onerror="this.style.display='none'">
                <span class="text-xl font-extrabold tracking-tight">Sketch<span class="text-brand-500">Signs</span></span>
            </a>

            <div class="ml-auto flex items-center gap-2">
                <a href="{{ route('quote') }}" class="btn-primary hidden !px-4 !py-2 sm:inline-flex">Get a Quote</a>
                <livewire:cart-counter />
                <button type="button" class="grid size-10 place-items-center rounded-full hover:bg-paper" @click="mobile = !mobile" aria-label="Menu">
                    <svg class="size-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
                </button>
            </div>
        </div>

        {{-- Category menu --}}
        <div class="hidden xl:block">
            <nav class="container-x flex h-18 items-center" aria-label="Main">
                <a href="{{ route('home') }}" class="mr-2 flex shrink-0 items-center gap-2 2xl:mr-6">
                    <img src="{{ Catalog::media(config('site.logo')) }}" alt="" class="size-9 rounded-lg" onerror="this.style.display='none'">
                    <span class="text-lg font-extrabold tracking-tight 2xl:text-xl">Sketch<span class="text-brand-500">Signs</span></span>
                </a>
                <a href="{{ route('shop') }}" class="rounded-full px-1.5 py-2 text-[13px] 2xl:px-2.5 font-semibold whitespace-nowrap hover:bg-paper">Shop All</a>
                @foreach ($categories as $category)
                    <div class="group relative">
                        <a href="{{ route('category', $category['slug']) }}" class="flex items-center gap-1 rounded-full px-1.5 py-2 text-[13px] 2xl:px-2.5 font-medium whitespace-nowrap hover:bg-paper">
                            {{ $category->name }}
                        </a>
                        <div class="invisible absolute top-full left-0 z-50 w-72 translate-y-1 rounded-2xl border border-slate-200 bg-white p-3 opacity-0 shadow-xl transition group-hover:visible group-hover:translate-y-0 group-hover:opacity-100">
                            @foreach ($category->products()->active()->orderBy('position')->limit(8)->get() as $p)
                                <a href="{{ route('product', $p['slug']) }}" class="flex items-center gap-3 rounded-xl p-2 text-sm hover:bg-paper">
                                    <x-img :src="$p['image']" alt="" class="size-10 rounded-lg object-cover" />
                                    <span>{{ $p['name'] }}</span>
                                </a>
                            @endforeach
                            <a href="{{ route('category', $category['slug']) }}" class="mt-1 block rounded-xl px-2 py-2 text-sm font-semibold text-brand-600 hover:bg-brand-50">Shop all {{ $category['name'] }} →</a>
                        </div>
                    </div>
                @endforeach
                <div class="group relative">
                    <a href="{{ route('industries') }}" class="rounded-full px-1.5 py-2 text-[13px] 2xl:px-2.5 font-medium whitespace-nowrap hover:bg-paper">Industries</a>
                    <div class="invisible absolute top-full right-0 z-50 grid w-[30rem] translate-y-1 grid-cols-2 gap-1 rounded-2xl border border-slate-200 bg-white p-3 opacity-0 shadow-xl transition group-hover:visible group-hover:translate-y-0 group-hover:opacity-100">
                        @foreach ($industries as $industry)
                            <a href="{{ route('industry', $industry['slug']) }}" class="rounded-xl px-3 py-2 text-sm hover:bg-paper">{{ $industry['name'] }}</a>
                        @endforeach
                    </div>
                </div>
                <div class="ml-auto flex items-center gap-2">
                    <a href="{{ route('quote') }}" class="btn-primary !px-4 !py-2">Get a Quote</a>
                    <livewire:cart-counter key="cart-counter-desktop" />
                </div>
            </nav>
        </div>

        {{-- Mobile menu --}}
        <div x-show="mobile" x-cloak x-transition class="border-t border-slate-200 bg-white xl:hidden">
            <nav class="container-x grid gap-1 py-4">
                <a href="{{ route('shop') }}" class="rounded-xl px-3 py-2 font-semibold hover:bg-paper">Shop All</a>
                @foreach ($categories as $category)
                    <a href="{{ route('category', $category['slug']) }}" class="rounded-xl px-3 py-2 hover:bg-paper">{{ $category['name'] }}</a>
                @endforeach
                <a href="{{ route('industries') }}" class="rounded-xl px-3 py-2 hover:bg-paper">Industries</a>
                <a href="{{ route('about') }}" class="rounded-xl px-3 py-2 hover:bg-paper">About</a>
                <a href="{{ route('contact') }}" class="rounded-xl px-3 py-2 hover:bg-paper">Contact</a>
                <a href="{{ route('quote') }}" class="btn-primary mt-2">Get a Free Quote</a>
            </nav>
        </div>
    </header>

    <main>
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="mt-8 bg-ink text-white/80">
        <div class="container-x grid gap-10 py-14 md:grid-cols-2 lg:grid-cols-5">
            <div class="lg:col-span-2">
                <a href="{{ route('home') }}" class="text-2xl font-extrabold tracking-tight text-white">Sketch<span class="text-brand-400">Signs</span></a>
                <p class="mt-3 max-w-sm text-sm">{{ config('site.tagline') }}</p>
                <ul class="mt-5 space-y-1.5 text-sm">
                    <li><a href="mailto:{{ config('site.email') }}" class="hover:text-white">{{ config('site.email') }}</a></li>
                    <li><a href="{{ config('site.phone_href') }}" class="hover:text-white">{{ config('site.phone') }}</a></li>
                    <li>{{ config('site.hours') }}</li>
                    <li>{{ config('site.service_area') }}</li>
                </ul>
                <div class="mt-6 max-w-sm">
                    <p class="mb-2 text-sm font-semibold text-white">Get special offers, design tips and new product updates</p>
                    <livewire:newsletter-form />
                </div>
            </div>
            <div>
                <h3 class="mb-3 font-semibold text-white">Products</h3>
                <ul class="space-y-2 text-sm">
                    @foreach ($categories as $category)
                        <li><a href="{{ route('category', $category['slug']) }}" class="hover:text-white">{{ $category['name'] }}</a></li>
                    @endforeach
                    <li><a href="{{ route('shop') }}" class="hover:text-white">Shop all products</a></li>
                </ul>
            </div>
            <div>
                <h3 class="mb-3 font-semibold text-white">Company</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('about') }}" class="hover:text-white">About Sketch Signs</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-white">Contact Us</a></li>
                    <li><a href="{{ route('quote') }}" class="hover:text-white">Request a Quote</a></li>
                    <li><a href="{{ route('design') }}" class="hover:text-white">Graphic Design Services</a></li>
                    <li><a href="{{ route('installation') }}" class="hover:text-white">Sign Installation</a></li>
                    <li><a href="{{ route('industries') }}" class="hover:text-white">Industries We Serve</a></li>
                </ul>
            </div>
            <div>
                <h3 class="mb-3 font-semibold text-white">Support & Legal</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('faq') }}" class="hover:text-white">FAQ</a></li>
                    <li><a href="{{ route('track') }}" class="hover:text-white">Track Your Order</a></li>
                    <li><a href="{{ route('legal', 'turnaround-policy') }}" class="hover:text-white">Turnaround Policy</a></li>
                    <li><a href="{{ route('legal', 'refund-policy') }}" class="hover:text-white">Refund & Return Policy</a></li>
                    <li><a href="{{ route('legal', 'terms-and-conditions') }}" class="hover:text-white">Terms & Conditions</a></li>
                    <li><a href="{{ route('legal', 'privacy-policy') }}" class="hover:text-white">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-white/10">
            <div class="container-x flex flex-col items-center justify-between gap-4 py-6 text-xs sm:flex-row">
                <p>© {{ date('Y') }} Sketch Signs Inc. All rights reserved.</p>
                <div class="flex flex-wrap items-center gap-2">
                    @foreach (config('site.payments') as $method)
                        <span class="rounded-md border border-white/15 px-2 py-1">{{ $method }}</span>
                    @endforeach
                </div>
                <div class="flex gap-4">
                    @foreach (config('site.social') as $network => $url)
                        <a href="{{ $url }}" target="_blank" rel="noopener" class="hover:text-white">{{ $network }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
