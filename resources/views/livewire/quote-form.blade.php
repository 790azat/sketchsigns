<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
    @if ($sent)
        <div class="py-10 text-center">
            <div class="mx-auto grid size-14 place-items-center rounded-full bg-emerald-100 text-2xl text-emerald-700">✓</div>
            <h2 class="mt-4 text-2xl font-extrabold">Thanks — we got your request!</h2>
            <p class="mt-2 text-ink-soft">Our team will reply with pricing shortly, usually within 15 minutes during business hours ({{ config('site.hours') }}).</p>
            <button type="button" wire:click="$set('sent', false)" class="btn-ghost mt-6">Send another request</button>
        </div>
    @else
        <h2 class="text-2xl font-extrabold">{{ $heading }}</h2>
        <p class="mt-1 text-sm text-ink-soft">No spam. We'll only contact you about your request.</p>
        <form wire:submit="submit" class="mt-6 grid gap-4 sm:grid-cols-2">
            <div class="hidden" aria-hidden="true"><input wire:model="website" tabindex="-1" autocomplete="off"></div>
            <div><label class="label" for="q-name">Name *</label><input id="q-name" wire:model="name" class="field" autocomplete="name">@error('name')<p class="mt-1 text-sm text-brand-700">{{ $message }}</p>@enderror</div>
            <div><label class="label" for="q-company">Company</label><input id="q-company" wire:model="company" class="field" autocomplete="organization"></div>
            <div><label class="label" for="q-email">Email *</label><input id="q-email" type="email" wire:model="email" class="field" autocomplete="email">@error('email')<p class="mt-1 text-sm text-brand-700">{{ $message }}</p>@enderror</div>
            <div><label class="label" for="q-phone">Phone</label><input id="q-phone" type="tel" wire:model="phone" class="field" autocomplete="tel"></div>
            <div>
                <label class="label" for="q-product">Product type</label>
                <select id="q-product" wire:model="product" class="field">
                    <option value="">Not sure yet</option>
                    @foreach ($categories as $c)
                        <option value="{{ $c['name'] }}">{{ $c['name'] }}</option>
                    @endforeach
                    <option value="Channel Letters / Storefront Sign">Channel Letters / Storefront Sign</option>
                    <option value="Installation">Installation</option>
                    <option value="Graphic Design">Graphic Design</option>
                </select>
            </div>
            <div><label class="label" for="q-size">Size</label><input id="q-size" wire:model="size" class="field" placeholder='e.g. 48" x 96"'></div>
            <div><label class="label" for="q-qty">Quantity</label><input id="q-qty" type="number" min="1" wire:model="quantity" class="field">@error('quantity')<p class="mt-1 text-sm text-brand-700">{{ $message }}</p>@enderror</div>
            <div><label class="label" for="q-date">Needed by</label><input id="q-date" type="date" wire:model="needed_by" class="field">@error('needed_by')<p class="mt-1 text-sm text-brand-700">{{ $message }}</p>@enderror</div>
            <div class="sm:col-span-2"><label class="label" for="q-details">Tell us about your project *</label><textarea id="q-details" rows="4" wire:model="details" class="field" placeholder="What are you looking for? Material, where it will go, colors, deadline…"></textarea>@error('details')<p class="mt-1 text-sm text-brand-700">{{ $message }}</p>@enderror</div>
            <div class="sm:col-span-2"><label class="label" for="q-art">Link to your logo or artwork <span class="font-normal text-ink-soft">(Google Drive, Dropbox, WeTransfer…)</span></label><input id="q-art" type="url" wire:model="artwork_link" class="field" placeholder="https://">@error('artwork_link')<p class="mt-1 text-sm text-brand-700">{{ $message }}</p>@enderror</div>
            <div class="sm:col-span-2">
                <button type="submit" class="btn-primary w-full sm:w-auto" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="submit">Get Started</span>
                    <span wire:loading wire:target="submit">Sending…</span>
                </button>
            </div>
        </form>
    @endif
</div>
