<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:80'],
            'category' => ['nullable', 'string', Rule::exists('categories', 'slug')],
            'min_price' => ['nullable', 'numeric', 'min:0'],
            'max_price' => ['nullable', 'numeric', 'min:0', 'gte:min_price'],
            'in_stock' => ['nullable', 'boolean'],
            'sort' => ['nullable', 'string', Rule::in(['latest', 'price_asc', 'price_desc'])],
        ]);

        $products = Product::query()
            ->with('category')
            ->where('is_active', true)
            ->when($filters['search'] ?? null, function ($query, string $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->when($filters['category'] ?? null, function ($query, string $category) {
                $query->whereHas('category', fn ($query) => $query->where('slug', $category));
            })
            ->when($filters['min_price'] ?? null, fn ($query, $price) => $query->where('price', '>=', $price))
            ->when($filters['max_price'] ?? null, fn ($query, $price) => $query->where('price', '<=', $price))
            ->when($request->boolean('in_stock'), fn ($query) => $query->where('stock', '>', 0))
            ->when(
                ($filters['sort'] ?? 'latest') === 'price_asc',
                fn ($query) => $query->orderBy('price'),
                fn ($query) => ($filters['sort'] ?? 'latest') === 'price_desc'
                    ? $query->orderByDesc('price')
                    : $query->latest(),
            )
            ->paginate(9)
            ->withQueryString();

        return view('catalog.index', [
            'categories' => Category::orderBy('name')->get(),
            'products' => $products,
        ]);
    }
}
