<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Redirect;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    private function product(array $attributes = []): Product
    {
        $category = Category::create(['slug' => 'signs', 'name' => 'Signs']);
        $product = Product::create($attributes + [
            'slug' => 'yard-sign', 'name' => 'Yard Sign', 'price_min' => 1500, 'price_max' => 3000,
            'short_description' => '<p>Weatherproof corrugated plastic yard signs for real estate, elections and events.</p>',
        ]);
        $product->categories()->attach($category);

        return $product;
    }

    public function test_product_page_has_meta_and_schema(): void
    {
        $this->product();

        $html = $this->get('/product/yard-sign')->assertOk()->getContent();

        $this->assertStringContainsString('<title>Yard Sign | Sketch Signs Los Angeles</title>', $html);
        $this->assertStringContainsString('<link rel="canonical" href="https://sketchsigns.com/product/yard-sign">', $html);
        $this->assertStringContainsString('"@type":"Product"', $html);
        $this->assertStringContainsString('"lowPrice":"15.00"', $html);
        $this->assertStringContainsString('"@type":"BreadcrumbList"', $html);
        $this->assertStringContainsString('og:image', $html);
    }

    public function test_admin_seo_fields_override_defaults(): void
    {
        $this->product(['seo_title' => 'Custom Yard Signs LA', 'seo_description' => 'Cheap yard signs.']);

        $this->get('/product/yard-sign')
            ->assertSee('<title>Custom Yard Signs LA</title>', false)
            ->assertSee('<meta name="description" content="Cheap yard signs.">', false);
    }

    public function test_test_site_stays_closed_to_search_engines(): void
    {
        config(['site.indexable' => false]);

        $this->get('/')->assertSee('noindex', false);
        $this->get('/robots.txt')->assertOk()->assertSee('Disallow: /');
    }

    public function test_live_site_is_indexable_except_private_pages(): void
    {
        config(['site.indexable' => true]);
        $this->product();

        $this->get('/')->assertSee('index, follow', false)->assertDontSee('noindex', false);
        $this->get('/cart')->assertSee('noindex', false);
        $this->get('/robots.txt')->assertSee('Sitemap: https://sketchsigns.com/sitemap.xml')->assertDontSee("Disallow: /\n");
    }

    public function test_sitemap_lists_products_and_categories(): void
    {
        $this->product();
        Product::create(['slug' => 'hidden', 'name' => 'Hidden', 'is_active' => false]);

        $this->get('/sitemap.xml')->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee('<loc>https://sketchsigns.com/product/yard-sign</loc>', false)
            ->assertSee('<loc>https://sketchsigns.com/product-category/signs</loc>', false)
            ->assertDontSee('/product/hidden', false)
            ->assertDontSee('/cart', false);
    }

    public function test_old_wordpress_addresses_redirect(): void
    {
        $this->product();

        $this->get('/custom-signs')->assertStatus(301)->assertRedirect('/product-category/signs');
        $this->get('/lp/medical')->assertRedirect('/industries-we-serve/medical-office-signs');
        $this->get('/graphic-design-services/spirit-spa-brand-concept')->assertRedirect('/graphic-design-services');
        $this->get('/product-category/signs/page/2')->assertRedirect('/product-category/signs');
        $this->get('/product/discontinued-thing')->assertStatus(301)->assertRedirect('/shop');
        $this->get('/product/yard-sign')->assertOk();
        $this->get('/no-such-page')->assertNotFound();
    }

    public function test_admin_redirects_win_and_count_hits(): void
    {
        Redirect::create(['from_path' => '/Custom-Signs/', 'to_path' => '/shop', 'status_code' => 302]);

        $this->get('/custom-signs')->assertStatus(302)->assertRedirect('/shop');
        $this->assertSame(1, Redirect::first()->hits);
    }

    public function test_faq_and_home_schema(): void
    {
        $this->get('/faq')->assertSee('"@type":"FAQPage"', false);
        $this->get('/')->assertSee('"@type":"LocalBusiness"', false)->assertSee('"@type":"WebSite"', false);
    }
}
