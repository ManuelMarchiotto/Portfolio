<?php

namespace Tests\Feature;

use Database\Seeders\CatalogSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_catalog_displays_active_products(): void
    {
        $this->seed(CatalogSeeder::class);

        $this->get(route('catalog.index'))
            ->assertOk()
            ->assertSee('Heavyweight Hoodie')
            ->assertSee('Unit Long Sleeve');
    }

    public function test_catalog_filters_products_by_category_and_price(): void
    {
        $this->seed(CatalogSeeder::class);

        $this->get(route('catalog.index', ['category' => 'hoodies', 'min_price' => 90]))
            ->assertOk()
            ->assertSee('Shadow Zip Hoodie')
            ->assertDontSee('Heavyweight Hoodie')
            ->assertDontSee('Utility Cargo Pant');
    }
}
