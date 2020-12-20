<?php

namespace App\Http\Controllers;

use App\Address;
use App\Country;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    /**
     * Поиск клиента по name or email
     *
     * @param $search
     * @return string
     */
    private function search($search)
    {
        $where = '';

        if ($search) {
            $clients = User::query()->where('name', 'like', "%{$search}%")->get();
            if (count($clients)) {
                $i = 0;
                foreach($clients as $client) {
                    if ($i !== (count($clients) - 1)) {
                        $where .= "user_id={$client->id} OR ";
                    } else {
                        $where .= "user_id={$client->id}";
                    }
                    $i++;
                }
            }

            $clientsEmail = User::query()->where('email', 'like', "%{$search}%")->get();
            if (count($clientsEmail)) {
                if ($where) {
                    $where .= ' OR ';
                }

                $i = 0;
                foreach($clientsEmail as $client) {
                    if ($i !== (count($clientsEmail) - 1)) {
                        $where .= "user_id={$client->id} OR ";
                    } else {
                        $where .= "user_id={$client->id}";
                    }
                    $i++;
                }
            }
        }

        return $where ? $where : "user_id != ''";
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Address::class);

        $addresses = new Address();
        if (Auth::user()->hasRole('superAdmin')) {
            $where = $this->search($request->search);

            $addresses = Address::query()
                ->whereRaw($where)
                ->get();
        }elseif (Auth::user()->hasRole('client')) {
            $addresses = Address::query()
                ->where('user_id', '=', Auth::user()->id)
                ->get();
        }

        return view('addresses.index', [
            'addresses' => $addresses,
            'search' => $request->search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Address::class);

        $clients = new User();
        if (Auth::user()->hasRole('superAdmin')) {
            $clients = User::query()
                ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
                ->where('user_roles.role_id', '=', 4)
                ->get();
        }elseif (Auth::user()->hasRole('client')) {
            $clients = User::query()
                ->where('id', '=', Auth::user()->id)
                ->get();
        }

        return view('addresses.form', [
            'address' => new Address(),
            'countries' => Country::all(),
            'clients' => $clients
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
        $this->authorize('create', Address::class);

        if ($request->isMethod('post')) {
            $request->flash();

            $this->validate($request, Address::rulesCreate());

            $address = new Address();
            $address->fill($request->all());

            $route = '';
            if (Auth::user()->hasRole('superAdmin')) {
                $route = 'superAdmin.';
            }

            if ($address->save()) {
                return redirect()->route($route.'address.index')
                    ->with('success', 'Данные успешно добавлены!');
            }

            return redirect()->route($route.'address.create')
                ->with('error', 'Ошибка добавления данных!');
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
        $this->authorize('view', $address);

        return view('addresses.show', [
            'item' => $address
        ]);
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

        $clients = new User();
        if (Auth::user()->hasRole('superAdmin')) {
            $clients = User::query()
                ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
                ->where('user_roles.role_id', '=', 4)
                ->get();
        }elseif (Auth::user()->hasRole('client')) {
            $clients = User::query()
                ->where('id', '=', Auth::user()->id)
                ->get();
        }

        $countries = Country::all();
        return view('addresses.form', [
            'address' => $address,
            'countries' => $countries,
            'clients' => $clients
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
        $this->authorize('update', $address);

        if ($request->isMethod('put')) {

            $request->flash();

            $this->validate($request, Address::rulesUpdate());

            $address->fill($request->all());

            $route = '';
            if (Auth::user()->hasRole('superAdmin')) {
                $route = 'superAdmin.';
            }

            if ($address->save()) {
                return redirect()->route($route.'address.index')
                    ->with('success', 'Данные успешно обновленны!');
            }

            return redirect()->route($route.'address.edit', $address)
                ->with('error', 'Ошибка обновления данных!');

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

        $this->authorize('delete', $address);

        if ($request->isMethod('delete')) {
            $route = '';
            if (Auth::user()->hasRole('superAdmin')) {
                $route = 'superAdmin.';
            }

            if ($address->delete()) {
                return redirect()->route($route.'address.index')
                    ->with('success', 'Данные успешно удаленны!');
            }

            return redirect()->route($route.'address.index')
                ->with('error', 'Ошибка удаления данных!');
        }
    }
}
