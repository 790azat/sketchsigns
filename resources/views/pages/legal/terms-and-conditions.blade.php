<x-layout title="Terms & Conditions">
    <x-page-hero title="Terms & conditions" :crumbs="['Terms & Conditions' => null]" />
    <article class="container-x prose-page max-w-3xl py-12">
        @foreach ([
            'Introduction' => 'These Terms and Conditions apply to this website and to the transactions related to our products and services.',
            'Binding' => 'By using this website you agree to be bound by these Terms. The mere use of this website implies the knowledge and acceptance of these Terms and Conditions.',
            'Electronic communication' => 'By using this website or communicating with us by electronic means, you agree and acknowledge that we may communicate with you electronically.',
            'Intellectual property' => 'We or our licensors own and control all copyright and other intellectual property rights in the website. Unless specific content dictates otherwise, you are not granted a license or any other right under copyright, trademark, patent or other intellectual property rights.',
            'Third-party property' => 'Our website may include hyperlinks to other websites. We do not monitor or review the content of other parties\' websites linked from this website.',
            'Responsible use' => 'You must not use our website or services to use, publish or distribute any material which consists of (or is linked to) malicious computer software.',
            'Orders and proofs' => 'All products are made to order. Production begins once you approve your proof. Please review our Refund & Return Policy for how we handle manufacturing errors and shipping damage.',
            'Idea submission' => 'Do not submit ideas, inventions or works of authorship to us without a written agreement. Unsolicited submissions may be used by us without obligation.',
            'Termination of use' => 'We may, in our sole discretion, at any time modify or discontinue access to the website.',
            'Warranties and liability' => 'This website and all content on it are provided on an "as is" and "as available" basis.',
            'Privacy' => 'You must provide accurate personal information. We will not use your email address for unsolicited mail. See our Privacy Policy.',
            'Accessibility' => 'We are committed to making our content accessible. If you have a disability and cannot access any part of the website, please contact us and we will assist you.',
            'Force majeure' => 'We are not liable for delays or failures caused by events beyond our reasonable control.',
            'Indemnification' => 'You agree to indemnify us against all claims and liabilities arising from your violation of these Terms.',
            'Language' => 'These Terms and Conditions will be interpreted and construed exclusively in English.',
            'Updating terms' => 'We may update these Terms from time to time. Your continued use of the website after changes are posted constitutes acceptance.',
            'Choice of law and jurisdiction' => 'These Terms and Conditions are governed by the laws of the United States and the State of California.',
        ] as $heading => $text)
            <h2>{{ $loop->iteration }}. {{ $heading }}</h2>
            <p>{{ $text }}</p>
        @endforeach
        <h2>Contact information</h2>
        <p>Sketch Signs Inc · 532 Acacia Ave, Glendale, CA 91205 · <a class="text-brand-600" href="mailto:{{ config('site.email') }}">{{ config('site.email') }}</a></p>
    </article>
</x-layout>
