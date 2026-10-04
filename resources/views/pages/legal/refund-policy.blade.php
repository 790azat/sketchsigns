<x-layout title="Returns & Refunds Policy">
    <x-page-hero title="Returns & refunds policy" eyebrow="Shop with confidence" :crumbs="['Refund & Return Policy' => null]">
        If something isn't right with your order, we're here to help.
    </x-page-hero>
    <article class="container-x prose-page max-w-3xl py-12">
        <h2>Personalized product policy</h2>
        <p>Since our products are completely personalized based on your specific requirements and designs, standard returns for refunds are not possible.</p>
        <h2>When we provide refunds or reprints</h2>
        <h3>Manufacturing errors</h3>
        <p>If an error occurs on our end during manufacturing, we will provide a full refund or reprint and ship your order at no additional cost.</p>
        <h3>Shipping damage</h3>
        <p>Take a clear photo of the damaged packaging and product and email it to us. We will offer a full refund or send a replacement at no charge.</p>
        <h3>Design proof mismatches</h3>
        <p>If your printed product differs from the approved digital proof, email us a photo of the product and the approved proof. We will provide a full refund or a corrected replacement.</p>
        <h3>Timeline</h3>
        <ul>
            <li>Production start: within 2 hours of order confirmation</li>
            <li>Issue reporting: within 5 days of delivery</li>
            <li>Reprint / replacement: within standard production time</li>
        </ul>
        <h2>Important reminder</h2>
        <p>The customer is entirely responsible for determining the applicability of the purchase, carefully reviewing every aspect of the final design, spell-checking all text and thoroughly reviewing digital proofs before approval. Once you confirm your order, production begins automatically within 2 hours.</p>
        <h2>Customer errors</h2>
        <p>We cannot offer refunds or exchanges when the error occurred on the customer's end, the product was damaged during or after unpacking, or spelling or design issues were present in the approved proof.</p>
        <h2>Reporting issues</h2>
        <p>Please notify us within five (5) days of delivery by email at <a class="text-brand-600" href="mailto:{{ config('site.email') }}">{{ config('site.email') }}</a> or by phone at <a class="text-brand-600" href="{{ config('site.phone_href') }}">{{ config('site.phone') }}</a>. We will evaluate each issue and provide an appropriate solution.</p>
    </article>
</x-layout>
