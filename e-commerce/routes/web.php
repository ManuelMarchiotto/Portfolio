<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/catalogo', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/prodotti/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/carrello', [CartController::class, 'index'])->name('cart.index');
Route::post('/carrello/{product:slug}', [CartController::class, 'store'])->name('cart.store');
Route::patch('/carrello/{item}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/carrello/{item}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/confermato/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

Route::middleware('guest')->group(function (): void {
	Route::get('/accedi', [AuthController::class, 'showLogin'])->name('login');
	Route::post('/accedi', [AuthController::class, 'login'])->name('login.store');
	Route::get('/registrati', [AuthController::class, 'showRegister'])->name('register');
	Route::post('/registrati', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function (): void {
	Route::get('/i-miei-ordini', [OrderController::class, 'index'])->name('orders.index');
	Route::post('/esci', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function (): void {
	Route::get('/', [AdminController::class, 'index'])->name('dashboard');
	Route::get('/prodotti/nuovo', [AdminController::class, 'createProduct'])->name('products.create');
	Route::post('/prodotti', [AdminController::class, 'storeProduct'])->name('products.store');
	Route::get('/prodotti/{product}/modifica', [AdminController::class, 'editProduct'])->name('products.edit');
	Route::put('/prodotti/{product}', [AdminController::class, 'updateProduct'])->name('products.update');
	Route::delete('/prodotti/{product}', [AdminController::class, 'destroyProduct'])->name('products.destroy');
	Route::patch('/ordini/{order}/stato', [AdminController::class, 'updateOrderStatus'])->name('orders.status');
});
