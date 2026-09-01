<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(protected OrderService $orderService) {}

    public function create(Request $request): View|RedirectResponse
    {
        $items = collect(session('cart', []));

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
            'shipping_country' => ['required', 'string', 'max' => 120],
        ]);

        $cart = $request->session()->get('cart', []);
        if ($cart === []) {
            return redirect()->route('cart.index')->with('error', 'Il carrello è vuoto.');
        }

        try {
            $order = $this->orderService->placeOrder($validated, $cart);
            $request->session()->forget('cart');

            return redirect()->route('checkout.success', $order)->with('success', 'Ordine ricevuto.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function success(Order $order): View
    {
        return view('checkout.success', compact('order'));
    }
}
