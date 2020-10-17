<?php

namespace App\Http\Controllers;

use App\Article;
use App\Category;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * ArticleController constructor.
     */
    function __construct()
    {
        $this->middleware('role:admin')->except(['show']);
    }

    public function view(Article $article)
    {
        return view('articles.view', [
            'item' => $article
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::all();
        $categories = Category::all();
        return view('articles.index', [
            'articles' => $articles,
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('articles.form', [
            'article' => new Article(),
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->flash();

            $this->validate($request, Article::rules());

            $article = new Article();
            $article->user_id = 1;
            $article->fill($request->all());

            if ($article->save()) {
                return redirect()->route('article.index')
                    ->with('success', 'Данные успешно добавлены!');
            }

            return redirect()->route('article.create')
                ->with('success', 'Ошибка добавления данных!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Article $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return view('articles.show', [
            'item' => $article
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Article $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $categories = Category::all();
        return view('articles.form', [
            'article' => $article,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Article $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        if ($request->isMethod('put')) {

            $request->flash();

            $this->validate($request, Article::rules());

            $article->fill($request->all());

            if ($article->save()) {
                return redirect()->route('article.index')
                    ->with('success', 'Данные успешно изменены!');
            }

            return redirect()->route('article.edit', $article)
                ->with('success', 'Ошибка изменения данных!');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        echo 'Удаление статьи';
    }
}
