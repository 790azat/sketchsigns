<a href="{{ route('cart') }}" class="relative grid size-10 place-items-center rounded-full hover:bg-paper" aria-label="Cart">
    <svg class="size-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4h2l2.4 11.2a2 2 0 0 0 2 1.6h7.7a2 2 0 0 0 2-1.5L21 8H6.2M10 20.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0Zm8 0a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0Z"/></svg>
    @if ($count > 0)
        <span class="absolute -top-0.5 -right-0.5 grid min-w-5 place-items-center rounded-full bg-brand-500 px-1 text-[11px] font-bold text-white">{{ $count }}</span>
    @endif
</a>
