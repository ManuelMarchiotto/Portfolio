<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $items = collect(session('cart', []));

        return view('cart.index', [
            'items' => $items,
            'total' => $items->sum(fn (array $item) => $item['price'] * $item['quantity']),
        ]);
    }

    public function store(Request $request, Product $product): RedirectResponse
    {
        abort_unless($product->is_active && $product->stock > 0, 404);

        $validated = $request->validate([
            'size' => [
                Rule::requiredIf(filled($product->sizes)),
                'nullable',
                'string',
                Rule::in($product->sizes ?? []),
            ],
            'quantity' => ['required', 'integer', 'min:1', "max:{$product->stock}"],
        ]);

        $size = $validated['size'] ?? null;
        $key = "{$product->id}-{$size}";
        $cart = session('cart', []);
        $existingQuantity = $cart[$key]['quantity'] ?? 0;

        $cart[$key] = [
            'product_id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'size' => $size,
            'quantity' => min($existingQuantity + $validated['quantity'], $product->stock),
        ];

        session(['cart' => $cart]);

        return back()->with('success', "{$product->name} è stato aggiunto al carrello.");
    }

    public function update(Request $request, string $item): RedirectResponse
    {
        $cart = session('cart', []);
        abort_unless(isset($cart[$item]), 404);

        $product = Product::findOrFail($cart[$item]['product_id']);
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:0', "max:{$product->stock}"],
        ]);

        if ($validated['quantity'] === 0) {
            unset($cart[$item]);

            session(['cart' => $cart]);

            return back()->with('success', 'Articolo rimosso dal carrello.');
        }

        $cart[$item]['quantity'] = $validated['quantity'];
        session(['cart' => $cart]);

        return back()->with('success', 'Quantità aggiornata.');
    }

    public function destroy(string $item): RedirectResponse
    {
        $cart = session('cart', []);
        abort_unless(isset($cart[$item]), 404);

        unset($cart[$item]);
        session(['cart' => $cart]);

        return back()->with('success', 'Articolo rimosso dal carrello.');
    }
}
