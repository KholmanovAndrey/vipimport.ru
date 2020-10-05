<?php

namespace App\Http\Controllers;

use App\Order;
use App\Parcel;
use App\Support;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    /**
     * SupportController constructor.
     */
    function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $orders = Order::query()->get();
        $parcels = Parcel::query()->get();
        return view('supports.form', [
            'support' => new Support(),
            'orders' => $orders,
            'parcels' => $parcels
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

            $this->validate($request, Support::rules());

            $support = new Support();
            $support->client_id = Auth::user()->id;
            $support->manager_id = $this->supportManagerID($request);
            $support->fill($request->all());

            if ($support->save()) {
                return redirect()->route('support.show', $support)
                    ->with('success', 'Данные успешно добавлены!');
            }

            return redirect()->route('support.create')
                ->with('success', 'Ошибка добавления данных!');
        }
    }

    private function supportManagerID(Request $request)
    {
        if ($request->order_id) {
            $order = Order::find($request->order_id);
            return $order->manager_id;
        }
        if ($request->parcel_id) {
            $parcel = Parcel::find($request->parcel_id);
            return $parcel->manager_id;
        }
        return null;
    }

    /**
     * Display the specified resource.
     *
     * @param  Support $support
     * @return \Illuminate\Http\Response
     */
    public function show(Support $support)
    {
        return view('supports.view', [
            'item' => $support
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
}
