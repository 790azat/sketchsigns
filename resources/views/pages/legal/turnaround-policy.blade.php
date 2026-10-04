<x-layout title="Shipping & Turnaround">
    <x-page-hero title="Shipping and turnaround" eyebrow="From concept to completion" :crumbs="['Turnaround Policy' => null]">
        We make sure your order arrives quickly, safely and without any stress — from the moment you order to the moment it reaches your door.
    </x-page-hero>
    <article class="container-x prose-page max-w-3xl py-12">
        <h2>Turnaround time</h2>
        <p>We keep production efficient so you can stay on schedule.</p>
        <ul>
            <li><strong>Standard production:</strong> 2–4 business days after design approval</li>
            <li><strong>Design proofs:</strong> sent within 24 hours</li>
            <li><strong>Large / custom orders:</strong> timeline provided upfront based on scope</li>
        </ul>
        <p>Need it faster? Ask about rush production.</p>
        <h2>Shipping options</h2>
        <ul>
            <li><strong>Standard shipping:</strong> 3–5 business days</li>
            <li><strong>Express shipping:</strong> 1–2 business days</li>
        </ul>
        <p>All orders are shipped using trusted carriers such as UPS, FedEx or USPS.</p>
        <h2>FAQ — shipping & turnaround</h2>
        <h3>How long does production take?</h3>
        <p>Our standard production time is 2–4 business days after design approval. For larger or custom orders, we will provide a timeline before starting production.</p>
        <h3>Do you offer rush orders?</h3>
        <p>Yes — we offer rush and same-day production for select products. Please contact us directly to check availability and pricing.</p>
        <h3>Can I track my order?</h3>
        <p>Yes. Once your order is shipped, you will receive a tracking number via email so you can follow your delivery in real time.</p>
        <h2>Need help?</h2>
        <p>Email <a class="text-brand-600" href="mailto:{{ config('site.email') }}">{{ config('site.email') }}</a> or call <a class="text-brand-600" href="{{ config('site.phone_href') }}">{{ config('site.phone') }}</a>.</p>
    </article>
</x-layout>
