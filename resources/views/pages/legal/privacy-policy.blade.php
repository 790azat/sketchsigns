<x-layout title="Privacy Policy">
    <x-page-hero title="Privacy policy" :crumbs="['Privacy Policy' => null]" />
    <article class="container-x prose-page max-w-3xl py-12">
        <h2>Who we are</h2>
        <p>Sketch Signs Inc, 532 Acacia Ave, Glendale, CA 91205. Our website address is {{ url('/') }}.</p>
        <h2>What we collect</h2>
        <p>When you place an order, request a quote, contact us or subscribe to our newsletter, we collect the information you enter: name, email, phone, company, delivery address, project details and any links you share.</p>
        <h2>How we use it</h2>
        <p>We use this information only to answer your request, produce and deliver your order, send proofs and invoices, and — if you subscribed — send occasional offers and updates. We do not sell your personal information.</p>
        <h2>Cookies</h2>
        <p>We use a session cookie to remember your cart and keep forms secure. It contains no advertising identifiers and expires when your session ends.</p>
        <h2>Embedded content</h2>
        <p>Pages may include images or links from other websites. Those websites may collect data about you as if you had visited them directly.</p>
        <h2>Your rights</h2>
        <p>You can ask us for a copy of the personal data we hold about you, or ask us to delete it, by emailing <a class="text-brand-600" href="mailto:{{ config('site.email') }}">{{ config('site.email') }}</a>. California residents have additional rights under the CCPA.</p>
    </article>
</x-layout>
