@php use App\Support\Catalog; @endphp
<div>
    @if ($orderNumber)
        <div class="mx-auto max-w-xl rounded-3xl border border-emerald-200 bg-emerald-50 p-10 text-center">
            <p class="eyebrow !text-emerald-700">Order received</p>
            <h2 class="mt-2 text-3xl font-extrabold">Thank you, {{ $name }}!</h2>
            <p class="mt-3 text-ink-soft">Your order number is <span class="font-bold text-ink">{{ $orderNumber }}</span>. We'll email your proof and a secure payment link to {{ $email }} shortly. Production starts once you approve the proof.</p>
            <p class="mt-3 text-sm text-ink-soft">Send artwork to <a href="mailto:{{ config('site.email') }}?subject={{ $orderNumber }}" class="font-semibold text-brand-600">{{ config('site.email') }}</a> with your order number in the subject.</p>
            <a href="{{ route('shop') }}" class="btn-primary mt-6">Keep Shopping</a>
        </div>
    @elseif (empty($items))
        <div class="rounded-3xl border border-dashed border-slate-300 p-16 text-center">
            <p class="text-xl font-bold">Your cart is empty</p>
            <a href="{{ route('shop') }}" class="btn-primary mt-6">Shop All Products</a>
        </div>
    @else
        <form wire:submit="placeOrder" class="grid gap-8 lg:grid-cols-3">
            <div class="space-y-6 lg:col-span-2">
                <section class="rounded-3xl border border-slate-200 p-6">
                    <h2 class="mb-4 text-lg font-bold">Contact</h2>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div><label class="label" for="c-name">Full name *</label><input id="c-name" wire:model="name" class="field" autocomplete="name">@error('name')<p class="mt-1 text-sm text-brand-700">{{ $message }}</p>@enderror</div>
                        <div><label class="label" for="c-company">Company</label><input id="c-company" wire:model="company" class="field" autocomplete="organization"></div>
                        <div><label class="label" for="c-email">Email *</label><input id="c-email" type="email" wire:model="email" class="field" autocomplete="email">@error('email')<p class="mt-1 text-sm text-brand-700">{{ $message }}</p>@enderror</div>
                        <div><label class="label" for="c-phone">Phone *</label><input id="c-phone" type="tel" wire:model="phone" class="field" autocomplete="tel">@error('phone')<p class="mt-1 text-sm text-brand-700">{{ $message }}</p>@enderror</div>
                    </div>
                </section>
                <section class="rounded-3xl border border-slate-200 p-6">
                    <h2 class="mb-4 text-lg font-bold">Delivery</h2>
                    <div class="grid gap-2 sm:grid-cols-3">
                        @foreach (['ship' => 'Ship to me', 'pickup' => 'Local pickup (Glendale)', 'install' => 'Installation in LA'] as $value => $label)
                            <label class="flex cursor-pointer items-center gap-2 rounded-xl border border-slate-300 px-3 py-3 text-sm has-[:checked]:border-brand-500 has-[:checked]:bg-brand-50">
                                <input type="radio" value="{{ $value }}" wire:model.live="delivery" class="accent-brand-500"> {{ $label }}
                            </label>
                        @endforeach
                    </div>
                    @if ($delivery !== 'pickup')
                        <div class="mt-4"><label class="label" for="c-address">{{ $delivery === 'install' ? 'Installation address' : 'Shipping address' }} *</label><input id="c-address" wire:model="address" class="field" autocomplete="street-address">@error('address')<p class="mt-1 text-sm text-brand-700">{{ $message }}</p>@enderror</div>
                    @endif
                    <div class="mt-4"><label class="label" for="c-notes">Order notes</label><textarea id="c-notes" rows="3" wire:model="notes" class="field" placeholder="Deadline, delivery instructions…"></textarea></div>
                </section>
            </div>
            <aside class="h-fit rounded-3xl bg-paper p-6">
                <h2 class="text-lg font-bold">Your order</h2>
                <ul class="mt-4 space-y-3 text-sm">
                    @foreach ($items as $item)
                        <li class="flex justify-between gap-3"><span>{{ $item['quantity'] }} × {{ $item['name'] }}<br><span class="text-xs text-ink-soft">{{ $item['size_label'] }}</span></span><span class="font-semibold">{{ Catalog::money($item['total']) }}</span></li>
                    @endforeach
                </ul>
                <div class="mt-4 flex justify-between border-t border-slate-300 pt-4 font-bold"><span>Subtotal</span><span>{{ Catalog::money($subtotal) }}</span></div>
                <p class="mt-2 text-xs text-ink-soft">No payment is taken now. We'll check your files and email a proof with a secure payment link. We accept {{ implode(', ', config('site.payments')) }}.</p>
                <button type="submit" class="btn-primary mt-6 w-full" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="placeOrder">Place Order</span>
                    <span wire:loading wire:target="placeOrder">Sending…</span>
                </button>
            </aside>
        </form>
    @endif
</div>
