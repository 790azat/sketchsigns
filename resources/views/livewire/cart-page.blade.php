@php use App\Support\Catalog; @endphp
<div>
    @if (empty($items))
        <div class="rounded-3xl border border-dashed border-slate-300 p-16 text-center">
            <p class="text-xl font-bold">Your cart is empty</p>
            <p class="mt-2 text-ink-soft">Pick a product, set your size and options, and see your price instantly.</p>
            <a href="{{ route('shop') }}" class="btn-primary mt-6">Shop All Products</a>
        </div>
    @else
        <div class="grid gap-8 lg:grid-cols-3">
            <div class="space-y-4 lg:col-span-2">
                @foreach ($items as $id => $item)
                    <div wire:key="{{ $id }}" class="flex gap-4 rounded-2xl border border-slate-200 p-4">
                        <x-img :src="$item['image']" :alt="$item['name']" class="size-24 shrink-0 rounded-xl object-cover" />
                        <div class="flex min-w-0 flex-1 flex-col">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <a href="{{ route('product', $item['product']) }}" class="font-semibold hover:text-brand-600">{{ $item['name'] }}</a>
                                    
                                </div>
                                <p class="font-bold">{{ Catalog::money($item['total']) }}</p>
                            </div>
                            <p class="mt-1 text-xs text-ink-soft">
                                {{ collect($item['options'])->filter()->map(fn ($v, $k) => "$k: $v")->implode(' · ') }}
                                @if ($item['artwork'] === 'design') · Design service (+{{ Catalog::money(config('site.design_fee') * 100) }}) @endif
                            </p>
                            <div class="mt-auto flex items-center justify-between pt-3">
                                <div class="flex items-center rounded-full border border-slate-300">
                                    <button type="button" wire:click="decrement('{{ $id }}')" class="grid size-8 place-items-center rounded-full hover:bg-paper" aria-label="Decrease">−</button>
                                    <span class="w-10 text-center text-sm font-semibold">{{ $item['quantity'] }}</span>
                                    <button type="button" wire:click="increment('{{ $id }}')" class="grid size-8 place-items-center rounded-full hover:bg-paper" aria-label="Increase">+</button>
                                </div>
                                <button type="button" wire:click="remove('{{ $id }}')" class="text-sm text-ink-soft hover:text-brand-600">Remove</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <aside class="h-fit rounded-3xl bg-paper p-6">
                <h2 class="text-lg font-bold">Order summary</h2>
                <dl class="mt-4 space-y-2 text-sm">
                    <div class="flex justify-between"><dt>Subtotal</dt><dd class="font-semibold">{{ Catalog::money($subtotal) }}</dd></div>
                    <div class="flex justify-between text-ink-soft"><dt>Shipping</dt><dd>Calculated with invoice</dd></div>
                    <div class="flex justify-between text-ink-soft"><dt>Art check</dt><dd>Free</dd></div>
                </dl>
                <a href="{{ route('checkout') }}" class="btn-primary mt-6 w-full">Checkout</a>
                <a href="{{ route('shop') }}" class="btn-ghost mt-3 w-full">Continue shopping</a>
            </aside>
        </div>
    @endif
</div>
