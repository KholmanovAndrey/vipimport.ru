<?php

namespace App\Http\Controllers;

use App\Order;
use App\Parcel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function balance() {
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

        return view('search.balance', [
            'balance' => $balance,
            'orders' => $orders,
            'parcels' => $parcels
        ]);
    }
}
