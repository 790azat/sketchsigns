<?php

/*
|--------------------------------------------------------------------------
| Product catalog
|--------------------------------------------------------------------------
|
| Every product, its price model and its options live here, so the shop can
| run on Vercel without a database. Prices are calculated by
| App\Support\Catalog::price().
|
| pricing.type = 'area'  -> rate per square foot, with a minimum price per item.
|                           'sizes' are presets in inches [width, height];
|                           'custom' => true lets the customer type any size.
| pricing.type = 'fixed' -> 'sizes' maps a size label to a price per item.
|
| Option modifiers: a number adds that many dollars per item,
|                   a string like 'x1.6' multiplies the item price.
|
*/

$bannerSizes = [[12, 18], [18, 24], [24, 36], [24, 48], [24, 72], [36, 48], [36, 72], [36, 96], [48, 72], [48, 96], [36, 120], [48, 120]];
$rigidSizes = [[12, 12], [12, 18], [18, 24], [24, 24], [24, 36], [36, 48], [48, 96]];
$decalSizes = [[6, 6], [12, 12], [12, 18], [18, 24], [24, 36], [36, 48]];
$grommets = ['Every 2\' All Sides' => 0, 'Every 2\' Top & Bottom' => 0, 'Every 2\' Left & Right' => 0, '4 Corners Only' => 0, 'No Grommets' => 0];

