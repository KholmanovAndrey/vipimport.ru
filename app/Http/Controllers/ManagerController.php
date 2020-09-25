<?php

namespace App\Http\Controllers;

use App\Order;
use App\Policies\ManagerPolicy;
use App\Status;
use App\User;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
     * Вывод всех заказов со статутос "новый"
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

    public function orderTransfer(Request $request, Order $order)
    {
        if ($request->isMethod('put')) {
            $order->manager_id = (int)$request->manager_id;
            $order->save();
        }

        return redirect()->route('manager.order-my');
    }
}
