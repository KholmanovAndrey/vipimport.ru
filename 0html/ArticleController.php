<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * ArticleController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('article.index', [
            'articles' => Article::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('article.form', [
            'article' => new Article
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
            $article->category_id = 2;
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
        if ($article) {
            redirect(route('article.index'));
        }

        return view('article.show', [
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
        return view('article.form', [
            'article' => $article
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
     * @param  Request $request
     * @param  Article $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Article $article)
    {
        if ($request->isMethod('delete')) {
            if ($article->delete()) {
                return redirect()->route('article.index')
                    ->with('success', 'Данные успешно удаленны!');
            }

            return redirect()->route('article.index', $article)
                ->with('success', 'Ошибка удаления данных!');
        }
    }
}
