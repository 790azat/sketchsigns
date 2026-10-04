@props(['title', 'eyebrow' => null, 'crumbs' => []])
<section class="bg-ink text-white">
    <div class="container-x py-12 sm:py-16">
        @if ($crumbs)
            <nav class="mb-4 text-sm text-white/60" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-white">Home</a>
                @foreach ($crumbs as $label => $url)
                    <span class="mx-1.5">/</span>
                    @if ($url)
                        <a href="{{ $url }}" class="hover:text-white">{{ $label }}</a>
                    @else
                        <span class="text-white/90">{{ $label }}</span>
                    @endif
                @endforeach
            </nav>
        @endif
        @if ($eyebrow)
            <p class="eyebrow text-brand-300">{{ $eyebrow }}</p>
        @endif
        <h1 class="mt-2 max-w-3xl text-4xl font-extrabold tracking-tight sm:text-5xl">{{ $title }}</h1>
        @if ($slot->isNotEmpty())
            <p class="mt-4 max-w-2xl text-lg text-white/75">{{ $slot }}</p>
        @endif
    </div>
</section>
