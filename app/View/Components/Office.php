<?php

namespace App\View\Components;

use App\Order;
use App\Parcel;
use App\Support;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;
use phpDocumentor\Reflection\Types\Null_;

class Office extends Component
{
    public $css;

    /**
     * Office constructor.
     * @param $css
     */
    public function __construct($css)
    {
        $this->css = $css;
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
            ->where([
                ['manager_id', '=', null],
                ['status_id', '=', 7]
            ])
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


        $messages_new = Support::query()
            ->get();
        $messages = [];
        foreach ($messages_new as $key => $message) {
            if ($message->client_add_at > $message->manager_add_at) {
                $messages[] = $message;
            }
        }
        $messages_new = count($messages);

        $messages_new_for_manager = Support::query()
            ->where([
                ['manager_id', '=', Auth::user()->id]
            ])
            ->get();
        $messages = [];
        foreach ($messages_new_for_manager as $key => $message) {
            if ($message->client_add_at > $message->manager_add_at && $message->client_add_at > $message->manager_view_at) {
                $messages[] = $message;
            }
        }
        $messages_new_for_manager = count($messages);

        $messages_new_for_client = Support::query()
            ->where([
                ['client_id', '=', Auth::user()->id],
            ])
            ->get();
        $messages = [];
        foreach ($messages_new_for_client as $key => $message) {
            if ($message->client_add_at < $message->manager_add_at && $message->client_view_at < $message->manager_add_at) {
                $messages[] = $message;
            }
        }
        $messages_new_for_client = count($messages);

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
            'messages_new' => $messages_new,
            'messages_new_for_manager' => $messages_new_for_manager,
            'messages_new_for_client' => $messages_new_for_client,
            'client_orders_all' => $client_orders_all,
            'client_parcels_all' => $client_parcels_all
        ]);
    }
}
