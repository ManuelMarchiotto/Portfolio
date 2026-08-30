<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Models\Article;
use App\Models\Category;

class ArticleController extends Controller
{
    public function index()
    {
        // $articles = Article::all();
        // $articles = Article::paginate(10);
        // $articles = Article::orderBy('title', 'DESC')->get();
        // $articles = Article::where('title', 'Articolo di viaggi')->get();
        $articles = Article::where('title', 'LIKE', '%viaggi%')->get();

        return view('account.articles.index', [
            'articles' => $articles,
        ]);
    }

    public function create()
    {
        return view('account.articles.create', [
            'categories' => Category::all(),
        ]);
    }

    public function store(StoreArticleRequest $request)
    {
        $article = Article::create($request->all());

        if($request->hasFile('image') && $request->file('image')->isValid()) {
            // Lavoro sul file caricato correttamente

            $folder = 'images/articles/' . $article->id;

            $fileName = uniqid('cover_') . '.' . $request->file('image')->extension();

            $article->image = $request->file('image')->storeAs($folder, $fileName, 'public');

            $article->save();

        }
        
        return redirect()->back()->with('success', 'Articolo creato correttamente.');
    }

    public function edit(Article $article)
    {
        return view('account.articles.edit', [
            'article' => $article,
            'categories' => Category::all(),
        ]);
    }

    public function update(Article $article, StoreArticleRequest $request)
    {
        $article->update($request->all());

        return redirect()->back()->with('success', 'Articolo modificato correttamente!');
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->back()->with('success', 'Articolo eliminato correttamente!');
    }
}
