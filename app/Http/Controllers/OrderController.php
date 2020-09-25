<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
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
        $orders = Order::query()->where('user_id', '=', Auth::user()->id)->get();
        return view('orders.index', [
            'orders' => $orders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('orders.form', [
            'order' => new Order()
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

            $this->validate($request, Order::rulesArray());

            for ($i = 0; $i < count($request->title); $i++) {
                $order = new Order();
                $order->user_id = Auth::user()->id;
                $order->status_id = 1;
                $order->title = $request->title[$i];
                $order->count = $request->count[$i];
                $order->link = $request->link[$i];
                $order->price = $request->price[$i] ?? 0;
                $order->color = $request->color[$i];
                $order->size = $request->size[$i];
                $order->description = $request->description[$i];
                $order->save();
            }

            return redirect()->route('order.index')
                    ->with('success', 'Данные успешно добавлены!');

//            $this->validate($request, Order::rules());
//            $order->fill($request->all());

//            if ($order->save()) {
//                return redirect()->route('order.index')
//                    ->with('success', 'Данные успешно добавлены!');
//            }
//
//            return redirect()->route('order.create')
//                ->with('success', 'Ошибка добавления данных!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Order $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        return view('orders.form-update', [
            'order' => $order,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Order $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        if ($request->isMethod('put')) {

            $request->flash();

            $this->validate($request, Order::rules());

            $order->fill($request->all());

            if ($order->save()) {
                return redirect()->route('order.index')
                    ->with('success', 'Данные успешно изменены!');
            }

            return redirect()->route('order.edit', $order)
                ->with('success', 'Ошибка изменения данных!');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Order $order)
    {
        if ($request->isMethod('delete')) {
            $request->flash();

            //$this->validate($request, Order::rules());

            $order->isDeleted = 1;

            if ($order->save()) {
                return redirect()->route('order.index')
                    ->with('success', 'Данные успешно изменены!');
            }

//            if ($order->delete()) {
//                return redirect()->route('contact.index')
//                    ->with('success', 'Данные успешно удаленны!');
//            }

            return redirect()->route('contact.index')
                ->with('success', 'Ошибка удаления данных!');
        }
    }
}
