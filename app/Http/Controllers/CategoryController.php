<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    /**
     * CategoryController constructor.
     */
    function __construct()
    {
        $this->middleware('role:superAdmin')->except('view', 'show');
    }

    /**
     * Просмотр статей данной категории
     *
     * @param Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view(Category $category)
    {
        return view('categories.view', [
            'category' => $category,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.form', [
            'category' => new Category(),
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

            $this->validate($request, Category::rules());

            $category = new Category();
            $category->fill($request->all());

            if ($category->save()) {
                return redirect()->route('category.index')
                    ->with('success', 'Данные успешно добавлены!');
            }

            return redirect()->route('category.create')
                ->with('success', 'Ошибка добавления данных!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Category $category)
    {
        $categories = Category::all();
        $articles = Article::query()->where('category_id', '=', $category->id)->get();
        return view('categories.show', [
            'item' => $category,
            'categories' => $categories,
            'articles' => $articles
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Category $category)
    {
        return view('categories.form', [
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        if ($request->isMethod('put')) {

            $request->flash();

            $this->validate($request, Category::rules());

            $category->fill($request->all());

            if ($category->save()) {
                return redirect()->route('category.index')
                    ->with('success', 'Данные успешно изменены!');
            }

            return redirect()->route('category.edit', $category)
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
        echo 'Удаление категории';
    }
}
