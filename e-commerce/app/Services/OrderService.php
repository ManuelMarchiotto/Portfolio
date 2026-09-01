<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * Process the order and place it in the database.
     */
    public function placeOrder(array $data, array $cartItems): Order
    {
        return DB::transaction(function () use ($data, $cartItems): Order {
            // Eager load products to avoid N+1 and handle stock check.
            $productIds = collect($cartItems)->pluck('product_id')->unique();
            $products = Product::whereIn('id', $productIds)
                ->where('is_active', true)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $total = 0;

            foreach ($cartItems as $item) {
                $product = $products->get($item['product_id']);

                if (!$product || !$product->is_active) {
                    throw new \Exception("Un prodotto nel carrello non è più disponibile.");
                }

                if ($item['quantity'] > $product->stock) {
                    throw new \Exception("Stock insufficiente per {$product->name}.");
                }

                $unitPrice = $product->sale_price ?? $product->price;
                $total += (float) $unitPrice * $item['quantity'];
            }

            $order = Order::create([
                'customer_name' => $data['customer_name'],
                'customer_email' => $data['customer_email'],
                'customer_phone' => $data['customer_phone'],
                'shipping_address' => $data['shipping_address'],
                'shipping_city' => $data['shipping_city'],
                'shipping_postal_code' => $data['shipping_postal_code'],
                'shipping_country' => $data['shipping_country'],
                'user_id' => auth()->id(),
                'status' => 'pending',
                'total' => $total,
            ]);

            foreach ($cartItems as $item) {
                $product = $products->get($item['product_id']);
                $unitPrice = $product->sale_price ?? $product->price;

                $order->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'size' => $item['size'] ?? null,
                    'unit_price' => $unitPrice,
                    'quantity' => $item['quantity'],
                ]);

                $product->decrement('stock', $item['quantity']);
            }

            return $order;
        });
    }
}
