<?php

use App\Http\Controllers\Admin\SyncController;
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

// Keep links from the old WordPress site working.
Route::permanentRedirect('/custom-signs', '/product-category/signs');
Route::permanentRedirect('/banners', '/product-category/banner-printing');
Route::permanentRedirect('/custom-flags', '/product-category/flags');
Route::permanentRedirect('/wall-and-window-graphics', '/product-category/wall-window-graphics');
Route::permanentRedirect('/a-frame-signs', '/shop?q=a-frame');
Route::permanentRedirect('/turnaround-policy', '/policies/turnaround-policy');
Route::permanentRedirect('/refund-policy', '/policies/refund-policy');
Route::permanentRedirect('/terms-and-conditions', '/policies/terms-and-conditions');
Route::permanentRedirect('/privacy-policy', '/policies/privacy-policy');

Route::controller(SyncController::class)->prefix('admin/sync')->group(function () {
    Route::get('migrate', 'migrate');
    Route::get('categories', 'categories');
    Route::get('products', 'products');
    Route::get('status', 'status');
});
