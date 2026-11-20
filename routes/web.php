<?php

use App\Http\Controllers\Admin\SyncController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::controller(SiteController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/shop', 'shop')->name('shop');
    Route::get('/product-category/{category}', 'category')->name('category');
    Route::get('/product/{product}', 'product')->name('product');
    Route::get('/industries-we-serve', 'industries')->name('industries');
    Route::get('/industries-we-serve/{slug}', 'industry')->name('industry');
    Route::get('/policies/{page}', 'legal')->name('legal');
});

Route::view('/cart', 'pages.cart')->name('cart');
Route::view('/checkout', 'pages.checkout')->name('checkout');
Route::view('/about-sketch-signs', 'pages.about')->name('about');
Route::view('/contact-sketch-signs', 'pages.contact')->name('contact');
Route::view('/get-a-free-quote', 'pages.quote')->name('quote');
Route::view('/faq', 'pages.faq')->name('faq');
Route::view('/sign-installation', 'pages.installation')->name('installation');
Route::view('/graphic-design-services', 'pages.design')->name('design');
Route::view('/track-order', 'pages.track')->name('track');

// Old WordPress addresses are redirected in App\Support\Redirects (config/redirects.php + admin).

Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('robots');

Route::controller(SyncController::class)->prefix('admin/sync')->group(function () {
    Route::get('migrate', 'migrate');
    Route::get('categories', 'categories');
    Route::get('products', 'products');
    Route::get('site-media', 'siteMedia');
    Route::get('remirror', 'remirror');
    Route::get('media-map', 'mediaMap');
    Route::get('admin-user', 'adminUser');
    Route::get('status', 'status');
});
