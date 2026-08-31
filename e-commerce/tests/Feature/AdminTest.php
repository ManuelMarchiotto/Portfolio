<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_cannot_access_dashboard(): void
    {
        $this->actingAs(User::factory()->create())->get(route('admin.dashboard'))->assertForbidden();
    }

    public function test_admin_can_create_product(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $category = Category::create(['name' => 'Tees', 'slug' => 'tees', 'description' => 'T-shirt.']);

        $this->actingAs($admin)->post(route('admin.products.store'), [
            'category_id' => $category->id,
            'name' => 'Core Tee',
            'slug' => 'core-tee',
            'sku' => 'UW-TEE-100',
            'description' => 'T-shirt.',
            'price' => 45,
            'stock' => 10,
            'color' => 'Black',
            'sizes' => 'S, M, L',
            'is_active' => 1,
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertDatabaseHas('products', ['slug' => 'core-tee', 'is_active' => 1]);
        $this->assertSame(['S', 'M', 'L'], Product::first()->sizes);
    }
}
