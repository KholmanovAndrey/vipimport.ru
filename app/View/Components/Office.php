<?php

namespace App\View\Components;

use App\Order;
use App\Parcel;
use App\Support;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class Office extends Component
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
        $orders_new = Order::query()
            ->where('manager_id', '=', null)
            ->get()
            ->count();
        $parcels_new = Parcel::query()
            ->where('manager_id', '=', null)
            ->get()
            ->count();
        $supports_new = Support::query()
            ->where('manager_id', '=', null)
            ->get()
            ->count();
        $clients_new = User::query()
            ->where('created_at', '>=', Carbon::now()->subDays(2)->toDateTimeString())
            ->get()
            ->count();

        // клиент
        $client_orders_all = Order::query()
            ->where('user_id', '=', Auth::user()->id)
            ->get()
            ->count();
        $client_parcels_all = Parcel::query()
            ->where('user_id', '=', Auth::user()->id)
            ->get()
            ->count();

        return view('components.office', [
            'orders_new' => $orders_new,
            'parcels_new' => $parcels_new,
            'supports_new' => $supports_new,
            'clients_new' => $clients_new,
            'client_orders_all' => $client_orders_all,
            'client_parcels_all' => $client_parcels_all
        ]);
    }
}
