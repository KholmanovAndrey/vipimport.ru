<?php

namespace App\Http\Controllers;

use App\Mail\OrderShipped;
use App\Order;
use App\Status;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public $whereName;
    public $whereEmail;

    function __construct()
    {
//        $this->middleware('role:client');
    }

    /**
     * Поиск клиента по name or email
     * @param $search
     */
    private function search($search)
    {
        $clients = User::query()->where('name', 'like', "%{$search}%")->get();
        foreach ($clients as $client) {
            $this->whereName[0] = ['user_id', '=', $client->id];
        }
        $clients = User::query()->where('email', 'like', "%{$search}%")->get();
        foreach ($clients as $client) {
            $this->whereEmail[0] = ['user_id', '=', $client->id];
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Order::class);

        $orders = new Order();
        if (Auth::user()->hasRole('superAdmin')) {
            if ($request->search) {
                $this->search($request->search);
            }

            $orders = Order::query()
                ->orderByDesc('id')
                ->where($this->whereName)
                ->orWhere($this->whereEmail)
                ->get();
        }elseif (Auth::user()->hasRole('client')) {
            $orders = Order::query()
                ->where('user_id', '=', Auth::user()->id)
                ->orderByDesc('id')
                ->get();
        }

        return view('orders.index', [
            'orders' => $orders,
            'search' => $request->search
        ]);
    }

    public function new(Request $request)
    {
        $this->authorize('viewNew', Order::class);

        if ($request->search) {
            $this->search($request->search);
        }

        $orders = Order::query()
            ->orderByDesc('id')
            ->where('manager_id', '=', null)
            ->where(function ($query) {
                $query->where($this->whereName)
                    ->orWhere($this->whereEmail);
            })
            ->get();

        return view('orders.index', [
            'orders' => $orders,
            'search' => $request->search
        ]);
    }

    public function my(Request $request)
    {
        $this->authorize('viewMy', Order::class);

        if ($request->search) {
            $this->search($request->search);
        }

        $orders = Order::query()
            ->orderByDesc('id')
            ->where('manager_id', '=',  Auth::user()->id)
            ->where(function ($query) {
                $query->where($this->whereName)
                    ->orWhere($this->whereEmail);
            })
            ->get();

        return view('orders.index', [
            'orders' => $orders,
            'search' => $request->search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Order::class);

        $clients = new User();
        if (Auth::user()->hasRole('superAdmin')) {
            $clients = User::query()
                ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
                ->where('user_roles.role_id', '=', 4)
                ->get();
        }elseif (Auth::user()->hasRole('client')) {
            $clients = User::query()
                ->where('id', '=', Auth::user()->id)
                ->get();
        }

        return view('orders.form', [
            'order' => new Order(),
            'clients' => $clients
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
        $this->authorize('create', Order::class);

        if ($request->isMethod('post')) {
            $request->flash();

            $this->validate($request, Order::rules());

//            for ($i = 0; $i < count($request->title); $i++) {
//                $order = new Order();
//                $order->user_id = Auth::user()->id;
//                $order->status_id = 1;
//                $order->title = $request->title[$i];
//                $order->count = $request->count[$i];
//                $order->link = $request->link[$i];
//                $order->price = $request->price[$i] ?? 0;
//                $order->color = $request->color[$i];
//                $order->size = $request->size[$i];
//                $order->description = $request->description[$i];
//                $order->save();
//                $this->ship($request, $order->id);
//            }
            $order = new Order();
            $order->fill($request->all());
            $order->status_id = 1;
            $order->price = $request->price ?? 0;

            $route = '';
            if (Auth::user()->hasRole('superAdmin')) {
                $route = 'superAdmin.';
            }

            if ($order->save()) {
                $this->ship($request, $order->id);
                return redirect()->route($route.'order.index')
                    ->with('success', 'Данные успешно добавлены!');
            }

            return redirect()->route($route.'order.create')
                ->with('error', 'Ошибка добавления данных!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Order $order)
    {
        $this->authorize('view', $order);

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

        return view('orders.show', [
            'item' => $order,
            'statuses' => $statuses,
            'managers' => $managers
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Order $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $this->authorize('update', $order);

        if (!Gate::allows('canEditByStatus', $order) ||
            !Gate::allows('canDelete', $order)) {
            return redirect()->back();
        }

        $clients = new User();
        if (Auth::user()->hasRole('superAdmin')) {
            $clients = User::query()
                ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
                ->where('user_roles.role_id', '=', 4)
                ->get();
        }elseif (Auth::user()->hasRole('client')) {
            $clients = User::query()
                ->where('id', '=', Auth::user()->id)
                ->get();
        }

        return view('orders.form', [
            'order' => $order,
            'clients' => $clients
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
        $this->authorize('update', $order);

        if ($request->isMethod('put')) {

            $request->flash();

            $this->validate($request, Order::rules());

            $order->fill($request->all());

            $route = '';
            if (Auth::user()->hasRole('superAdmin')) {
                $route = 'superAdmin.';
            }

            if ($order->save()) {
                $this->ship($request, $order->id, 'create');
                return redirect()->route($route.'order.index')
                    ->with('success', 'Данные успешно обновленны!');
            }

            return redirect()->route($route.'order.edit', $order)
                ->with('error', 'Ошибка обновления данных!');
        }
    }

    /**
     * Функция для принятия заказа клиента
     * @param Request $request
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function accept(Request $request, Order $order)
    {
        $this->authorize('accept', $order);

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
    public function status(Request $request, Order $order)
    {
        $this->authorize('status', $order);

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
    public function transfer(Request $request, Order $order)
    {
        $this->authorize('transfer', $order);

        if ($request->isMethod('put')) {
            $order->manager_id = (int)$request->manager_id;
            $order->save();
        }

        return redirect()->route('manager.order.my');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Order $order
     * @return $this
     */
    public function destroy(Request $request, Order $order)
    {
        $this->authorize('delete', $order);

        if ($request->isMethod('delete')) {
            $request->flash();

            //$this->validate($request, Order::rules());

            $route = '';
            if (Auth::user()->hasRole('superAdmin')) {
                $route = 'superAdmin.';
                if ($order->delete()) {
                    return redirect()->route('superAdmin.order.index')
                        ->with('success', 'Данные успешно удаленны!');
                }
            }

            if (Auth::user()->hasRole('client')) {
                $order->isDeleted = 1;

                if ($order->save()) {
                    return redirect()->route('order.index')
                        ->with('success', 'Данные успешно изменены!');
                }
            }

            return redirect()->route($route.'order.index')
                ->with('error', 'Ошибка удаления данных!');
        }
    }

    /**
     * Ship the given order.
     *
     * @param  Request  $request
     * @param  int  $orderId
     * @return Response
     */
    public function ship(Request $request, $orderId, $status = '')
    {
        $order = Order::findOrFail($orderId);

        // Ship order...

        Mail::to($request->user())->send(new OrderShipped($order, $status));
    }
}
