<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * CountryController constructor.
     */
    function __construct()
    {
        $this->middleware('role:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('counties.index', [
            'countries' => Country::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('counties.form', [
            'country' => new Country()
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

            $this->validate($request, Country::rules());

            $country = new Country();
            $country->fill($request->all());

            if ($country->save()) {
                return redirect()->route('country.index')
                    ->with('success', 'Данные успешно добавлены!');
            }

            return redirect()->route('country.create')
                ->with('success', 'Ошибка добавления данных!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Country $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        return view('countries.form', [
            'country' => $country
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Country $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        if ($request->isMethod('put')) {

            $request->flash();

            $this->validate($request, Country::rules());

            $country->fill($request->all());

            if ($country->save()) {
                return redirect()->route('country.index')
                    ->with('success', 'Данные успешно изменены!');
            }

            return redirect()->route('country.edit', $country)
                ->with('success', 'Ошибка изменения данных!');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @param  Country $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Country $country)
    {
        if ($request->isMethod('delete')) {
            if ($country->delete()) {
                return redirect()->route('country.index')
                    ->with('success', 'Данные успешно удаленны!');
            }

            return redirect()->route('country.index')
                ->with('success', 'Ошибка удаления данных!');
        }
    }
}
