<?php

use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::controller(SiteController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/shop', 'shop')->name('shop');
    Route::get('/category/{slug}', 'category')->name('category');
    Route::get('/product/{slug}', 'product')->name('product');
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
Route::permanentRedirect('/product-category/signs', '/category/signs');
Route::permanentRedirect('/custom-signs', '/category/signs');
Route::permanentRedirect('/product-category/banner-printing', '/category/banners');
Route::permanentRedirect('/banners', '/category/banners');
Route::permanentRedirect('/custom-flags', '/category/flags-fabric');
Route::permanentRedirect('/product-category/flags', '/category/flags-fabric');
Route::permanentRedirect('/wall-and-window-graphics', '/category/wall-window-graphics');
Route::permanentRedirect('/product-category/wall-window-graphics', '/category/wall-window-graphics');
Route::permanentRedirect('/product-category/trade-show-displays', '/category/event-displays');
Route::permanentRedirect('/a-frame-signs', '/category/stands-sidewalk-signs');
Route::permanentRedirect('/product-category/real-estate-signs', '/category/stands-sidewalk-signs');
Route::permanentRedirect('/product-category/print-products', '/category/print-products');
Route::permanentRedirect('/product-category/channel-letters', '/product/channel-letters');
Route::permanentRedirect('/turnaround-policy', '/policies/turnaround-policy');
Route::permanentRedirect('/refund-policy', '/policies/refund-policy');
Route::permanentRedirect('/terms-and-conditions', '/policies/terms-and-conditions');
Route::permanentRedirect('/privacy-policy', '/policies/privacy-policy');
