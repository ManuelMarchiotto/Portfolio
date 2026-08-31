<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_complete_checkout_and_stock_is_decremented(): void
    {
        $category = Category::create(['name' => 'Tees', 'slug' => 'tees', 'description' => 'T-shirt.']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Core Logo Tee',
            'slug' => 'core-logo-tee',
            'sku' => 'UW-TEE-001',
            'description' => 'T-shirt.',
            'price' => 45,
            'stock' => 5,
            'color' => 'Black',
            'sizes' => ['M'],
            'is_active' => true,
        ]);

        $response = $this->withSession(['cart' => [
            "{$product->id}-M" => [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => 45,
                'size' => 'M',
                'quantity' => 2,
            ],
        ]])->post(route('checkout.store'), [
            'customer_name' => 'Mario Rossi',
            'customer_email' => 'mario@example.com',
            'shipping_address' => 'Via Roma 1',
            'shipping_city' => 'Milano',
            'shipping_postal_code' => '20100',
            'shipping_country' => 'Italia',
        ]);

        $order = Order::first();
        $response->assertRedirect(route('checkout.success', $order));
        $this->assertNotNull($order);
        $this->assertSame(2, $order->items()->first()->quantity);
        $this->assertSame(3, $product->fresh()->stock);
        $this->assertFalse(session()->has('cart'));
    }

    public function test_checkout_requires_shipping_details(): void
    {
        $response = $this->withSession(['cart' => ['item' => [
            'product_id' => 1,
            'name' => 'Test',
            'price' => 10,
            'quantity' => 1,
        ]]])->post(route('checkout.store'), []);

        $response->assertSessionHasErrors(['customer_name', 'customer_email', 'shipping_address']);
    }
}
