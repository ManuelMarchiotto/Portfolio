<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_and_view_orders(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'Mario Rossi',
            'email' => 'mario@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('orders.index'));
        $this->assertAuthenticated();
        $this->get(route('orders.index'))->assertOk();
    }

    public function test_user_can_login_and_only_sees_own_orders(): void
    {
        $user = User::factory()->create(['password' => Hash::make('password123')]);
        Order::create([
            'user_id' => $user->id,
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'shipping_address' => 'Via Roma 1',
            'shipping_city' => 'Milano',
            'shipping_postal_code' => '20100',
            'shipping_country' => 'Italia',
            'total' => 45,
        ]);

        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password123',
        ])->assertRedirect(route('orders.index'));

        $this->get(route('orders.index'))->assertSee('Ordine #1');
    }
}
