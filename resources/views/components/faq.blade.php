@props(['items'])
<div class="divide-y divide-slate-200 rounded-2xl border border-slate-200 bg-white">
    @foreach ($items as $item)
        <details class="group p-5" @if($loop->first) open @endif>
            <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-semibold text-ink">
                {{ $item['q'] }}
                <span class="grid size-7 shrink-0 place-items-center rounded-full bg-paper text-brand-600 transition group-open:rotate-45">+</span>
            </summary>
            <p class="mt-3 leading-relaxed text-ink-soft">{{ $item['a'] }}</p>
        </details>
    @endforeach
</div>
