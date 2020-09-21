<?php

namespace App\Http\Controllers;

use App\Address;
use App\Order;
use App\Parcel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParcelController extends Controller
{
    /**
     * Display a addlisting of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parcels = Parcel::query()->where('user_id', '=', Auth::user()->id)->get();
        $addresses = Address::query()->where('user_id', '=', Auth::user()->id)->get();
        return view('parcels.index', [
            'parcels' => $parcels,
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
        $addresses = Address::query()->where('user_id', '=', Auth::user()->id)->get();
        return view('parcels.form', [
            'parcel' => new Parcel(),
            'addresses' => $addresses
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

            $this->validate($request, Parcel::rules());

            $parcel = new Parcel();
            $parcel->address_id = (int)$request->address_id;
            $parcel->title = $request->title;
            $parcel->description = $request->description;
            $parcel->user_id = Auth::user()->id;
            $address = Address::query()->where('id', '=', (int)$request->address_id)->first();
            $fio = "{$address->lastname}, {$address->firstname} {$address->othername}";
            $parcel->fio = trim($fio);
            $addressStr = "{$address->postal_code}, {$address->country->title}, {$address->region}, {$address->city}, {$address->street}, дом {$address->building}";
            if ($address->body) {
                $addressStr .= ", кор. {$address->body}";
            }
            if ($address->apartment) {
                $addressStr .= ", кв. {$address->apartment}";
            }
            $parcel->address = trim($addressStr);
            $parcel->phone = $address->phone;

//            echo '<pre>';print_r($parcel->toArray()); echo '</pre>';

            if ($parcel->save()) {
                return redirect()->route('parcel.show', $parcel)
                    ->with('success', 'Данные успешно добавлены!');
            }

            return redirect()->route('parcel.create')
                ->with('success', 'Ошибка добавления данных!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Parcel $parcel
     * @return \Illuminate\Http\Response
     */
    public function show(Parcel $parcel)
    {
        $orders = Order::query()
            ->where([
                ['user_id', '=', Auth::user()->id],
                ['parcel_id', '=', null],
            ])
            ->get();
        return view('parcels.show', [
            'item' => $parcel,
            'orders' => $orders
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    public function orderAdd(Request $request, Parcel $parcel)
    {
        if ($request->isMethod('post')) {
            $request->flash();

            //$this->validate($request, Order::rulesArray());

            for ($i = 0; $i < count($request->order_id); $i++) {
                $order = Order::query()->where('id', '=', (int)$request->order_id[$i])->first();
                $order->parcel_id = $parcel->id;
                $order->save();
            }
        }

        return redirect()->route('parcel.show', $parcel)
            ->with('success', 'Данные успешно добавлены!');
    }
}