return [

    'quantity_discounts' => [
        // minimum quantity => discount
        5 => 0.05,
        10 => 0.10,
        25 => 0.15,
        50 => 0.20,
    ],

    'design_fee' => 25,

    'categories' => [
        'signs' => [
            'nav' => 'Signs',
            'name' => 'Signs',
            'intro' => 'Metal, acrylic, PVC, coroplast and lit signs for storefronts, offices, job sites and events.',
            'image' => '2026/01/product_lifestyle_image-280x280.png',
            'from' => 17,
        ],
        'banners' => [
            'nav' => 'Banners',
            'name' => 'Banners',
            'intro' => 'Vinyl, mesh and fabric banners in any size, with grommets, pole pockets and double-sided printing.',
            'image' => '2026/02/custom-vinyl-banner-printing-280x280.jpg',
            'from' => 10,
        ],
        'flags-fabric' => [
            'nav' => 'Flags & Fabric',
            'name' => 'Flags & Fabric',
            'intro' => 'Feather flags, teardrop flags, backdrops and fitted table covers printed on durable fabric.',
            'image' => '2026/05/directional-feather-flags-280x280.jpg',
            'from' => 79,
        ],
        'wall-window-graphics' => [
            'nav' => 'Graphics',
            'name' => 'Wall & Window Graphics',
            'intro' => 'Frosted decals, clear vinyl, window clings, wall decals, floor graphics and car magnets.',
            'image' => '2026/02/clear-window-decals-280x280.jpg',
            'from' => 12,
        ],
        'event-displays' => [
            'nav' => 'Displays',
            'name' => 'Event Displays',
            'intro' => 'Retractable banners, SEG fabric displays, pop-up walls and event tents for trade shows.',
            'image' => '2025/09/8-ft-seg-backlit-pop-up-display-stand-inside-280x280.jpg',
            'from' => 71,
        ],
        'stands-sidewalk-signs' => [
            'nav' => 'Stands',
            'name' => 'Stands & Sidewalk Signs',
            'intro' => 'A-frame sidewalk signs, poster stands, real estate posts and frames.',
            'image' => '2026/09/a-frame-sidewalk-sign-material-280x280.jpg',
            'from' => 35,
        ],
        'print-products' => [
            'nav' => 'Print',
            'name' => 'Print Products',
            'intro' => 'Brochures, letterhead, programs, gift cards, invitations and branded apparel.',
            'image' => '2025/10/interior-design-tri-fold-brochure-500x400.jpg',
            'from' => 29,
        ],
    ],

    'products' => [

        /* ---------------------------------------------------------------- Signs */

        'metal-signs' => [
            'name' => 'Metal Signs',
            'category' => 'signs',
            'image' => '2025/10/outdoor-metal-sign-500x400.jpg',
            'summary' => 'Rust-proof aluminum signs for storefronts, parking lots and outdoor use.',
            'features' => ['.040" or .080" aluminum', 'UV-printed, fade resistant', 'Rounded corners & mounting holes available', 'Indoor & outdoor'],
            'turnaround' => '2–4 business days',
            'pricing' => ['type' => 'area', 'rate' => 11, 'min' => 17, 'sizes' => $rigidSizes, 'custom' => true],
            'options' => [
                'Thickness' => ['.040" Aluminum' => 0, '.080" Aluminum' => 'x1.35'],
                '# of Sides' => ['Single Sided' => 0, 'Double Sided' => 'x1.5'],
                'Corners' => ['Square' => 0, 'Rounded' => 2],
                'Holes' => ['No Holes' => 0, '2 Holes Top' => 1, '4 Corner Holes' => 2],
            ],
        ],
        'aluminum-sign' => [
            'name' => 'Aluminum Signs',
            'category' => 'signs',
            'image' => '2025/10/outdoor-metal-sign-500x400.jpg',
            'summary' => 'Lightweight aluminum composite (ACM) panels with a premium, flat finish.',
            'features' => ['3mm aluminum composite', 'Weatherproof', 'Great for storefront panels', 'Custom sizes up to 4\' x 8\''],
            'turnaround' => '2–4 business days',
            'pricing' => ['type' => 'area', 'rate' => 12, 'min' => 25, 'sizes' => $rigidSizes, 'custom' => true],
            'options' => [
                '# of Sides' => ['Single Sided' => 0, 'Double Sided' => 'x1.5'],
                'Lamination' => ['None' => 0, 'Gloss' => 'x1.1', 'Matte' => 'x1.1'],
            ],
        ],
        'parking-signs' => [
            'name' => 'Parking Signs',
            'category' => 'signs',
            'image' => '2025/11/no-parking-anytime-tow-away-zone-sign-500x400.jpg',
            'summary' => 'Reflective, code-friendly parking and tow-away signs on aluminum.',
            'features' => ['.080" aluminum', 'Optional reflective vinyl', 'Pre-drilled for posts', 'Custom wording'],
            'turnaround' => '2–4 business days',
            'pricing' => ['type' => 'fixed', 'sizes' => ['12" x 18"' => 29, '18" x 24"' => 45, '24" x 30"' => 65]],
            'options' => [
                'Finish' => ['Standard' => 0, 'Reflective' => 'x1.4'],
                'Holes' => ['2 Holes (Top & Bottom)' => 0, 'No Holes' => 0],
            ],
        ],
        'pvc-signs' => [
            'name' => 'PVC Signs',
            'category' => 'signs',
            'image' => '2026/01/product_lifestyle_image-280x280.png',
            'summary' => 'Rigid, smooth PVC board for indoor signage, displays and point-of-purchase.',
            'features' => ['3mm or 6mm PVC', 'Smooth matte finish', 'Lightweight & rigid', 'Indoor use'],
            'turnaround' => '2–4 business days',
            'pricing' => ['type' => 'area', 'rate' => 7, 'min' => 10, 'sizes' => $rigidSizes, 'custom' => true],
            'options' => [
                'Thickness' => ['3mm' => 0, '6mm' => 'x1.3'],
                '# of Sides' => ['Single Sided' => 0, 'Double Sided' => 'x1.5'],
            ],
        ],
        'acrylic-wall-signs' => [
            'name' => 'Acrylic Wall Signs',
            'category' => 'signs',
            'image' => '2026/06/phoenix-branding-acrylic-wall-sign-500x400.jpg',
            'summary' => 'Glossy acrylic logo signs with standoffs — the classic lobby look.',
            'features' => ['1/4" or 3/8" clear acrylic', 'Second-surface printing', 'Brushed standoffs included', 'Indoor use'],
            'turnaround' => '3–5 business days',
            'pricing' => ['type' => 'area', 'rate' => 30, 'min' => 90, 'sizes' => [[18, 12], [24, 18], [36, 24], [48, 24], [48, 36], [72, 36]], 'custom' => true],
            'options' => [
                'Thickness' => ['1/4" Acrylic' => 0, '3/8" Acrylic' => 'x1.25'],
                'Standoffs' => ['Silver' => 0, 'Black' => 0, 'Gold' => 8],
            ],
        ],
        'premium-acrylic-lit-letters' => [
            'name' => 'Premium Acrylic Lit Letters',
            'category' => 'signs',
            'image' => '2025/10/premium-dimensional-letter-sign-500x400.jpg',
            'summary' => 'Dimensional acrylic letters with LED backlighting for a premium halo glow.',
            'features' => ['Dimensional acrylic letters', 'Energy-efficient LEDs', 'Indoor & outdoor', 'Installation available in LA'],
            'turnaround' => '7–10 business days',
            'pricing' => ['type' => 'fixed', 'sizes' => ['Up to 24" wide' => 450, 'Up to 48" wide' => 850, 'Up to 72" wide' => 1250, 'Up to 96" wide' => 1650]],
            'options' => [
                'Lighting' => ['Halo (Back-lit)' => 0, 'Front-lit' => 'x1.1', 'Dual-lit' => 'x1.25'],
                'LED Color' => ['Cool White' => 0, 'Warm White' => 0, 'RGB' => 'x1.2'],
            ],
        ],
        'channel-letters' => [
            'name' => 'Channel Letters',
            'category' => 'signs',
            'image' => '2025/08/acrylic-face-dual-lit-channel-letters-500x400.jpg',
            'summary' => 'Illuminated storefront channel letters, fabricated and installed in Los Angeles.',
            'features' => ['Aluminum returns, acrylic faces', 'UL-listed LED modules', 'Raceway or flush mount', 'Permit help available'],
            'turnaround' => '7–10 business days',
            'pricing' => ['type' => 'fixed', 'sizes' => ['12" letter height, up to 8 ft' => 1450, '18" letter height, up to 12 ft' => 2350, '24" letter height, up to 16 ft' => 3450]],
            'options' => [
                'Lighting' => ['Front-lit' => 0, 'Halo-lit' => 'x1.1', 'Dual-lit' => 'x1.25'],
                'Mounting' => ['Raceway' => 0, 'Flush Mount' => 150],
                'Installation' => ['Ship Only' => 0, 'Install in LA' => 650],
            ],
        ],
        'coroplast-yard-signs' => [
            'name' => 'Coroplast Yard Signs',
            'category' => 'signs',
            'image' => '2025/08/outdoor-coroplast-yard-signs-custom-design-horizontal-weather-resistant-500x400.jpg',
            'summary' => 'Weather-resistant corrugated plastic signs for lawns, elections and events.',
            'features' => ['4mm coroplast', 'Full-color UV print', 'Waterproof', 'H-stakes available'],
            'turnaround' => '2–3 business days',
            'pricing' => ['type' => 'fixed', 'sizes' => ['12" x 18"' => 12, '18" x 24"' => 15, '24" x 36"' => 24, '36" x 48"' => 45]],
            'options' => [
                '# of Sides' => ['Single Sided' => 0, 'Double Sided' => 'x1.4'],
                'H-Stake' => ['No Stake' => 0, 'Add H-Stake' => 2],
            ],
        ],
        'safety-signs' => [
            'name' => 'Safety Signs',
            'category' => 'signs',
            'image' => '2025/05/site-safety-signs-500x400.jpg',
            'summary' => 'OSHA-style warning and site safety signs for construction and facilities.',
            'features' => ['Aluminum or coroplast', 'High-visibility colors', 'Custom messages', 'Indoor & outdoor'],
            'turnaround' => '2–4 business days',
            'pricing' => ['type' => 'fixed', 'sizes' => ['10" x 14"' => 19, '12" x 18"' => 25, '18" x 24"' => 39]],
            'options' => [
                'Material' => ['Coroplast' => 0, 'Aluminum' => 'x1.5'],
            ],
        ],
        'poster-stand' => [
            'name' => 'Poster Stands',
            'category' => 'signs',
            'image' => '2025/12/poster-stand-500x400.jpg',
            'summary' => 'Freestanding poster displays for lobbies, events and storefronts.',
            'features' => ['Includes printed poster', 'Adjustable height stand', 'Easy graphic swap', 'Indoor use'],
            'turnaround' => '2–4 business days',
            'pricing' => ['type' => 'fixed', 'sizes' => ['18" x 24"' => 59, '24" x 36"' => 79]],
            'options' => [
                'Poster Material' => ['Foam Board' => 0, 'PVC' => 10],
            ],
        ],

        /* -------------------------------------------------------------- Banners */

        'vinyl-banner' => [
            'name' => 'Vinyl Banners',
            'category' => 'banners',
            'image' => '2025/09/vinyl-banner-awareness-500x400.jpg',
            'summary' => 'Eye-catching 13 oz. vinyl banners for promoting businesses, events or information in high-traffic areas.',
            'features' => ['Highly visible', 'UV-resistant', 'Tear-resistant', 'Durable & reusable', 'Up to 9.5\' x 145\''],
            'turnaround' => '2–4 business days',
            'pricing' => ['type' => 'area', 'rate' => 3, 'min' => 10, 'sizes' => $bannerSizes, 'custom' => true],
            'options' => [
                '# of Sides' => ['Single Sided' => 0, 'Double Sided' => 'x1.6'],
                'Material' => ['13oz. Matte Vinyl' => 0, '15oz. Blockout Vinyl' => 'x1.3'],
                'Pole Pocket' => ['No Pole Pockets' => 0, 'With Pole Pockets' => 5],
                'Grommets' => $grommets,
            ],
        ],
        'mesh-fence-banners' => [
            'name' => 'Mesh Fence Banners',
            'category' => 'banners',
            'image' => '2025/06/construction-mesh-banner-buildahome-500x400.jpg',
            'summary' => 'Wind-through mesh banners for fences, construction sites and outdoor venues.',
            'features' => ['8 oz. vinyl mesh', 'Lets wind pass through', 'Hemmed edges', 'Grommets included'],
            'turnaround' => '2–4 business days',
            'pricing' => ['type' => 'area', 'rate' => 3.25, 'min' => 25, 'sizes' => [[36, 72], [48, 96], [72, 120], [72, 240], [72, 600]], 'custom' => true],
            'options' => [
                'Grommets' => $grommets,
                'Zip Ties' => ['No Zip Ties' => 0, 'Add Zip Ties' => 3],
            ],
        ],
        'grand-opening-banners' => [
            'name' => 'Grand Opening Banners',
            'category' => 'banners',
            'image' => '2025/09/custom-design-vinyl-banner-500x400.jpg',
            'summary' => 'Big, bold banners to announce your grand opening — ready to hang.',
            'features' => ['13 oz. vinyl', 'Grommets included', 'Free design templates', 'Indoor & outdoor'],
            'turnaround' => '2–4 business days',
            'pricing' => ['type' => 'area', 'rate' => 3, 'min' => 10, 'sizes' => $bannerSizes, 'custom' => true],
            'options' => [
                '# of Sides' => ['Single Sided' => 0, 'Double Sided' => 'x1.6'],
                'Grommets' => $grommets,
            ],
        ],
        'pole-banner-set' => [
            'name' => 'Pole Banner Sets',
            'category' => 'banners',
            'image' => '2025/06/pole-banner-set-500x400.jpg',
            'summary' => 'Double-sided street pole banners with brackets for campuses, plazas and main streets.',
            'features' => ['18 oz. blockout vinyl', 'Double-sided print', 'Pole pockets top & bottom', 'Bracket hardware option'],
            'turnaround' => '3–5 business days',
            'pricing' => ['type' => 'fixed', 'sizes' => ['18" x 36"' => 89, '24" x 48"' => 119, '30" x 60"' => 159]],
            'options' => [
                'Hardware' => ['Banner Only' => 0, 'With Bracket Set' => 85],
            ],
        ],
        'property-banners' => [
            'name' => 'Property Banners',
            'category' => 'banners',
            'image' => '2026/02/custom-vinyl-banner-printing-280x280.jpg',
            'summary' => 'Now leasing, for sale and coming soon banners for properties and developments.',
            'features' => ['13 oz. vinyl', 'Grommets included', 'Large-format sizes', 'Outdoor ready'],
            'turnaround' => '2–4 business days',
            'pricing' => ['type' => 'area', 'rate' => 3, 'min' => 10, 'sizes' => $bannerSizes, 'custom' => true],
            'options' => [
                '# of Sides' => ['Single Sided' => 0, 'Double Sided' => 'x1.6'],
                'Grommets' => $grommets,
            ],
        ],
        'custom-birthday-banners' => [
            'name' => 'Birthday & Event Banners',
            'category' => 'banners',
            'image' => '2025/09/custom-design-vinyl-banner-500x400.jpg',
            'summary' => 'Personalized banners for birthdays, graduations, showers and parties.',
            'features' => ['Vivid full-color print', 'Indoor & outdoor', 'Grommets included', 'Free design help'],
            'turnaround' => '2–3 business days',
            'pricing' => ['type' => 'area', 'rate' => 3, 'min' => 10, 'sizes' => $bannerSizes, 'custom' => true],
            'options' => [
                'Grommets' => $grommets,
            ],
        ],
        'scaffolding-banners' => [
            'name' => 'Scaffolding Banners',
            'category' => 'banners',
            'image' => '2025/06/construction-mesh-banner-buildahome-500x400.jpg',
            'summary' => 'Oversized mesh wraps for scaffolding and building facades.',
            'features' => ['Heavy-duty mesh', 'Reinforced hems', 'Grommets every 2\'', 'Custom sizes'],
            'turnaround' => '3–5 business days',
            'pricing' => ['type' => 'area', 'rate' => 2.75, 'min' => 95, 'sizes' => [[96, 240], [120, 360], [144, 480]], 'custom' => true],
            'options' => [
                'Grommets' => ['Every 2\' All Sides' => 0],
            ],
        ],

        /* -------------------------------------------------------- Flags & Fabric */

        'econo-feather-flag' => [
            'name' => 'Feather Flags',
            'category' => 'flags-fabric',
            'image' => '2025/07/econo-feather-flag-500x400.jpg',
            'summary' => 'Tall, eye-catching feather flags that wave customers in from the street.',
            'features' => ['Polyester knit fabric', 'Dye-sublimation print', 'Pole kit & base options', 'Carry bag included'],
            'turnaround' => '3–5 business days',
            'pricing' => ['type' => 'fixed', 'sizes' => ['Small (8.5 ft)' => 79, 'Medium (11.5 ft)' => 99, 'Large (14.5 ft)' => 129]],
            'options' => [
                'Print' => ['Single Sided' => 0, 'Double Sided' => 'x1.5'],
                'Base' => ['Ground Spike' => 0, 'Cross Base + Water Bag' => 25],
            ],
        ],
        'teardrop-flag' => [
            'name' => 'Teardrop Flags',
            'category' => 'flags-fabric',
            'image' => '2025/07/real-estate-teardrop-flag-500x400.jpg',
            'summary' => 'Teardrop-shaped flags that stay taut and readable in any wind.',
            'features' => ['Polyester knit fabric', 'Dye-sublimation print', 'Spinning hardware', 'Carry bag included'],
            'turnaround' => '3–5 business days',
            'pricing' => ['type' => 'fixed', 'sizes' => ['Small (7 ft)' => 85, 'Medium (10 ft)' => 109, 'Large (13 ft)' => 139]],
            'options' => [
                'Print' => ['Single Sided' => 0, 'Double Sided' => 'x1.5'],
                'Base' => ['Ground Spike' => 0, 'Cross Base + Water Bag' => 25],
            ],
        ],
        'feather-angled-flag' => [
            'name' => 'Feather Angled Flags',
            'category' => 'flags-fabric',
            'image' => '2025/07/feather-angled-flag-500x400.jpg',
            'summary' => 'Angled-top feather flags with a sharp, modern silhouette.',
            'features' => ['Polyester knit fabric', 'Vivid colors', 'Pole kit included', 'Indoor & outdoor'],
            'turnaround' => '3–5 business days',
            'pricing' => ['type' => 'fixed', 'sizes' => ['Small (8 ft)' => 85, 'Medium (11 ft)' => 105, 'Large (14 ft)' => 135]],
            'options' => [
                'Print' => ['Single Sided' => 0, 'Double Sided' => 'x1.5'],
                'Base' => ['Ground Spike' => 0, 'Cross Base + Water Bag' => 25],
            ],
        ],
        'step-and-repeat-backdrop' => [
            'name' => 'Step & Repeat Backdrops',
            'category' => 'flags-fabric',
            'image' => '2025/06/step-and-repeat-backdrop-gallery-design-500x400.jpg',
            'summary' => 'Photo-ready logo backdrops for red carpets, launches and parties.',
            'features' => ['Wrinkle-resistant fabric or vinyl', 'Matte, glare-free finish', 'Telescopic stand option', 'Carry bag included'],
            'turnaround' => '3–5 business days',
            'pricing' => ['type' => 'fixed', 'sizes' => ['8\' x 8\'' => 229, '8\' x 10\'' => 269, '8\' x 12\'' => 309]],
            'options' => [
                'Material' => ['Vinyl' => 0, 'Fabric' => 'x1.2'],
                'Stand' => ['Backdrop Only' => 0, 'With Telescopic Stand' => 89],
            ],
        ],
        '6ft-table-cover' => [
            'name' => '6ft Table Cover',
            'category' => 'flags-fabric',
            'image' => '2026/08/6-Table-Throw_Artboard-22-copy-130-1-500x400.jpg',
            'summary' => 'Fitted or draped table covers that turn any 6 ft table into a branded booth.',
            'features' => ['Wrinkle-resistant polyester', 'Machine washable', 'Flame retardant', 'Full-color print'],
            'turnaround' => '3–5 business days',
            'pricing' => ['type' => 'fixed', 'sizes' => ['Front Panel Print' => 149, 'Full Color All Over' => 219]],
            'options' => [
                'Style' => ['Draped (4 sides)' => 0, 'Draped (3 sides, open back)' => 0, 'Fitted' => 20],
            ],
        ],

        /* ------------------------------------------------ Wall & Window Graphics */

        'frosted-window-decals' => [
            'name' => 'Frosted Window Decals',
            'category' => 'wall-window-graphics',
            'image' => '2026/09/frosted-window-decals_-500x400.jpg',
            'summary' => 'Etched-glass look for privacy, logos and office glass.',
            'features' => ['Frosted etched-glass vinyl', 'Cut or printed designs', 'Easy application', 'Removable'],
            'turnaround' => '2–4 business days',
            'pricing' => ['type' => 'area', 'rate' => 8, 'min' => 12, 'sizes' => $decalSizes, 'custom' => true],
            'options' => [
                'Style' => ['Full Frost' => 0, 'Cut Logo / Lettering' => 'x1.3'],
            ],
        ],
        'clear-adhesive-vinyl' => [
            'name' => 'Clear Adhesive Vinyl',
            'category' => 'wall-window-graphics',
            'image' => '2025/10/clear-adhesive-vinyl-500x400.jpg',
            'summary' => 'Transparent vinyl decals that make your logo look printed right on the glass.',
            'features' => ['Optically clear vinyl', 'White ink option', 'Indoor & outdoor', 'Custom shapes'],
            'turnaround' => '2–4 business days',
            'pricing' => ['type' => 'area', 'rate' => 8, 'min' => 12, 'sizes' => $decalSizes, 'custom' => true],
            'options' => [
                'White Ink' => ['No White Ink' => 0, 'White Underlay' => 'x1.2'],
                'Cut' => ['Rectangle' => 0, 'Contour Cut' => 'x1.15'],
            ],
        ],
        'car-magnets' => [
            'name' => 'Car Magnets',
            'category' => 'wall-window-graphics',
            'image' => '2025/07/car-magnets-car-rental-500x400.png',
            'summary' => 'Removable vehicle magnets that turn any car into a moving billboard.',
            'features' => ['30 mil magnetic sheet', 'Rounded corners', 'UV-resistant print', 'Sold individually'],
            'turnaround' => '2–4 business days',
            'pricing' => ['type' => 'fixed', 'sizes' => ['12" x 18"' => 29, '12" x 24"' => 35, '18" x 24"' => 45, '24" x 24"' => 55]],
            'options' => [
                'Corners' => ['Rounded' => 0, 'Square' => 0],
            ],
        ],
        'removable-window-clings' => [
            'name' => 'Removable Window Clings',
            'category' => 'wall-window-graphics',
            'image' => '2026/09/removable-window-clings-500x400.jpg',
            'summary' => 'Adhesive-free static clings for seasonal promos and sale windows.',
            'features' => ['Static cling vinyl', 'No adhesive residue', 'Reusable', 'Indoor-facing or outward'],
            'turnaround' => '2–4 business days',
            'pricing' => ['type' => 'area', 'rate' => 7, 'min' => 12, 'sizes' => $decalSizes, 'custom' => true],
            'options' => [
                'Material' => ['White Cling' => 0, 'Clear Cling' => 'x1.1'],
            ],
        ],
        'wall-decals' => [
            'name' => 'Removable Wall Decals',
            'category' => 'wall-window-graphics',
            'image' => '2025/11/removable-wall-decals-500x400.jpg',
            'summary' => 'Low-tack wall graphics for offices, studios, classrooms and retail.',
            'features' => ['Removable adhesive', 'Matte finish', 'Contour cut', 'Paint-safe'],
            'turnaround' => '2–4 business days',
            'pricing' => ['type' => 'area', 'rate' => 7, 'min' => 10, 'sizes' => $decalSizes, 'custom' => true],
            'options' => [
                'Cut' => ['Rectangle' => 0, 'Contour Cut' => 'x1.15'],
            ],
        ],
        'floor-graphics' => [
            'name' => 'Floor Graphics',
            'category' => 'wall-window-graphics',
            'image' => '2025/08/promotional-floor-decal-500x400.jpg',
            'summary' => 'Slip-resistant floor decals for wayfinding, promotions and distancing.',
            'features' => ['Anti-slip laminate', 'Removable adhesive', 'Custom shapes', 'Indoor use'],
            'turnaround' => '2–4 business days',
            'pricing' => ['type' => 'area', 'rate' => 9, 'min' => 15, 'sizes' => [[12, 12], [18, 18], [24, 24], [36, 36]], 'custom' => true],
            'options' => [
                'Shape' => ['Square / Rectangle' => 0, 'Circle' => 0, 'Custom Contour' => 'x1.15'],
            ],
        ],
        'adhesive-vinyl-decal' => [
            'name' => 'Adhesive Vinyl Decals',
            'category' => 'wall-window-graphics',
            'image' => '2026/02/clear-window-decals-280x280.jpg',
            'summary' => 'Permanent printed vinyl decals for walls, windows, vehicles and equipment.',
            'features' => ['Permanent adhesive', 'Gloss or matte laminate', 'Indoor & outdoor', 'Custom sizes'],
            'turnaround' => '2–4 business days',
            'pricing' => ['type' => 'area', 'rate' => 7, 'min' => 10, 'sizes' => $decalSizes, 'custom' => true],
            'options' => [
                'Lamination' => ['None' => 0, 'Gloss' => 'x1.1', 'Matte' => 'x1.1'],
            ],
        ],

        /* --------------------------------------------------------- Event Displays */

        'standard-retractable-banner' => [
            'name' => 'Retractable Banners',
            'category' => 'event-displays',
            'image' => '2026/03/roll-up-banner-design-500x400.jpg',
            'summary' => 'Roll-up banner stands that set up in seconds for trade shows and lobbies.',
            'features' => ['Aluminum base & pole', 'Anti-curl banner material', 'Carry bag included', 'Replacement graphics available'],
            'turnaround' => '2–4 business days',
            'pricing' => ['type' => 'fixed', 'sizes' => ['33" x 81"' => 71, '47" x 81"' => 109]],
            'options' => [
                'Stand' => ['Standard' => 0, 'Premium' => 40, 'Deluxe (Double Sided)' => 120],
            ],
        ],
        'velcro-fabric-pop-up-display' => [
            'name' => 'Pop Up Displays',
            'category' => 'event-displays',
            'image' => '2025/10/curved-velcro-fabric-pop-up-display-500x400.jpg',
            'summary' => 'Fabric pop-up walls that create an instant booth backdrop.',
            'features' => ['Collapsible aluminum frame', 'Velcro-attached fabric', 'Wheeled case option', 'Reusable'],
            'turnaround' => '3–5 business days',
            'pricing' => ['type' => 'fixed', 'sizes' => ['8 ft' => 649, '10 ft' => 749, '20 ft' => 1399]],
            'options' => [
                'Shape' => ['Straight' => 0, 'Curved' => 'x1.05'],
            ],
        ],
        '10-ft-seg-fabric-display' => [
            'name' => 'SEG Fabric Displays',
            'category' => 'event-displays',
            'image' => '2025/07/10-ft-seg-fabric-display-500x400.jpg',
            'summary' => 'Silicone-edge graphic displays with crisp, frameless fabric walls.',
            'features' => ['Aluminum extrusion frame', 'Dye-sublimated SEG fabric', 'Tool-free assembly', 'Travel case included'],
            'turnaround' => '3–5 business days',
            'pricing' => ['type' => 'fixed', 'sizes' => ['3 ft' => 399, '10 ft' => 1199, '20 ft' => 2199]],
            'options' => [
                'Print' => ['Single Sided' => 0, 'Double Sided' => 'x1.3'],
            ],
        ],
        '8ft-seg-backlit-popup-display' => [
            'name' => 'SEG Backlit Displays',
            'category' => 'event-displays',
            'image' => '2025/09/8-ft-seg-backlit-pop-up-display-stand-inside-500x400.jpg',
            'summary' => 'Glowing LED-backlit fabric walls that own the show floor.',
            'features' => ['Integrated LED lighting', 'Backlit SEG fabric', 'Pop-up frame', 'Case included'],
            'turnaround' => '5–7 business days',
            'pricing' => ['type' => 'fixed', 'sizes' => ['8 ft' => 1699, '10 ft' => 1999]],
            'options' => [
                'Print' => ['Single Sided' => 0, 'Double Sided' => 'x1.25'],
            ],
        ],
        'straight-tension-fabric-display' => [
            'name' => 'Tension Fabric Displays',
            'category' => 'event-displays',
            'image' => '2025/09/tension-fabric-displays-straight-sale-500x400.jpg',
            'summary' => 'Pillowcase fabric displays over a lightweight tube frame.',
            'features' => ['Lightweight tube frame', 'Zip-on fabric graphic', 'Wrinkle resistant', 'Carry bag included'],
            'turnaround' => '3–5 business days',
            'pricing' => ['type' => 'fixed', 'sizes' => ['8 ft' => 349, '10 ft' => 429, '20 ft' => 899]],
            'options' => [
                'Shape' => ['Straight' => 0, 'Curved' => 'x1.1'],
            ],
        ],
        '10ft-event-tent' => [
            'name' => 'Event Tents',
            'category' => 'event-displays',
            'image' => '2025/10/10-ft-pop-up-tent-with-walls-500x400.jpg',
            'summary' => 'Custom printed pop-up canopy tents for outdoor events and markets.',
            'features' => ['Heavy-duty aluminum frame', 'Printed canopy', 'Optional walls', 'Wheeled bag included'],
            'turnaround' => '5–7 business days',
            'pricing' => ['type' => 'fixed', 'sizes' => ['10\' x 10\'' => 799, '10\' x 20\'' => 1499]],
            'options' => [
                'Walls' => ['Canopy Only' => 0, 'Add Back Wall' => 179, 'Full Walls' => 449],
            ],
        ],

        /* ------------------------------------------------ Stands & Sidewalk Signs */

        'a-frame-sidewalk-sign' => [
            'name' => 'A-Frame Sidewalk Signs',
            'category' => 'stands-sidewalk-signs',
            'image' => '2026/09/a-frame-sidewalk-sign-material-500x400.jpg',
            'summary' => 'Classic sidewalk sandwich boards with printed, swappable inserts.',
            'features' => ['Durable frame', 'Two printed inserts', 'Weatherproof', 'Folds flat for storage'],
            'turnaround' => '2–4 business days',
            'pricing' => ['type' => 'fixed', 'sizes' => ['24" x 36"' => 157, '24" x 48"' => 189]],
            'options' => [
                'Frame' => ['Plastic (Black)' => 0, 'Plastic (White)' => 0, 'Metal Frame' => 45],
                'Inserts' => ['Coroplast' => 0, 'PVC' => 15, 'Aluminum' => 35],
            ],
        ],
        'a-frame-banner-display' => [
            'name' => 'A-Frame Banner Stands',
            'category' => 'stands-sidewalk-signs',
            'image' => '2025/07/a-frame-banner-display-coffeeshop-500x400.jpg',
            'summary' => 'Lightweight banner A-frames for cafés, pop-ups and events.',
            'features' => ['Aluminum frame', 'Vinyl banner graphics', 'Water-fillable base option', 'Easy setup'],
            'turnaround' => '2–4 business days',
            'pricing' => ['type' => 'fixed', 'sizes' => ['24" x 36"' => 89, '24" x 48"' => 109]],
            'options' => [
                'Print' => ['Single Sided' => 0, 'Double Sided' => 20],
            ],
        ],
        'real-estate-a-frame' => [
            'name' => 'Real Estate A-Frame Signs',
            'category' => 'stands-sidewalk-signs',
            'image' => '2025/10/real-estate-a-frame-500x400.jpg',
            'summary' => 'Open house A-frames with directional arrows and agent branding.',
            'features' => ['Metal A-frame', 'Coroplast inserts', 'Rider sign slot', 'Fold-flat design'],
            'turnaround' => '2–4 business days',
            'pricing' => ['type' => 'fixed', 'sizes' => ['18" x 24"' => 69, '24" x 24"' => 79]],
            'options' => [
                'Riders' => ['No Rider' => 0, 'Add Rider' => 12],
            ],
        ],
        'real-estate-post' => [
            'name' => 'Real Estate Posts',
            'category' => 'stands-sidewalk-signs',
            'image' => '2025/10/for-sale-real-estate-post_-500x400.jpg',
            'summary' => 'Vinyl lawn posts with a hanging for-sale panel — the listing staple.',
            'features' => ['6 ft vinyl post', 'Hanging sign panel', 'Rider hooks', 'Install available in LA'],
            'turnaround' => '2–4 business days',
            'pricing' => ['type' => 'fixed', 'sizes' => ['Post Only' => 35, 'Post + 18" x 24" Sign' => 79, 'Post + 24" x 36" Sign' => 99]],
            'options' => [
                'Post Color' => ['White' => 0, 'Black' => 0],
            ],
        ],

        /* ---------------------------------------------------------- Print Products */

        'brochures' => [
            'name' => 'Brochures',
            'category' => 'print-products',
            'image' => '2025/10/interior-design-tri-fold-brochure-500x400.jpg',
            'summary' => 'Tri-fold and bi-fold brochures on premium gloss or matte stock.',
            'features' => ['100 lb gloss or matte text', 'Tri-fold or bi-fold', 'Full color both sides', 'Scored & folded'],
            'turnaround' => '3–5 business days',
            'pricing' => ['type' => 'fixed', 'sizes' => ['100 pcs' => 79, '250 pcs' => 129, '500 pcs' => 189, '1000 pcs' => 279]],
            'options' => [
                'Fold' => ['Tri-fold' => 0, 'Bi-fold' => 0],
                'Paper' => ['Gloss' => 0, 'Matte' => 0],
            ],
        ],
        'letterhead' => [
            'name' => 'Letterhead',
            'category' => 'print-products',
            'image' => '2026/07/church-notepad-500x400.jpg',
            'summary' => 'Branded letterhead and notepads on smooth, writable stock.',
            'features' => ['70 lb uncoated text', 'Laser-printer safe', 'Full color', 'Notepad binding option'],
            'turnaround' => '3–5 business days',
            'pricing' => ['type' => 'fixed', 'sizes' => ['250 sheets' => 59, '500 sheets' => 89, '1000 sheets' => 139]],
            'options' => [
                'Format' => ['Loose Sheets' => 0, 'Notepads (50 sheets)' => 'x1.25'],
            ],
        ],
        'programs' => [
            'name' => 'Programs',
            'category' => 'print-products',
            'image' => '2026/07/church-rack-card-500x400.jpg',
            'summary' => 'Event, church and ceremony programs printed and folded.',
            'features' => ['Gloss or matte', 'Flat or folded', 'Full color', 'Fast turnaround'],
            'turnaround' => '2–4 business days',
            'pricing' => ['type' => 'fixed', 'sizes' => ['50 pcs' => 39, '100 pcs' => 59, '250 pcs' => 99]],
            'options' => [
                'Fold' => ['Flat' => 0, 'Half-fold' => 'x1.15'],
            ],
        ],
        'gift-card' => [
            'name' => 'Gift Cards',
            'category' => 'print-products',
            'image' => '2025/12/gift-card-golden-lettering-500x400.jpg',
            'summary' => 'Branded gift cards and certificates with premium finishes.',
            'features' => ['Thick 16 pt stock', 'Gold or silver foil option', 'Numbering available', 'Envelope option'],
            'turnaround' => '3–5 business days',
            'pricing' => ['type' => 'fixed', 'sizes' => ['50 pcs' => 49, '100 pcs' => 69, '250 pcs' => 119]],
            'options' => [
                'Finish' => ['Standard' => 0, 'Gold Foil' => 'x1.4', 'Silver Foil' => 'x1.4'],
            ],
        ],
        'safety-vests' => [
            'name' => 'Safety Vests',
            'category' => 'print-products',
            'image' => '2026/09/construction-company-uniform-safety-vest-fixed-500x400.jpg',
            'summary' => 'Hi-vis safety vests with your company logo printed on the back.',
            'features' => ['ANSI-style hi-vis', 'Reflective strips', 'Logo print', 'Sizes S–3XL'],
            'turnaround' => '3–5 business days',
            'pricing' => ['type' => 'fixed', 'sizes' => ['Front Logo' => 18, 'Back Logo' => 20, 'Front + Back' => 26]],
            'options' => [
                'Color' => ['Lime' => 0, 'Orange' => 0],
            ],
        ],
        'seating-chart' => [
            'name' => 'Seating Charts',
            'category' => 'print-products',
            'image' => '2026/06/baptism-brunch-event-menu-sign-500x400.jpg',
            'summary' => 'Wedding and event seating charts on foam board or acrylic.',
            'features' => ['Foam board or acrylic', 'Custom design', 'Easel-ready', 'Indoor use'],
            'turnaround' => '2–4 business days',
            'pricing' => ['type' => 'fixed', 'sizes' => ['18" x 24"' => 49, '24" x 36"' => 69]],
            'options' => [
                'Material' => ['Foam Board' => 0, 'Clear Acrylic' => 'x2.5'],
            ],
        ],
        'custom-wedding-invitation' => [
            'name' => 'Wedding Invitations',
            'category' => 'print-products',
            'image' => '2026/06/olivia-and-taylor-wedding-invitation-set-500x400.jpg',
            'summary' => 'Elegant invitation suites printed on premium cardstock.',
            'features' => ['Premium cardstock', 'Envelopes included', 'RSVP card option', 'Free design proof'],
            'turnaround' => '3–5 business days',
            'pricing' => ['type' => 'fixed', 'sizes' => ['50 pcs' => 89, '100 pcs' => 149, '150 pcs' => 199]],
            'options' => [
                'Add-ons' => ['Invitation Only' => 0, 'With RSVP Cards' => 'x1.4'],
            ],
        ],
        'table-numbers' => [
            'name' => 'Table Numbers',
            'category' => 'print-products',
            'image' => '2026/06/wedding-table-number-card-500x400.jpg',
            'summary' => 'Matching table number cards for weddings and banquets.',
            'features' => ['Thick cardstock or acrylic', 'Double sided', 'Matches your suite', 'Sets of 10'],
            'turnaround' => '2–4 business days',
            'pricing' => ['type' => 'fixed', 'sizes' => ['Set of 10' => 29, 'Set of 20' => 49, 'Set of 30' => 69]],
            'options' => [
                'Material' => ['Cardstock' => 0, 'Acrylic' => 'x3'],
            ],
        ],
    ],

];
