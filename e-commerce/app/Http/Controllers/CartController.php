<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(protected CartService $cartService) {}

    public function index(): View
    {
        $items = $this->cartService->getCart();

        return view('cart.index', [
            'items' => $items,
            'total' => $this->cartService->calculateTotal(),
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
        $this->cartService->addItem($product, $size);

        return back()->with('success', "{$product->name} è stato aggiunto al carrello.");
    }

    public function update(Request $request, string $item): RedirectResponse
    {
        $updated = $this->cartService->updateItem($item, (int)$request->input('quantity'));
        
        if ($updated === null) {
            return back()->with('success', 'Articolo rimosso dal carrello.');
        }

        return back()->with('success', 'Quantità aggiornata.');
    }

    public function destroy(string $item): RedirectResponse
    {
        $this->cartService->removeItem($item);
        return back()->with('success', 'Articolo rimosso dal carrello.');
    }
}
