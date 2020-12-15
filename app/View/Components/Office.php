<?php

namespace App\View\Components;

use App\Order;
use App\Parcel;
use App\Support;
use App\User;
use Illuminate\Support\Carbon;
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
        $orders = Order::query()
            ->where('manager_id', '=', null)
            ->get()
            ->count();
        $parcels = Parcel::query()
            ->where('manager_id', '=', null)
            ->get()
            ->count();
        $supports = Support::query()
            ->where('manager_id', '=', null)
            ->get()
            ->count();
        $clients = User::query()
            ->where('created_at', '>=', Carbon::now()->subDays(2)->toDateTimeString())
            ->get()
            ->count();
        return view('components.office', [
            'orders' => $orders,
            'parcels' => $parcels,
            'supports' => $supports,
            'clients' => $clients,
        ]);
    }
}
