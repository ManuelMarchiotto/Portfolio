<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PageController;
use App\Models\Article;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'homepage'])->name('homepage');

Route::get('/articoli', [PageController::class, 'articles'])->name('pages.articles');
Route::get('/articoli/{article}', [PageController::class, 'article'])->name('pages.article'); // Rotta parametrica

Route::get('/chi-siamo', [PageController::class, 'aboutUs'])->name('pages.aboutUs');

Route::get('/contatti', [ContactController::class, 'form'])->name('pages.contacts');
Route::post('/contatti', [ContactController::class, 'send'])->name('pages.contacts.send');

Route::get('/libri', [PageController::class, 'books'])->name('pages.books');
Route::get('/libri/{id}', [PageController::class, 'book'])->name('pages.book');

Route::get('/eventi', [EventController::class, 'index'])->name('pages.events');
Route::get('/eventi/{id}', [EventController::class, 'show'])->name('pages.events.show');

// Route::get('/account', [AccountController::class, 'index'])->name('account')->middleware('auth');

Route::middleware('auth')->prefix('account')->group(function () {

    Route::get('/', [AccountController::class, 'index'])->name('account');

    Route::get('/articles', [ArticleController::class, 'index'])->name('account.articles');
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('account.articles.create');
    Route::post('/articles/store', [ArticleController::class, 'store'])->name('account.articles.store');
    Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('account.articles.edit');
    Route::put('/articles/{article}/update', [ArticleController::class, 'update'])->name('account.articles.update');
    Route::delete('/articles/{article}/delete', [ArticleController::class, 'destroy'])->name('account.articles.destroy');

    Route::resource('categories', CategoryController::class);
});

Route::get('test', function () {
    $user = \App\Models\User::where('email', 'test@example.com')->firstOrFail();
    return $user;
});
