<?php

namespace App\Http\Controllers;

use App\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * CityController constructor.
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
        return view('cities.index', [
            'cities' => City::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cities.form', [
            'city' => new City()
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
            $request->flesh();

            $request->validate($request, City::rules());

            $city = new City();
            $city->fill($request->all());

            if ($city->save()) {
                return redirect()->route('city.index')
                    ->with('success', 'Данные успешно добавлены!');
            }

            return redirect()->route('city.create')
                ->with('success', 'Ошибка добавления данных!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  City $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        return view('cities', [
            'city' => $city
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  City $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {
        if ($request->isMethod('put')) {

            $request->flash();

            $this->validate($request, City::rules());

            $city->fill($request->all());

            if ($city->save()) {
                return redirect()->route('country.index')
                    ->with('success', 'Данные успешно изменены!');
            }

            return redirect()->route('country.edit', $city)
                ->with('success', 'Ошибка изменения данных!');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @param  City $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, City $city)
    {
        if ($request->isMethod('delete')) {
            if ($city->delete()) {
                return redirect()->route('city.index')
                    ->with('success', 'Данные успешно удаленны!');
            }

            return redirect()->route('city.index')
                ->with('success', 'Ошибка удаления данных!');
        }
    }
}
