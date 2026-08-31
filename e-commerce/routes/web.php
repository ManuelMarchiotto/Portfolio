<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/catalogo', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/prodotti/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/carrello', [CartController::class, 'index'])->name('cart.index');
Route::post('/carrello/{product:slug}', [CartController::class, 'store'])->name('cart.store');
Route::patch('/carrello/{item}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/carrello/{item}', [CartController::class, 'destroy'])->name('cart.destroy');
