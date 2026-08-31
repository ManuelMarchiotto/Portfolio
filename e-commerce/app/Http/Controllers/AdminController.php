<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'products' => Product::with('category')->latest()->get(),
            'orders' => Order::with('items')->latest()->get(),
            'stats' => [
                'products' => Product::count(),
                'orders' => Order::count(),
                'revenue' => Order::where('status', '!=', 'cancelled')->sum('total'),
            ],
        ]);
    }

    public function createProduct(): View
    {
        return view('admin.products.form', ['product' => new Product, 'categories' => Category::orderBy('name')->get()]);
    }

    public function storeProduct(Request $request): RedirectResponse
    {
        Product::create($this->validatedProduct($request));

        return redirect()->route('admin.dashboard')->with('success', 'Prodotto creato.');
    }

    public function editProduct(Product $product): View
    {
        return view('admin.products.form', ['product' => $product, 'categories' => Category::orderBy('name')->get()]);
    }

    public function updateProduct(Request $request, Product $product): RedirectResponse
    {
        $product->update($this->validatedProduct($request, $product));

        return redirect()->route('admin.dashboard')->with('success', 'Prodotto aggiornato.');
    }

    public function destroyProduct(Product $product): RedirectResponse
    {
        $product->update(['is_active' => false]);

        return back()->with('success', 'Prodotto disattivato.');
    }

    public function updateOrderStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate(['status' => ['required', 'in:pending,paid,shipped,delivered,cancelled']]);
        $order->update($validated);

        return back()->with('success', "Ordine #{$order->id} aggiornato.");
    }

    private function validatedProduct(Request $request, ?Product $product = null): array
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:products,slug,'.($product?->id ?? 'NULL')],
            'sku' => ['required', 'string', 'max:255', 'unique:products,sku,'.($product?->id ?? 'NULL')],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'color' => ['required', 'string', 'max:255'],
            'sizes' => ['nullable', 'string'],
            'image' => ['nullable', 'string', 'max:255'],
            'is_active' => ['sometimes', 'boolean'],
            'is_featured' => ['sometimes', 'boolean'],
        ]);

        $validated['sizes'] = filled($validated['sizes'] ?? null)
            ? array_values(array_filter(array_map('trim', explode(',', $validated['sizes']))))
            : null;
        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_featured'] = $request->boolean('is_featured');

        return $validated;
    }
}
