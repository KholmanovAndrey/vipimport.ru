<?php

namespace App\Http\Controllers;

use App\Address;
use App\Mail\ParcelShipped;
use App\Message;
use App\Order;
use App\Parcel;
use App\Support;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class ParcelController extends Controller
{
    function __construct()
    {
        $this->middleware('role:client');
    }

    /**
     * Display a addlisting of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parcels = Parcel::query()
            ->where('user_id', '=', Auth::user()->id)
            ->orderByDesc('id')
            ->get();
        return view('parcels.index', [
            'parcels' => $parcels,
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
            $fio = "{$address->lastname} {$address->firstname} {$address->othername}";
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
                $this->ship($request, $parcel->id);
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
        $this->authorize('view', $parcel);

        $orders = Order::query()
            ->where([
                ['user_id', '=', Auth::user()->id],
                ['parcel_id', '=', null],
                ['isDeleted', '=', 0],
                ['status_id', '=', 5]
            ])
            ->orderByDesc('id')
            ->get();
        return view('parcels.show', [
            'item' => $parcel,
            'orders' => $orders
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Parcel $parcel
     * @return \Illuminate\Http\Response
     */
    public function edit(Parcel $parcel)
    {
        $this->authorize('update', $parcel);

        if (!Gate::allows('canEditByStatus', $parcel)) {
            return redirect()->back();
        }

        $addresses = Address::query()->where('user_id', '=', Auth::user()->id)->get();
        return view('parcels.form', [
            'parcel' => $parcel,
            'addresses' => $addresses
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Parcel $parcel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Parcel $parcel)
    {
        if ($request->isMethod('put')) {
            $request->flash();

            $this->validate($request, Parcel::rules());

            $parcel->address_id = (int)$request->address_id;
            $parcel->title = $request->title;
            $parcel->description = $request->description;
            $parcel->user_id = Auth::user()->id;
            $address = Address::query()->where('id', '=', (int)$request->address_id)->first();
            $fio = "{$address->lastname} {$address->firstname} {$address->othername}";
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
                $this->ship($request, $parcel->id);
                return redirect()->route('parcel.show', $parcel)
                    ->with('success', 'Данные успешно добавлены!');
            }

            return redirect()->route('parcel.create')
                ->with('success', 'Ошибка добавления данных!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @param  Parcel $parcel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Parcel $parcel)
    {
        $this->authorize('delete', $parcel);

        if (!Gate::allows('canEditByStatus', $parcel)) {
            return redirect()->back();
        }

        if ($request->isMethod('delete')) {
            foreach ($parcel->orders as $orderParcel) {
                if ($order = Order::find($orderParcel->id)) {
                    $order->parcel_id = null;
                    $order->save();
                }
            }
            foreach ($parcel->supports as $supportParcel) {
                if ($support = Support::find($supportParcel->id)) {
                    foreach ($support->messages as $messageParcel) {
                        if ($message = Message::find($messageParcel->id)) {
                            $message->delete();
                        }
                    }
                    $support->delete();
                }
            }
            if ($parcel->delete()) {
                return redirect()->route('parcel.index')
                    ->with('success', 'Данные успешно добавлены!');
            }
        }
    }

    /**
     * Ship the given parcel.
     *
     * @param  Request  $request
     * @param  int  $orderId
     * @return Response
     */
    public function ship(Request $request, $parcelId)
    {
        $parcel = Parcel::findOrFail($parcelId);

        // Ship parcel...

        Mail::to($request->user())->send(new ParcelShipped($parcel));
    }
}
