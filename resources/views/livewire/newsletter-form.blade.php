<div>
    @if ($subscribed)
        <p class="rounded-xl bg-white/10 px-4 py-3 text-sm text-white">Thanks! You're on the list.</p>
    @else
        <form wire:submit="subscribe" class="flex gap-2">
            <label for="newsletter-email" class="sr-only">Email</label>
            <input id="newsletter-email" type="email" wire:model="email" placeholder="you@company.com" required
                   class="min-w-0 flex-1 rounded-full border border-white/20 bg-white/5 px-4 py-2.5 text-sm text-white placeholder:text-white/40 focus:border-brand-400 focus:outline-none">
            <button type="submit" class="btn-primary !px-5 !py-2.5" wire:loading.attr="disabled">Subscribe</button>
        </form>
        @error('email') <p class="mt-1 text-xs text-brand-300">{{ $message }}</p> @enderror
    @endif
</div>
