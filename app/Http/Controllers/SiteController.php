<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Support\Catalog;

class SiteController extends Controller
{
    public function home()
    {
        $featured = Catalog::products(config('site.featured_products', []));
        if ($featured->count() < 8) {
            $featured = $featured->merge(Product::active()->whereNotIn('id', $featured->pluck('id'))->orderBy('position')->limit(12 - $featured->count())->get());
        }

        return view('pages.home', [
            'categories' => Catalog::navCategories(),
            'featured' => $featured,
            'industries' => Catalog::industries(),
        ]);
    }

    public function shop()
    {
        return view('pages.shop');
    }

    public function category(Category $category)
    {
        $category->load('children', 'parent');

        return view('pages.category', ['category' => $category]);
    }

    public function product(Product $product)
    {
        abort_unless($product->is_active, 404);
        $product->load('variations', 'categories');
        $category = $product->categories->first();

        return view('pages.product', [
            'product' => $product,
            'category' => $category,
            'related' => $category
                ? $category->products()->active()->whereKeyNot($product->id)->orderBy('position')->limit(4)->get()
                : collect(),
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
            'products' => Catalog::products($industry['products']),
        ]);
    }

    public function legal(string $page)
    {
        abort_unless(in_array($page, ['turnaround-policy', 'refund-policy', 'terms-and-conditions', 'privacy-policy']), 404);

        return view('pages.legal.'.$page);
    }
}
