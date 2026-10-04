<?php

return [

    'name' => 'Sketch Signs',

    'tagline' => 'Custom signs, banners and displays — designed, printed and installed fast across Greater Los Angeles.',

    'description' => 'Order custom signs, banners, displays and printing online. Instant pricing, easy artwork upload, fast turnaround and shipping across California.',

    'announcement' => 'Most orders ship fast — free art check on every order.',

    'email' => env('SITE_EMAIL', 'sales@sketchsigns.com'),

    'phone' => '(213) 753-2121',

    'phone_href' => 'tel:+12137532121',

    'hours' => 'Mon–Fri, 7 AM – 7 PM PT',

    'service_area' => 'Greater Los Angeles, California',

    // Product and project photos are served from the original WordPress media library.
    // Point this at your own CDN / bucket once the old site is switched off.
    'media_url' => rtrim(env('MEDIA_URL', 'https://sketchsigns.com/wp-content/uploads'), '/'),

    'logo' => '2026/03/sketch-signs-logo-icon-270x270.png',

    'social' => [
        'Facebook' => 'https://www.facebook.com/profile.php?id=61575151842212',
        'Instagram' => 'https://www.instagram.com/sketchsigns/',
        'Trustpilot' => 'https://www.trustpilot.com/evaluate/sketchsigns.com',
    ],

    'payments' => ['Visa', 'Mastercard', 'Amex', 'Discover', 'Apple Pay', 'Google Pay', 'Affirm'],

    'perks' => [
        ['title' => 'Free Art Checks', 'text' => 'Every order gets a free file check by a real designer before it prints.'],
        ['title' => '2–4 Day Production', 'text' => 'Most signs, banners and window graphics are produced in 2–4 business days.'],
        ['title' => 'Fast Shipping & Installation', 'text' => 'Fast shipping across California, or professional installation in Los Angeles.'],
    ],

    'steps' => [
        ['title' => 'Pick Your Product & Options', 'text' => 'Choose your sign, banner, or display, then set the size, material, and quantity you need.'],
        ['title' => 'Upload Artwork or Request Design', 'text' => 'Upload print-ready art, or ask our team for help — every order includes a free file check.'],
        ['title' => 'Fast Production & Delivery', 'text' => 'Your order is produced and quality-checked, then ships to your door — or we install it on site.'],
    ],

    'projects' => [
        ['title' => 'Acrylic Lobby Logo', 'image' => '2026/03/office-lobby-sign-1000x800.jpg'],
        ['title' => 'Window Vinyl Graphics', 'image' => '2026/02/clear-window-decals-280x280.jpg'],
        ['title' => 'Metal Storefront Sign', 'image' => '2026/06/aurum-and-co-storefront-metal-sign-installation-1000x800.jpg'],
        ['title' => 'Sidewalk A-Frame Sign', 'image' => '2026/06/coffee-house-storefront-a-frame-sidewalk-sign-1400x403.jpg'],
        ['title' => 'Dimensional Restaurant Signage', 'image' => '2026/06/sel-et-poivre-restaurant-signage-installation-1000x800.png'],
        ['title' => 'Illuminated Channel Letters', 'image' => '2025/08/custom-dimensional-channel-letter-sign-with-a-hexagonal-graphic-logo-mounted-on-a-storefront-facade-1000x800.jpg'],
    ],

    'faq' => [
        [
            'q' => 'How fast is turnaround time?',
            'a' => 'Most signs, banners and window graphics are produced in 2–4 business days after your artwork is approved, plus shipping time. Larger made-to-order items like channel letters typically take 7–10 business days. Exact turnaround is always shown on the product page before you check out.',
        ],
        [
            'q' => 'What artwork file formats are accepted?',
            'a' => 'We accept print-ready PDF, AI, EPS, and high-resolution PNG or JPG files (300 DPI or higher recommended). Don\'t have print-ready art yet? Every order includes a free file check, and our team can help clean up or design your artwork.',
        ],
        [
            'q' => 'Do you offer local sign installation in Los Angeles?',
            'a' => 'Yes — we offer professional installation throughout the Los Angeles area for channel letters, storefront signs, window graphics, and more. Everything else ships to you.',
        ],
        [
            'q' => 'Can I order custom sizes not listed on the site?',
            'a' => 'Yes. Many of our banners, adhesive vinyl, and rigid signs let you enter a custom width and height right on the product page. For a size or material you don\'t see listed, request a free quote and we\'ll get you exact pricing.',
        ],
        [
            'q' => 'Can you design my sign for me?',
            'a' => 'Yes. Our in-house designers can create your artwork from scratch or polish what you have. A $25 design fee applies and is credited toward your order.',
        ],
        [
            'q' => 'Can I order now and upload artwork later?',
            'a' => 'Yes — choose "Buy Now & Upload Later" and send us your artwork within 60 days. Production starts once your proof is approved.',
        ],
    ],

    'industries' => [
        'restaurant-cafe-signs' => [
            'name' => 'Restaurants & Cafés',
            'intro' => 'Storefront signs, menu boards, A-frames and window graphics that bring hungry customers through the door.',
            'products' => ['a-frame-sidewalk-sign', 'channel-letters', 'frosted-window-decals', 'vinyl-banner', 'poster-stand', 'grand-opening-banners'],
        ],
        'retail-signs' => [
            'name' => 'Retail Stores',
            'intro' => 'Sale banners, window clings, floor graphics and in-store displays that move product.',
            'products' => ['removable-window-clings', 'floor-graphics', 'vinyl-banner', 'poster-stand', 'standard-retractable-banner', 'acrylic-wall-signs'],
        ],
        'beauty-printing' => [
            'name' => 'Beauty & Salons',
            'intro' => 'Elegant acrylic wall logos, window decals and printed materials for salons, spas and studios.',
            'products' => ['acrylic-wall-signs', 'frosted-window-decals', 'gift-card', 'a-frame-sidewalk-sign', 'brochures', 'wall-decals'],
        ],
        'auto-repair-shop-signs' => [
            'name' => 'Auto Repair Shops',
            'intro' => 'Durable metal signs, banners, feather flags and car magnets built for the shop floor and the street.',
            'products' => ['metal-signs', 'econo-feather-flag', 'vinyl-banner', 'car-magnets', 'parking-signs', 'safety-signs'],
        ],
        'medical-office-signs' => [
            'name' => 'Medical Offices',
            'intro' => 'Clean lobby signs, wayfinding, window graphics and printed materials for clinics and practices.',
            'products' => ['acrylic-wall-signs', 'frosted-window-decals', 'parking-signs', 'standard-retractable-banner', 'brochures', 'letterhead'],
        ],
        'home-care-signs' => [
            'name' => 'Home Care',
            'intro' => 'Car magnets, yard signs, banners and print products for home care agencies.',
            'products' => ['car-magnets', 'coroplast-yard-signs', 'vinyl-banner', 'standard-retractable-banner', 'brochures', 'letterhead'],
        ],
        'real-estate-signage-printing' => [
            'name' => 'Real Estate',
            'intro' => 'For-sale posts, A-frames, yard signs, flags and property banners for agents and brokerages.',
            'products' => ['real-estate-post', 'real-estate-a-frame', 'coroplast-yard-signs', 'teardrop-flag', 'property-banners', 'car-magnets'],
        ],
        'corporate-business' => [
            'name' => 'Corporate & Business',
            'intro' => 'Lobby logos, lit letters, office signage and branded print for every corner of the office.',
            'products' => ['acrylic-wall-signs', 'premium-acrylic-lit-letters', 'frosted-window-decals', 'standard-retractable-banner', 'letterhead', 'brochures'],
        ],
        'construction-signs' => [
            'name' => 'Construction & Contractors',
            'intro' => 'Fence wraps, mesh banners, safety signs and safety vests for every job site.',
            'products' => ['mesh-fence-banners', 'safety-signs', 'safety-vests', 'coroplast-yard-signs', 'scaffolding-banners', 'metal-signs'],
        ],
        'church-signs-printing' => [
            'name' => 'Churches',
            'intro' => 'Banners, programs, flags and event displays for congregations and ministries.',
            'products' => ['vinyl-banner', 'programs', 'letterhead', 'econo-feather-flag', 'standard-retractable-banner', 'a-frame-sidewalk-sign'],
        ],
        'sports-dance-studios' => [
            'name' => 'Sports & Dance Studios',
            'intro' => 'Wall graphics, banners and event displays for studios, gyms and teams.',
            'products' => ['wall-decals', 'vinyl-banner', 'pole-banner-set', 'step-and-repeat-backdrop', 'custom-birthday-banners', 'floor-graphics'],
        ],
        'event-displays' => [
            'name' => 'Events & Trade Shows',
            'intro' => 'Retractable banners, SEG displays, tents, backdrops and table covers that stand out on the show floor.',
            'products' => ['standard-retractable-banner', '10-ft-seg-fabric-display', '8ft-seg-backlit-popup-display', '10ft-event-tent', 'step-and-repeat-backdrop', '6ft-table-cover'],
        ],
        'wedding-signs' => [
            'name' => 'Weddings & Celebrations',
            'intro' => 'Welcome signs, seating charts, invitations and table numbers for your big day.',
            'products' => ['custom-wedding-invitation', 'seating-chart', 'table-numbers', 'custom-birthday-banners', 'step-and-repeat-backdrop', 'poster-stand'],
        ],
    ],

];
