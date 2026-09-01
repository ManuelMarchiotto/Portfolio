<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;

class CartService
{
    /**
     * Get the current cart from session.
     */
    public function getCart(): Collection
    {
        return collect(session('cart', []));
    }

    /**
     * Add a product to the cart.
     */
    public function addItem(Product $product, ?string $size = null): array
    {
        $cart = $this->getCart();
        $key = "{$product->id}-" . ($size ?? 'default');

        // If size exists, we need a unique key. 
        // Using only ID might cause issues if different sizes are added.
        $key = $size ? "{$product->id}-{$size}" : "{$product->id}";

        if (isset($cart[$key])) {
            $currentQuantity = $cart[$key]['quantity'];
            $newQuantity = min($currentQuantity + 1, $product->stock);
            $cart[$key]['quantity'] = $newQuantity;
        } else {
            $cart[$key] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'size' => $size,
                'quantity' => 1,
            ];
        }

        session(['cart' => $cart]);
        return $cart[$key];
    }

    /**
     * Update item quantity.
     */
    public function updateItem(string $key, int $quantity): array
    {
        $cart = $this->getCart();
        if (!isset($cart[$key])) {
            throw new \Exception("Item not found in cart.");
        }

        $product = Product::findOrFail($cart[$key]['product_id']);

        if ($quantity <= 0) {
            unset($cart[$key]);
        } else {
            $cart[$key]['quantity'] = min($quantity, $product->stock);
        }

        session(['cart' => $cart]);
        return $cart[$key] ?? null;
    }

    /**
     * Remove item.
     */
    public function removeItem(string $key): void
    {
        $cart = $this->getCart();
        if (isset($cart[$key])) {
            unset($cart[$key]);
            session(['cart' => $cart]);
        }
    }

    /**
     * Calculate total price.
     */
    public function calculateTotal(): float
    {
        return $this->getCart()->sum(fn (array $item) => $item['price'] * $item['quantity']);
    }

    /**
     * Clear cart.
     */
    public function clear(): void
    {
        session(['cart' => []]);
    }
}
