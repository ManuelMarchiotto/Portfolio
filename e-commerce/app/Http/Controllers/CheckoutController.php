<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function create(Request $request): View|RedirectResponse
    {
        $items = collect($request->session()->get('cart', []));

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Il carrello è vuoto.');
        }

        return view('checkout.create', [
            'items' => $items,
            'total' => $items->sum(fn (array $item) => $item['price'] * $item['quantity']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['nullable', 'string', 'max:30'],
            'shipping_address' => ['required', 'string', 'max:255'],
            'shipping_city' => ['required', 'string', 'max:120'],
            'shipping_postal_code' => ['required', 'string', 'max:10'],
            'shipping_country' => ['required', 'string', 'max:120'],
        ]);

        $cart = $request->session()->get('cart', []);
        if ($cart === []) {
            return redirect()->route('cart.index')->with('error', 'Il carrello è vuoto.');
        }

        $order = DB::transaction(function () use ($request, $validated, $cart): Order {
            $products = Product::whereIn('id', collect($cart)->pluck('product_id'))->lockForUpdate()->get()->keyBy('id');
            $total = 0;

            foreach ($cart as $item) {
                $product = $products->get($item['product_id']);
                abort_unless($product?->is_active, 422, 'Un prodotto nel carrello non è più disponibile.');
                abort_if($item['quantity'] > $product->stock, 422, "Stock insufficiente per {$product->name}.");
                $total += (float) ($product->sale_price ?? $product->price) * $item['quantity'];
            }

            $order = Order::create([
                ...$validated,
                'user_id' => $request->user()?->id,
                'status' => 'pending',
                'total' => $total,
            ]);

            foreach ($cart as $item) {
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

        $request->session()->forget('cart');

        return redirect()->route('checkout.success', $order)->with('success', 'Ordine ricevuto.');
    }

    public function success(Order $order): View
    {
        return view('checkout.success', compact('order'));
    }
}
