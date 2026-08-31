<?php

namespace Tests\Feature;

use App\Models\Product;
use Database\Seeders\CatalogSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_page_displays_product_details(): void
    {
        $this->seed(CatalogSeeder::class);
        $product = Product::firstWhere('slug', 'heavyweight-hoodie');

        $this->get(route('products.show', $product))
            ->assertOk()
            ->assertSee('Heavyweight Hoodie')
            ->assertSee('Scegli la taglia');
    }

    public function test_product_can_be_added_to_the_session_cart(): void
    {
        $this->seed(CatalogSeeder::class);
        $product = Product::firstWhere('slug', 'heavyweight-hoodie');

        $this->from(route('products.show', $product))
            ->post(route('cart.store', $product), ['size' => 'M', 'quantity' => 2])
            ->assertRedirect(route('products.show', $product))
            ->assertSessionHas("cart.{$product->id}-M.quantity", 2)
            ->assertSessionHas('success');
    }
}
