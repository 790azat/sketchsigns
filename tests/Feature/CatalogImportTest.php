<?php

namespace Tests\Feature;

use App\Livewire\ProductConfigurator;
use App\Models\Product;
use App\Services\WooImporter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TestCase;

class CatalogImportTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config(['services.blob.token' => 'vercel_blob_rw_STOREID_secret', 'services.admin_token' => 'secret']);

        $api = 'https://sketchsigns.com/wp-json/wc/store/v1';
        Http::fake([
            "$api/products/categories*" => Http::response([
                ['id' => 10, 'name' => 'Signs', 'slug' => 'signs', 'parent' => 0, 'description' => '', 'image' => null],
                ['id' => 11, 'name' => 'Real Estate Signs', 'slug' => 'real-estate-signs', 'parent' => 10, 'description' => '<p>Riders &amp; posts</p>', 'image' => ['src' => 'https://sketchsigns.com/wp-content/uploads/cat.jpg']],
            ]),
            "$api/products?type=variation*" => Http::response([
                ['id' => 101, 'prices' => ['price' => '1120']],
                ['id' => 102, 'prices' => ['price' => '2240']],
            ]),
            "$api/products?*" => Http::response([[
                'id' => 100, 'name' => 'Real Estate Sign Riders', 'slug' => 'real-estate-sign-riders', 'type' => 'variable',
                'short_description' => '<p onclick="x()">Small sign riders.</p>', 'description' => '<h2>At a glance</h2><script>alert(1)</script>',
                'prices' => ['price' => '1120', 'currency_minor_unit' => 2, 'price_range' => ['min_amount' => '1120', 'max_amount' => '2240']],
                'images' => [['src' => 'https://sketchsigns.com/wp-content/uploads/rider.png']],
                'categories' => [['id' => 11]],
                'attributes' => [['name' => 'Graphic', 'terms' => [['slug' => 'single-sided', 'name' => 'Single Sided'], ['slug' => 'double-sided', 'name' => 'Double Sided']]]],
                'variations' => [
                    ['id' => 101, 'attributes' => [['name' => 'Graphic', 'value' => 'single-sided']]],
                    ['id' => 102, 'attributes' => [['name' => 'Graphic', 'value' => 'double-sided']]],
                ],
                'is_in_stock' => true,
            ]], 200, ['X-WP-TotalPages' => '1']),
            'https://sketchsigns.com/wp-content/*' => Http::response('img', 200, ['Content-Type' => 'image/png']),
            'https://vercel.com/api/blob/*' => fn ($request) => Http::response([
                'url' => 'https://store.public.blob.vercel-storage.com/'.urldecode(str($request->url())->after('pathname=')),
            ]),
        ]);
    }

    private function import(): void
    {
        $importer = app(WooImporter::class);
        $importer->importCategories();
        $importer->importProducts(1);
    }

    public function test_import_creates_products_variations_and_mirrors_images(): void
    {
        $this->import();

        $product = Product::with('variations', 'categories')->firstWhere('slug', 'real-estate-sign-riders');
        $this->assertSame(1120, $product->price_min);
        $this->assertSame([1120, 2240], $product->variations->pluck('price')->sort()->values()->all());
        $this->assertSame('real-estate-signs', $product->categories->first()->slug);
        $this->assertSame('signs', $product->categories->first()->parent->slug);
        $this->assertStringContainsString('blob.vercel-storage.com/products/rider.png', $product->image);
        $this->assertStringNotContainsString('script', $product->description);
        $this->assertStringNotContainsString('onclick', $product->short_description);

        // Re-running is idempotent and does not re-upload images.
        $this->import();
        $this->assertSame(1, Product::count());
        $uploads = collect(Http::recorded())->filter(fn ($pair) => str_starts_with($pair[0]->url(), 'https://vercel.com/api/blob'));
        $this->assertCount(2, $uploads);
    }

    public function test_pages_render_from_the_database(): void
    {
        $this->import();

        $this->get('/')->assertOk()->assertSee('Real Estate Sign Riders');
        $this->get('/shop')->assertOk()->assertSee('Real Estate Sign Riders');
        $this->get('/product-category/signs')->assertOk()->assertSee('Real Estate Sign Riders');
        $this->get('/product/real-estate-sign-riders')->assertOk()->assertSee('$11.20 – $22.40', false)->assertSee('At a glance');
        $this->get('/product/nope')->assertNotFound();
    }

    public function test_configurator_prices_by_variation_and_adds_to_cart(): void
    {
        $this->import();
        $product = Product::firstWhere('slug', 'real-estate-sign-riders');

        Livewire::test(ProductConfigurator::class, ['product' => $product])
            ->assertSee('$11.20')
            ->set('selected.0', 'double-sided')
            ->set('quantity', 3)
            ->assertSee('$67.20')
            ->call('addToCart')
            ->assertSet('added', true);

        $this->assertSame(6720, session('cart') ? array_values(session('cart'))[0]['total'] : null);
    }

    public function test_sync_endpoints_require_the_admin_token(): void
    {
        $this->get('/admin/sync/status')->assertNotFound();
        $this->get('/admin/sync/status?token=secret')->assertOk()->assertJson(['products' => 0]);
        $this->get('/admin/sync/categories?token=secret')->assertOk()->assertJson(['categories' => 2]);
        $this->get('/admin/sync/products?token=secret&page=1')->assertOk()->assertJson(['imported' => 1, 'next' => null]);
    }
}
