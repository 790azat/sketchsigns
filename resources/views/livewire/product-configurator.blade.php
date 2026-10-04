@php use App\Support\Catalog; @endphp
<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
    <form wire:submit="addToCart" class="space-y-5">
        @foreach ($this->product->optionGroups() as $i => $group)
            <fieldset wire:key="group-{{ $i }}">
                <legend class="label">{{ $group['name'] }}</legend>
                @if (count($group['terms']) <= 3)
                    <div class="grid gap-2 {{ count($group['terms']) > 1 ? 'sm:grid-cols-'.count($group['terms']) : '' }}">
                        @foreach ($group['terms'] as $term)
                            <label wire:key="opt-{{ $i }}-{{ $term['slug'] }}" class="flex cursor-pointer items-center justify-center rounded-xl border border-slate-300 px-3 py-2.5 text-center text-sm transition hover:border-ink has-[:checked]:border-brand-500 has-[:checked]:bg-brand-50 has-[:checked]:font-semibold has-[:checked]:text-brand-700">
                                <input type="radio" class="sr-only" value="{{ $term['slug'] }}" wire:model.live="selected.{{ $i }}">
                                {{ $term['name'] }}
                            </label>
                        @endforeach
                    </div>
                @else
                    <select wire:model.live="selected.{{ $i }}" class="field">
                        @foreach ($group['terms'] as $term)
                            <option value="{{ $term['slug'] }}">{{ $term['name'] }}</option>
                        @endforeach
                    </select>
                @endif
                @error('selected.'.$i) <p class="mt-1 text-sm text-brand-700">{{ $message }}</p> @enderror
            </fieldset>
        @endforeach
        @error('selected') <p class="text-sm text-brand-700">{{ $message }}</p> @enderror

        <fieldset>
            <legend class="label">Artwork</legend>
            <div class="grid gap-2">
                @foreach (['upload-later' => 'Buy now & send artwork later (within 60 days)', 'have' => 'I have print-ready artwork — I\'ll email it', 'design' => 'Design it for me (+'.Catalog::money(config('site.design_fee') * 100).')'] as $value => $label)
                    <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-slate-300 px-3 py-2.5 text-sm has-[:checked]:border-brand-500 has-[:checked]:bg-brand-50">
                        <input type="radio" value="{{ $value }}" wire:model.live="artwork" class="accent-brand-500">
                        {{ $label }}
                    </label>
                @endforeach
            </div>
        </fieldset>

        <div>
            <label class="label" for="notes">Notes for our team <span class="font-normal text-ink-soft">(optional)</span></label>
            <textarea id="notes" rows="2" wire:model="notes" class="field" placeholder="Text, colors, deadline…"></textarea>
        </div>

        <div class="flex items-end gap-4">
            <div class="w-28">
                <label class="label" for="quantity">Quantity</label>
                <input id="quantity" type="number" min="1" max="9999" wire:model.live.debounce.300ms="quantity" class="field">
            </div>
            <div class="flex-1 text-right">
                @if ($this->variation)
                    <p class="text-xs text-ink-soft">{{ Catalog::money($this->variation->price) }} each</p>
                    <p class="text-3xl font-extrabold tracking-tight" wire:loading.class="opacity-40">{{ Catalog::money($this->total) }}</p>
                @else
                    <p class="text-sm font-semibold text-brand-700">This combination isn't available</p>
                @endif
            </div>
        </div>
        @error('quantity') <p class="text-sm text-brand-700">{{ $message }}</p> @enderror

        <button type="submit" class="btn-primary w-full !py-3.5 text-base" wire:loading.attr="disabled" wire:target="addToCart" @disabled(! $this->variation || ! $this->product->in_stock)>
            <span wire:loading.remove wire:target="addToCart">Add to Cart</span>
            <span wire:loading wire:target="addToCart">Adding…</span>
        </button>

        @if ($added)
            <div class="flex items-center justify-between gap-3 rounded-xl bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                <span>Added to your cart.</span>
                <a href="{{ route('cart') }}" class="font-semibold underline">View cart →</a>
            </div>
        @endif

        <p class="text-center text-xs text-ink-soft">Free art check · Production in 2–4 business days on most products · Ships across California</p>
    </form>
</div>
