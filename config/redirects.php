<?php

/*
 * Addresses from the old WordPress/WooCommerce site that have no page of the same
 * address here. Products (/product/{slug}), categories (/product-category/{slug}),
 * industries and the main pages kept their old addresses, so they need no entry.
 * More redirects can be added in the admin panel (SEO → Redirects); those win.
 */
return [
    'paths' => [
        // Old menu landing pages
        '/custom-signs' => '/product-category/signs',
        '/banners' => '/product-category/banner-printing',
        '/custom-flags' => '/product-category/flags',
        '/wall-and-window-graphics' => '/product-category/wall-window-graphics',
        '/a-frame-signs' => '/shop?q=a-frame',
        '/channel-letters' => '/product-category/channel-letters',
        '/printing-services' => '/product-category/print-products',
        '/event-displays' => '/product-category/trade-show-displays',
        '/storefront-signs-los-angeles' => '/product-category/signs',
        '/sign-company-los-angeles' => '/',
        '/templates' => '/graphic-design-services',

        // Policies moved under /policies
        '/turnaround-policy' => '/policies/turnaround-policy',
        '/refund-policy' => '/policies/refund-policy',
        '/terms-and-conditions' => '/policies/terms-and-conditions',
        '/privacy-policy' => '/policies/privacy-policy',

        // Ad landing pages
        '/lp' => '/',
        '/lp/medical' => '/industries-we-serve/medical-office-signs',
        '/lp/real-estate' => '/industries-we-serve/real-estate-signage-printing',
        '/lp/restaurants' => '/industries-we-serve/restaurant-cafe-signs',
        '/industries-we-serve/event-signs-for-better-marketing' => '/industries-we-serve/event-displays',

        // Blog (not carried over yet): send each post to the closest page
        '/blog' => '/',
        '/category/blog' => '/',
        '/restaurant-signage-ideas' => '/industries-we-serve/restaurant-cafe-signs',
        '/choose-the-right-sign-for-your-business-location' => '/product-category/signs',
        '/trends-this-year-current-visual-branding' => '/graphic-design-services',
        '/your-logo-and-artwork-ultimate-for-printing' => '/graphic-design-services',
        '/psychology-of-signage' => '/product-category/signs',
        '/christmas-signage-ideas' => '/product-category/banner-printing',

        // WooCommerce account pages
        '/my-account' => '/track-order',
        '/feed' => '/',
    ],

    // Regex patterns, tried in order after the exact paths. $1… are capture groups.
    'patterns' => [
        '#^/graphic-design-services/.+$#' => '/graphic-design-services',
        '#^/shop/page/\d+$#' => '/shop',
        '#^/product-category/(?:[a-z0-9-]+/)*([a-z0-9-]+)/page/\d+$#' => '/product-category/$1',
        '#^/product-category/(?:[a-z0-9-]+/)+([a-z0-9-]+)$#' => '/product-category/$1',
        '#^/product-category/.+$#' => '/shop',
        '#^/product-tag/.+$#' => '/shop',
        '#^/product/.+$#' => '/shop',
        '#^/(?:my-account|wishlist|compare)/.*$#' => '/track-order',
        '#^/(?:blog|category|tag|author)/.*$#' => '/',
        '#^/.+/feed$#' => '/',
    ],
];
