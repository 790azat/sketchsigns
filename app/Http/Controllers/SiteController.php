<?php

namespace App\Http\Controllers;

use App\Support\Catalog;

class SiteController extends Controller
{
    public function home()
    {
        $featured = ['a-frame-sidewalk-sign', 'vinyl-banner', 'car-magnets', 'pole-banner-set', 'feather-angled-flag', 'removable-window-clings',
            'floor-graphics', 'channel-letters', 'coroplast-yard-signs', 'step-and-repeat-backdrop', 'acrylic-wall-signs', 'standard-retractable-banner'];

        return view('pages.home', [
            'categories' => Catalog::categories(),
            'featured' => Catalog::products()->only($featured),
            'industries' => Catalog::industries(),
        ]);
    }

    public function shop()
    {
        return view('pages.shop');
    }

    public function category(string $slug)
    {
        $category = Catalog::category($slug) ?? abort(404);

        return view('pages.category', ['category' => $category]);
    }

    public function product(string $slug)
    {
        $product = Catalog::product($slug) ?? abort(404);

        return view('pages.product', [
            'product' => $product,
            'category' => Catalog::category($product['category']),
            'related' => Catalog::inCategory($product['category'])->except($slug)->take(4),
        ]);
    }

    public function industries()
    {
        return view('pages.industries', ['industries' => Catalog::industries()]);
    }

    public function industry(string $slug)
    {
        $industry = Catalog::industry($slug) ?? abort(404);

        return view('pages.industry', [
            'industry' => $industry,
            'products' => Catalog::products()->only($industry['products']),
        ]);
    }

    public function legal(string $page)
    {
        abort_unless(in_array($page, ['turnaround-policy', 'refund-policy', 'terms-and-conditions', 'privacy-policy']), 404);

        return view('pages.legal.'.$page);
    }
}
