<?php

namespace App\Http\Controllers;

// FQCN App\Http\Controllers\PageController; // PageController::class

use App\Models\Article;
use Illuminate\Http\Request;

class PageController extends Controller
{
    private $books = [];

    public function __construct()
    {
        $this->books = [
            1 => ['title' => 'Guida a PHP', 'category' => 'Linguaggi di programmazione'],
            2 => ['title' => 'Guida a JS', 'category' => 'Linguaggi di programmazione'],
            3 => ['title' => 'Guida a MySQL', 'category' => 'Database'],
            4 => ['title' => 'Guida a Linux', 'category' => 'Sistemi operativi'],
        ];
    }

    public function homepage ()
    {

        return view('homepage', [
            'title' => 'Benvenuto su ' . config('app.name') . '!',
            'post' => \App\Services\PostService::generate(),
        ]);
    }

    public function articles ()
    {
        return view('pages.articles', [
            'articles' => Article::all(),
        ]);

    }

    // public function article ($id)
    public function article (Article $article)
    {
        /*
        return view('pages.article', [
            'article' => Article::findOrFail($id),
        ]);
        */

        return view('pages.article', [
            'article' => $article,
        ]);

        // return view('pages.article', compact('article'));
    }

    public function aboutUs ()
    {

        return view('pages.aboutUs');

    }

    public function books()
    {
        return view('pages.books', [
            'books' => $this->books,
        ]);
    }

    public function book($id)
    {
        return view('pages.book', [
            'book' => $this->books[$id],
        ]);
    }
}