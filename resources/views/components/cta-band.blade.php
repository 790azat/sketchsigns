<section class="container-x py-16">
    <div class="relative overflow-hidden rounded-3xl bg-brand-500 px-6 py-12 text-white sm:px-12">
        <div class="absolute -top-20 -right-20 size-72 rounded-full bg-white/10"></div>
        <div class="absolute -bottom-24 left-1/3 size-64 rounded-full bg-black/10"></div>
        <div class="relative flex flex-col items-start justify-between gap-6 md:flex-row md:items-center">
            <div>
                <h2 class="text-3xl font-extrabold tracking-tight">Need a custom size? Get a quote.</h2>
                <p class="mt-2 max-w-xl text-white/85">Tell us what you need and we'll reply with exact pricing — usually within 15 minutes during business hours.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('quote') }}" class="btn bg-white text-brand-600 hover:bg-brand-50">Get a Free Quote</a>
                <a href="{{ config('site.phone_href') }}" class="btn border border-white/60 text-white hover:bg-white/10">Call {{ config('site.phone') }}</a>
            </div>
        </div>
    </div>
</section>
