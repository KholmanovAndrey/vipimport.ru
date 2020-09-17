<?php

namespace App\Http\Controllers;

use App\Country;
use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * ProfileController constructor.
     */
    function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        return view('profiles.form', [
            'profile' => new Profile(),
            'countries' => $countries
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

            $this->validate($request, Profile::rules());

            $profile = new Profile();
            $profile->user_id = Auth::user()->id;
            $profile->fill($request->all());

            if ($profile->save()) {
                return redirect()->route('profile.show', $profile)
                    ->with('success', 'Данные успешно добавлены!');
            }

            return redirect()->route('profile.create')
                ->with('success', 'Ошибка добавления данных!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Profile $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        $this->authorize('view', $profile);

        return view('profiles.show', [
            'item' => $profile
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Profile $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        $this->authorize('update', $profile);

        $countries = Country::all();
        return view('profiles.form', [
            'profile' => $profile,
            'countries' => $countries
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Profile $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        if ($request->isMethod('put')) {

            $request->flash();

            $this->authorize('update', $profile);
            $this->validate($request, Profile::rules());

            $profile->fill($request->all());

            if ($profile->save()) {
                return redirect()->route('profile.show', $profile)
                    ->with('success', 'Данные успешно изменены!');
            }

            return redirect()->route('profile.edit', $profile)
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
        //
    }
}
