<?php

namespace App\View\Components;

use App\Order;
use App\Parcel;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class Account extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $balance = 0;

        $orders = Order::query()
            ->where([
                ['price', '>', 0],
                ['user_id', '=', Auth::user()->id],
                ['isPaid', '=', false],
                ['status_id', '=', 3]
            ])
            ->get();
        foreach ($orders as $item) {
            $balance = $balance + $item->price;
        }

        $parcels = Parcel::query()
            ->where([
                ['price', '>', 0],
                ['user_id', '=', Auth::user()->id],
                ['isPaid', '=', false],
                ['status_id', '=', 8]
            ])
            ->get();
        foreach ($parcels as $item) {
            $balance = $balance + $item->price;
        }

        return view('components.account', [
            'balance' => $balance
        ]);
    }
}
