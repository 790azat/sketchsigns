<?php

namespace Tests\Feature;

use App\Livewire\QuoteForm;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\QuoteRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    private function seedCatalog(): Product
    {
        $category = Category::create(['slug' => 'signs', 'name' => 'Signs']);
        $product = Product::create([
            'slug' => 'yard-sign', 'name' => 'Yard Sign', 'type' => 'variable', 'price_min' => 1500, 'price_max' => 3000,
            'options' => [['name' => 'Size', 'terms' => [['slug' => '18x24', 'name' => '18" x 24"']]]],
        ]);
        $product->categories()->attach($category);
        $product->variations()->create(['options' => ['Size' => '18x24'], 'price' => 1500]);

        return $product;
    }

    public function test_guests_are_sent_to_the_login_page(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
        $this->get('/admin/login')->assertOk();
    }

    public function test_admin_pages_render(): void
    {
        $product = $this->seedCatalog();
        $order = Order::create([
            'number' => 'SS-1', 'name' => 'Ann', 'email' => 'ann@example.com', 'phone' => '1', 'delivery' => 'ship', 'subtotal' => 1500,
            'items' => [['name' => 'Yard Sign', 'quantity' => 1, 'total' => 1500, 'options' => ['Size' => '18" x 24"'], 'artwork' => 'upload', 'notes' => '']],
        ]);
        $quote = QuoteRequest::create(['name' => 'Bob', 'email' => 'bob@example.com', 'details' => 'Need 20 banners']);

        $this->actingAs(User::factory()->create());

        foreach (['/admin', '/admin/products', '/admin/products/create', "/admin/products/{$product->slug}/edit", '/admin/categories',
            '/admin/orders', "/admin/orders/{$order->id}", '/admin/quote-requests', "/admin/quote-requests/{$quote->id}", '/admin/subscribers'] as $url) {
            $this->get($url)->assertOk();
        }

        $this->get("/admin/orders/{$order->id}")->assertSee('Size: 18&quot; x 24&quot;', false)->assertSee('$15.00');
    }

    public function test_prices_are_edited_in_dollars_and_stored_in_cents(): void
    {
        $product = $this->seedCatalog();
        $this->actingAs(User::factory()->create());

        Livewire::test(\App\Filament\Resources\Products\Pages\EditProduct::class, ['record' => $product->slug])
            ->assertSchemaStateSet(['price_min' => 15])
            ->fillForm(['price_min' => '12.50', 'is_active' => false])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertSame(1250, $product->fresh()->price_min);
        $this->assertFalse($product->fresh()->is_active);
        $this->assertSame(['signs'], $product->fresh()->categories->pluck('slug')->all());
    }

    public function test_quote_requests_are_saved(): void
    {
        Livewire::test(QuoteForm::class)
            ->set('name', 'Cara')->set('email', 'cara@example.com')->set('details', 'Two vinyl banners, 3x6 ft')
            ->call('submit')
            ->assertSet('sent', true);

        $this->assertDatabaseHas('quote_requests', ['email' => 'cara@example.com', 'status' => 'new', 'phone' => null]);
    }
}
