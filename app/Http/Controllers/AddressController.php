<?php

namespace App\Http\Controllers;

use App\Address;
use App\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    /**
     * AddressController constructor.
     */
    function __construct()
    {
        $this->middleware('role:client');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $addresses = Address::all();
        return view('addresses.index', [
            'addresses' => $addresses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('addresses.form', [
            'address' => new Address(),
            'countries' => Country::all()
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

            $this->validate($request, Address::rules());

            $address = new Address();
            $address->user_id = Auth::user()->id;
            $address->fill($request->all());

            if ($address->save()) {
                return redirect()->route('address.index')
                    ->with('success', 'Данные успешно добавлены!');
            }

            return redirect()->route('address.create')
                ->with('success', 'Ошибка добавления данных!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Address $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Address $address
     * @return \Illuminate\Http\Response
     */
    public function edit(Address $address)
    {
        $this->authorize('update', $address);

        $countries = Country::all();
        return view('addresses.form', [
            'address' => $address,
            'countries' => $countries
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Address $address
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Address $address)
    {
        if ($request->isMethod('put')) {

            $request->flash();

            $this->authorize('update', $address);
            $this->validate($request, Address::rules());

            $address->fill($request->all());

            if ($address->save()) {
                return redirect()->route('address.index')
                    ->with('success', 'Данные успешно изменены!');
            }

            return redirect()->route('address.edit', $address)
                ->with('success', 'Ошибка изменения данных!');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @param  Address $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Address $address)
    {
        if ($request->isMethod('delete')) {
            $this->authorize('delete', $address);

            if ($address->delete()) {
                return redirect()->route('address.index')
                    ->with('success', 'Данные успешно удаленны!');
            }

            return redirect()->route('address.index')
                ->with('success', 'Ошибка удаления данных!');
        }
    }
}
