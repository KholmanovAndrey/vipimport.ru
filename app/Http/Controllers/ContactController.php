<?php

namespace App\Http\Controllers;

use App\Article;
use App\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * ContactController constructor.
     */
    function __construct()
    {
        $this->middleware('role:superAdmin')->except('view');
    }

    public function view()
    {
        $contacts = Contact::query()->where('isPrivate', '=', false)->get();
        $article = Article::query()->where('name', '=', 'contacts')->first();
        return view('contacts.view', [
            'contacts' => $contacts,
            'article' => $article
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::all();
        return view('contacts.index', [
            'contacts' => $contacts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contacts.form', [
            'contact' => new Contact()
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

            $this->validate($request, Contact::rules());

            $contact = new Contact();
            $contact->fill($request->all());

            if ($contact->save()) {
                return redirect()->route('contact.index')
                    ->with('success', 'Данные успешно добавлены!');
            }

            return redirect()->route('contact.create')
                ->with('success', 'Ошибка добавления данных!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Contact $contact
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Contact $contact)
    {
        return view('contacts.show', [
            'item' => $contact
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        return view('contacts.form', [
            'contact' => $contact,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        if ($request->isMethod('put')) {

            $request->flash();

            $this->validate($request, Contact::rules());

            $contact->fill($request->all());

            if ($contact->save()) {
                return redirect()->route('contact.index')
                    ->with('success', 'Данные успешно изменены!');
            }

            return redirect()->route('contact.edit', $contact)
                ->with('success', 'Ошибка изменения данных!');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Contact $contact
     * @return $this
     */
    public function destroy(Request $request, Contact $contact)
    {
        if ($request->isMethod('delete')) {
            if ($contact->delete()) {
                return redirect()->route('contact.index')
                    ->with('success', 'Данные успешно удаленны!');
            }

            return redirect()->route('contact.index', $contact)
                ->with('success', 'Ошибка удаления данных!');
        }
    }
}
