@php use App\Support\Catalog; @endphp
<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
    <form wire:submit="addToCart" class="space-y-5">
        <div>
            <label class="label" for="size">Size {{ $this->product['pricing']['type'] === 'area' ? '(W x H)' : '' }}</label>
            <select id="size" wire:model.live="size" class="field">
                @foreach ($sizes as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>
            @error('size') <p class="mt-1 text-sm text-brand-700">{{ $message }}</p> @enderror
        </div>

        @if ($size === 'custom')
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="label" for="width">Width (in)</label>
                    <input id="width" type="number" min="6" step="1" wire:model.live.debounce.400ms="width" class="field">
                    @error('width') <p class="mt-1 text-sm text-brand-700">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="label" for="height">Height (in)</label>
                    <input id="height" type="number" min="6" step="1" wire:model.live.debounce.400ms="height" class="field">
                    @error('height') <p class="mt-1 text-sm text-brand-700">{{ $message }}</p> @enderror
                </div>
            </div>
        @endif

        @foreach (array_values($this->product['options'] ?? []) as $i => $choices)
            @php $group = array_keys($this->product['options'])[$i]; @endphp
            <fieldset>
                <legend class="label">{{ $group }}</legend>
                @if (count($choices) <= 3)
                    <div class="grid gap-2 {{ count($choices) > 1 ? 'sm:grid-cols-'.count($choices) : '' }}">
                        @foreach ($choices as $choice => $modifier)
                            <label wire:key="opt-{{ $i }}-{{ $loop->index }}" class="flex cursor-pointer items-center justify-center rounded-xl border px-3 py-2.5 text-center text-sm transition has-[:checked]:border-brand-500 has-[:checked]:bg-brand-50 has-[:checked]:font-semibold has-[:checked]:text-brand-700 border-slate-300 hover:border-ink">
                                <input type="radio" class="sr-only" value="{{ $choice }}" wire:model.live="options.{{ $i }}">
                                {{ $choice }}
                            </label>
                        @endforeach
                    </div>
                @else
                    <select wire:model.live="options.{{ $i }}" class="field">
                        @foreach ($choices as $choice => $modifier)
                            <option value="{{ $choice }}">{{ $choice }}</option>
                        @endforeach
                    </select>
                @endif
                @error('options.'.$i) <p class="mt-1 text-sm text-brand-700">{{ $message }}</p> @enderror
            </fieldset>
        @endforeach

        <fieldset>
            <legend class="label">Artwork</legend>
            <div class="grid gap-2">
                @foreach (['upload-later' => 'Buy now & send artwork later (within 60 days)', 'have' => 'I have print-ready artwork — I\'ll email it', 'design' => 'Design it for me (+'.Catalog::money(config('catalog.design_fee')).')'] as $value => $label)
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
                <input id="quantity" type="number" min="1" max="1000" wire:model.live.debounce.300ms="quantity" class="field">
            </div>
            <div class="flex-1 text-right">
                <p class="text-xs text-ink-soft">
                    {{ Catalog::money($this->price['unit']) }} each
                    @if ($this->price['discount'] > 0)
                        · <span class="font-semibold text-emerald-600">{{ (int) ($this->price['discount'] * 100) }}% bulk discount</span>
                    @endif
                </p>
                <p class="text-3xl font-extrabold tracking-tight" wire:loading.class="opacity-40">{{ Catalog::money($this->price['total']) }}</p>
            </div>
        </div>
        @error('quantity') <p class="text-sm text-brand-700">{{ $message }}</p> @enderror

        <button type="submit" class="btn-primary w-full !py-3.5 text-base" wire:loading.attr="disabled" wire:target="addToCart">
            <span wire:loading.remove wire:target="addToCart">Add to Cart</span>
            <span wire:loading wire:target="addToCart">Adding…</span>
        </button>

        @if ($added)
            <div class="flex items-center justify-between gap-3 rounded-xl bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                <span>Added to your cart.</span>
                <a href="{{ route('cart') }}" class="font-semibold underline">View cart →</a>
            </div>
        @endif

        <p class="text-center text-xs text-ink-soft">Free art check · Production {{ $this->product['turnaround'] }} · Ships across California</p>
    </form>
</div>
