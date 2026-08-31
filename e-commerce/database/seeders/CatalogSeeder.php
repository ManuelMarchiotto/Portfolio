<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class CatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = collect([
            [
                'name' => 'Hoodies',
                'slug' => 'hoodies',
                'description' => 'Felpe heavyweight dalla vestibilità oversize.',
            ],
            [
                'name' => 'Pants',
                'slug' => 'pants',
                'description' => 'Pantaloni cargo e denim pensati per la città.',
            ],
            [
                'name' => 'Tees',
                'slug' => 'tees',
                'description' => 'T-shirt essenziali in cotone pesante.',
            ],
        ])->mapWithKeys(function (array $category): array {
            $model = Category::updateOrCreate(['slug' => $category['slug']], $category);

            return [$category['slug'] => $model->id];
        });

        $products = [
            ['category' => 'hoodies', 'name' => 'Heavyweight Hoodie', 'slug' => 'heavyweight-hoodie', 'sku' => 'UW-HOD-001', 'description' => 'Felpa oversize in cotone heavyweight da 450 gsm.', 'price' => 89, 'stock' => 24, 'color' => 'Black', 'sizes' => ['S', 'M', 'L', 'XL'], 'is_featured' => true],
            ['category' => 'pants', 'name' => 'Utility Cargo Pant', 'slug' => 'utility-cargo-pant', 'sku' => 'UW-PNT-001', 'description' => 'Cargo fit rilassato con tasche utility e fondo regolabile.', 'price' => 110, 'stock' => 18, 'color' => 'Charcoal', 'sizes' => ['S', 'M', 'L', 'XL'], 'is_featured' => true],
            ['category' => 'tees', 'name' => 'Core Logo Tee', 'slug' => 'core-logo-tee', 'sku' => 'UW-TEE-001', 'description' => 'T-shirt boxy fit in jersey di cotone da 260 gsm.', 'price' => 45, 'stock' => 36, 'color' => 'Black', 'sizes' => ['S', 'M', 'L', 'XL'], 'is_featured' => true],
            ['category' => 'hoodies', 'name' => 'Shadow Zip Hoodie', 'slug' => 'shadow-zip-hoodie', 'sku' => 'UW-HOD-002', 'description' => 'Felpa zip-up con cappuccio doppio e dettagli tono su tono.', 'price' => 105, 'stock' => 16, 'color' => 'Graphite', 'sizes' => ['S', 'M', 'L'], 'is_featured' => false],
            ['category' => 'pants', 'name' => 'Panel Denim', 'slug' => 'panel-denim', 'sku' => 'UW-PNT-002', 'description' => 'Denim a gamba ampia con pannelli e lavaggio nero.', 'price' => 120, 'stock' => 12, 'color' => 'Washed Black', 'sizes' => ['S', 'M', 'L', 'XL'], 'is_featured' => false],
            ['category' => 'tees', 'name' => 'Unit Long Sleeve', 'slug' => 'unit-long-sleeve', 'sku' => 'UW-TEE-002', 'description' => 'Maglia a maniche lunghe con stampa grafica minimale.', 'price' => 59, 'stock' => 20, 'color' => 'Off White', 'sizes' => ['S', 'M', 'L', 'XL'], 'is_featured' => false],
        ];

        foreach ($products as $product) {
            $categorySlug = $product['category'];
            unset($product['category']);

            Product::updateOrCreate(
                ['sku' => $product['sku']],
                [
                    ...$product,
                    'category_id' => $categories[$categorySlug],
                    'is_active' => true,
                ],
            );
        }
    }
}
