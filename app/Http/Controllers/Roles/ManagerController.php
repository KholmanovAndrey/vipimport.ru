<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Order;
use App\Parcel;
use App\Status;
use App\Support;
use App\User;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Manager;

class ManagerController extends Controller
{
    /**
     * ManagerController constructor.
     */
    function __construct()
    {
        $this->middleware('role:manager');
    }

    public function index()
    {
        return view('managers.index', [
            'manager' => Auth::user()->id
        ]);
    }

    /**
     * Вывод всех заказов со статусом "новый"
     */
    public function orderNew()
    {
        $orders = Order::query()->where('manager_id', '=', null)->get();
        return view('managers.order-new', [
            'orders' => $orders
        ]);
    }

    /**
     * Вывод всех заказов данного менеджера
     */
    public function orderMy()
    {
        $orders = Order::query()->where('manager_id', '=', Auth::user()->id)->get();
        $statuses = Status::query()->where('table_name', '=', 'orders')->get();
        return view('managers.order-my', [
            'orders' => $orders,
            'statuses' => $statuses
        ]);
    }

    /**
     * Функция для принятия заказа клиента
     * @param Request $request
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function orderAccept(Request $request, Order $order)
    {
        if ($request->isMethod('put')) {
            $order->manager_id = Auth::user()->id;
            $order->save();
        }

        return redirect()->back();
    }

    /**
     * Просмотр заказа
     * @param Order $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function orderShow(Order $order)
    {
        if ((int)Auth::user()->id === (int)$order->manager_id) {
            $statuses = Status::query()
                ->where([
                    ['table_name', '=', 'orders'],
                    ['id', '!=', 1]
                ])
                ->get();
            $managers = User::query()
                ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
                ->where('user_roles.role_id', '=', 3)
                ->get();
            foreach ($managers as $key => $manager) {
                if ($manager->hasRole('superAdmin')) {
                    unset($managers[$key]);
                }
            }

            return view('managers.order-show', [
                'order' => $order,
                'statuses' => $statuses,
                'managers' => $managers
            ]);
        }

        return redirect()->back();
    }

    /**
     * Функция для изменения статуса заказа
     * @param Request $request
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function orderStatus(Request $request, Order $order)
    {
        if ($request->isMethod('put')) {
            $order->status_id = (int)$request->status_id;
            $order->save();
        }

        return redirect()->back();
    }

    /**
     * Передача заказа клиента другому менеджеру
     * @param Request $request
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function orderTransfer(Request $request, Order $order)
    {
        if ($request->isMethod('put')) {
            $order->manager_id = (int)$request->manager_id;
            $order->save();
        }

        return redirect()->route('manager.order-my');
    }

    /**
     * Вывод всех посылок со статусом "отправлено на упаковку"
     */
    public function parcelNew()
    {
        $parcels = Parcel::query()->where([
            ['manager_id', '=', null],
            ['status_id', '=', 7]
        ])->get();
        return view('managers.parcel-new', [
            'parcels' => $parcels
        ]);
    }

    /**
     * Вывод всех заказов данного менеджера
     */
    public function parcelMy()
    {
        $parcels = Parcel::query()->where('manager_id', '=', Auth::user()->id)->get();
        $statuses = Status::query()->where('table_name', '=', 'parcel')->get();
        return view('managers.parcel-my', [
            'parcels' => $parcels,
            'statuses' => $statuses
        ]);
    }

    /**
     * Функция для принятия посылки клиента
     * @param Request $request
     * @param Parcel $parcel
     * @return \Illuminate\Http\RedirectResponse
     */
    public function parcelAccept(Request $request, Parcel $parcel)
    {
        if ($request->isMethod('put')) {
            $parcel->manager_id = Auth::user()->id;
            $parcel->save();
        }

        return redirect()->back();
    }

    /**
     * Просмотр заказа
     * @param Parcel $parcel
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function parcelShow(Parcel $parcel)
    {
        if ((int)Auth::user()->id === (int)$parcel->manager_id) {
            $statuses = Status::query()
                ->where([
                    ['table_name', '=', 'parcels'],
                    ['id', '!=', 6]
                ])
                ->get();
            $managers = User::query()
                ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
                ->where('user_roles.role_id', '=', 3)
                ->get();
            foreach ($managers as $key => $manager) {
                if ($manager->hasRole('superAdmin')) {
                    unset($managers[$key]);
                }
            }

            return view('managers.parcel-show', [
                'parcel' => $parcel,
                'statuses' => $statuses,
                'managers' => $managers
            ]);
        }

        return redirect()->back();
    }

    /**
     * Функция для изменения статуса посылки
     * @param Request $request
     * @param Parcel $parcel
     * @return \Illuminate\Http\RedirectResponse
     */
    public function parcelStatus(Request $request, Parcel $parcel)
    {
        if ($request->isMethod('put')) {
            $parcel->status_id = (int)$request->status_id;
            $parcel->save();
        }

        return redirect()->back();
    }

    /**
     * Передача заказа клиента другому менеджеру
     * @param Request $request
     * @param Parcel $parcel
     * @return \Illuminate\Http\RedirectResponse
     */
    public function parcelTransfer(Request $request, Parcel $parcel)
    {
        if ($request->isMethod('put')) {
            $parcel->manager_id = (int)$request->manager_id;
            $parcel->save();
        }

        return redirect()->route('manager.parcel-my');
    }

    public function supportNew()
    {
        $supports = Support::query()->where([
            ['manager_id', '=', null]
        ])->get();
        return view('supports.index', [
            'supports' => $supports
        ]);
    }

    public function supportMy()
    {
        $supports = Support::query()->where([
            ['manager_id', '=', Auth::user()->id]
        ])->get();
        return view('supports.index', [
            'supports' => $supports
        ]);
    }

    /**
     * Функция для принятия запроса в тех. поддержку
     * @param Request $request
     * @param Support $support
     * @return \Illuminate\Http\RedirectResponse
     */
    public function supportAccept(Request $request, Support $support)
    {
        if ($request->isMethod('put')) {
            $support->manager_id = Auth::user()->id;
            $support->save();
        }

        return redirect()->back();
    }

    public function clientView(User $client)
    {
        return view('managers.client-view', [
            'client' => $client
        ]);
    }

}
