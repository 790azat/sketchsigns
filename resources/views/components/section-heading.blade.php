@props(['eyebrow' => null, 'title', 'center' => false])
<div {{ $attributes->class(['mb-8 max-w-2xl', 'mx-auto text-center' => $center]) }}>
    @if ($eyebrow)
        <p class="eyebrow">{{ $eyebrow }}</p>
    @endif
    <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-ink sm:text-4xl">{{ $title }}</h2>
    @if ($slot->isNotEmpty())
        <p class="mt-3 text-ink-soft">{{ $slot }}</p>
    @endif
</div>
