<?php

namespace App\Http\Controllers;

use App\Message;
use App\Order;
use App\Parcel;
use App\Support;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * ManagerController constructor.
     */
    function __construct()
    {
        $this->middleware('role:client');
    }

    /**
     * Главная страница клиентского личного кабинета
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('clients.index', [
            'client' => Auth::user()->id
        ]);
    }

    /**
     * Функция для добавления заказа в посылку
     * @param Request $request
     * @param Parcel $parcel
     * @return \Illuminate\Http\RedirectResponse
     */
    public function orderAddParcelID(Request $request, Parcel $parcel)
    {
        if ($request->isMethod('put')) {
            for ($i = 0; $i < count($request->order_id); $i++) {
                $order = Order::query()->where('id', '=', (int)$request->order_id[$i])->first();
                $order->parcel_id = $parcel->id;
                $order->save();
            }
        }

        return redirect()->back();
    }

    /**
     * Функция для удаления заказа из посылки
     *
     * @param Request $request
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function orderDeleteParcelID(Request $request, Order $order)
    {
        if ($request->isMethod('put')) {
            $order->parcel_id = null;
            $order->save();
        }

        return redirect()->back();
    }

    /**
     * Изменение статуса посылки с "Открыта" на "Отправлена на упаковку"
     *
     * @param Request $request
     * @param Parcel $parcel
     * @return \Illuminate\Http\RedirectResponse
     */
    public function parcelSendToPackaging(Request $request, Parcel $parcel)
    {
        if ($request->isMethod('put')) {
            $parcel->status_id = 7;
            $parcel->save();
        }

        return redirect()->back();
    }

    public function supportAll()
    {
        $supports = Support::query()->where('client_id', '=', Auth::user()->id)->get();
        return view('clients.support-all', [
            'supports' => $supports
        ]);
    }

    public function supportView(Support $support)
    {
        return view('clients.support-view', [
            'item' => $support
        ]);
    }

    public function supportCreate()
    {
        $orders = Order::query()->get();
        $parcels = Parcel::query()->get();
        return view('supports.form', [
            'support' => new Support(),
            'orders' => $orders,
            'parcels' => $parcels
        ]);
    }

    public function supportStore(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->flash();

            $this->validate($request, Support::rules());

            $support = new Support();
            $support->client_id = Auth::user()->id;
            $support->fill($request->all());

            if ($support->save()) {
                return redirect()->route('client.support-view', $support)
                    ->with('success', 'Данные успешно добавлены!');
            }

            return redirect()->route('client.support-create')
                ->with('success', 'Ошибка добавления данных!');
        }
    }

    public function messageStore(Request $request, Support $support)
    {
        if ($request->isMethod('post')) {
            $request->flash();

            $this->validate($request, Message::rules());

            $message = new Message();
            $message->user_id = Auth::user()->id;
            $message->support_id = $support->id;
            $message->fill($request->all());

            if ($message->save()) {
                return redirect()->route('client.support-view', $support)
                    ->with('success', 'Данные успешно добавлены!');
            }

            return redirect()->route('client.support-create')
                ->with('success', 'Ошибка добавления данных!');
        }
    }
}
