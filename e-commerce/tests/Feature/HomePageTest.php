<?php

namespace Tests\Feature;

use Database\Seeders\CatalogSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_displays_featured_products(): void
    {
        $this->seed(CatalogSeeder::class);

        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertSee('Heavyweight Hoodie')
            ->assertSee('Utility Cargo Pant')
            ->assertSee('Core Logo Tee');
    }
}
