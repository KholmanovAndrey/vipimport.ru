<?php

namespace App\Http\Controllers;

use App\Order;
use App\Parcel;
use App\Support;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    public $whereName;
    public $whereEmail;

    /**
     * SupportController constructor.
     */
    function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Поиск клиента по name or email
     * @param $search
     */
    private function search($search)
    {
        $clients = User::query()->where('name', 'like', "%{$search}%")->get();
        foreach ($clients as $client) {
            $this->whereName[0] = ['client_id', '=', $client->id];
        }
        $clients = User::query()->where('email', 'like', "%{$search}%")->get();
        foreach ($clients as $client) {
            $this->whereEmail[0] = ['client_id', '=', $client->id];
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Support::class);

        if ($request->search) {
            $this->search($request->search);
        }

        $supports = Support::query()
            ->orderByDesc('id')
            ->where($this->whereName)
            ->orWhere($this->whereEmail)
            ->get();
        return view('supports.index', [
            'supports' => $supports,
            'search' => $request->search
        ]);
    }

    public function new(Request $request)
    {
        $this->authorize('viewNew', Support::class);

        if ($request->search) {
            $this->search($request->search);
        }

        $supports = Support::query()
            ->orderByDesc('id')
            ->where('manager_id', '=', null)
            ->where(function ($query) {
                $query->where($this->whereName)
                    ->orWhere($this->whereEmail);
            })
            ->get();

        return view('supports.index', [
            'supports' => $supports,
            'search' => $request->search
        ]);
    }

    public function my(Request $request)
    {
        $this->authorize('viewMy', Support::class);

        if ($request->search) {
            $this->search($request->search);
        }

        $whereUser = [];
        if (Auth::user()->hasRole('manager')) {
            $whereUser = ['manager_id', '=', Auth::user()->id];
        } elseif (Auth::user()->hasRole('client')) {
            $whereUser = ['client_id', '=', Auth::user()->id];
        }

        $supports = Support::query()
            ->orderByDesc('id')
            ->where($whereUser[0], $whereUser[1], $whereUser[2])
            ->where(function ($query) {
                $query->where($this->whereName)
                    ->orWhere($this->whereEmail);
            })
            ->get();

        return view('supports.index', [
            'supports' => $supports,
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
        $orders = Order::query()
            ->where('user_id', '=', Auth::user()->id)
            ->get();
        $parcels = Parcel::query()
            ->where('user_id', '=', Auth::user()->id)
            ->get();
        return view('supports.form', [
            'support' => new Support(),
            'orders' => $orders,
            'parcels' => $parcels
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

            $this->validate($request, Support::rules());

            $support = new Support();
            $support->client_id = Auth::user()->id;
            $support->manager_id = $this->supportManagerID($request);
            $support->fill($request->all());

            if ($support->save()) {
                return redirect()->route('support.show', $support)
                    ->with('success', 'Данные успешно добавлены!');
            }

            return redirect()->route('support.create')
                ->with('success', 'Ошибка добавления данных!');
        }
    }

    private function supportManagerID(Request $request)
    {
        if ($request->order_id) {
            $order = Order::find($request->order_id);
            return $order->manager_id;
        }
        if ($request->parcel_id) {
            $parcel = Parcel::find($request->parcel_id);
            return $parcel->manager_id;
        }
        return null;
    }

    /**
     * Display the specified resource.
     *
     * @param  Support $support
     * @return \Illuminate\Http\Response
     */
    public function show(Support $support)
    {
        $this->authorize('view', $support);

        if (Auth::user()->hasRole('client')) {
            $support->client_view_at = date('Y-m-d H:i:s');
        } else {
            $support->manager_view_at = date('Y-m-d H:i:s');
        }
        $support->save();

        return view('supports.view', [
            'item' => $support
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Функция для принятия запроса в тех. поддержку
     * @param Request $request
     * @param Support $support
     * @return \Illuminate\Http\RedirectResponse
     */
    public function accept(Request $request, Support $support)
    {
        $this->authorize('accept', $support);

        if ($request->isMethod('put')) {
            $support->manager_id = Auth::user()->id;
            $support->save();
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
