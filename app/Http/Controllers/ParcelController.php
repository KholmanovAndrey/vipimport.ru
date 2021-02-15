<?php

namespace App\Http\Controllers;

use App\Address;
use App\Mail\ParcelShipped;
use App\Message;
use App\Order;
use App\Parcel;
use App\Status;
use App\Support;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ParcelController extends Controller
{
    public $whereName;
    public $whereEmail;

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
        $this->authorize('viewAny', Parcel::class);

        if ($request->search) {
            $this->search($request->search);
        }

        if ($request->status_id) {
            $whereStatus = ['status_id', '=', (int)$request->status_id];
        } else {
            $whereStatus = ['status_id', '>', 0];
        }

        $parcels = Parcel::query()
            ->orderByDesc('id')
            ->where([
                $whereStatus
            ])
            ->where(function ($query) {
                $query->where($this->whereName)
                    ->orWhere($this->whereEmail);
            })
            ->get();

        $statuses = Status::query()->where('table_name', '=', 'parcels')->get();

        return view('parcels.index', [
            'parcels' => $parcels,
            'search' => $request->search,
            'statuses' => $statuses
        ]);
    }

    public function new(Request $request)
    {
        $this->authorize('viewNew', Parcel::class);

        if ($request->search) {
            $this->search($request->search);
        }

        $parcels = Parcel::query()
            ->orderByDesc('id')
            ->where([
                ['manager_id', '=', null],
                ['status_id', '=', 7]
            ])
            ->where(function ($query) {
                $query->where($this->whereName)
                    ->orWhere($this->whereEmail);
            })
            ->get();

        $statuses = Status::query()->where('table_name', '=', 'parcels')->get();

        return view('parcels.index', [
            'parcels' => $parcels,
            'search' => $request->search,
            'statuses' => $statuses
        ]);
    }

    public function my(Request $request)
    {
        $this->authorize('viewMy', Parcel::class);

        if ($request->search) {
            $this->search($request->search);
        }

        if ($request->status_id) {
            $whereStatus = ['status_id', '=', (int)$request->status_id];
        } else {
            $whereStatus = ['status_id', '>', 0];
        }

        $whereUser = [];
        if (Auth::user()->hasRole('manager')) {
            $whereUser = ['manager_id', '=', Auth::user()->id];
        } elseif (Auth::user()->hasRole('client')) {
            $whereUser = ['user_id', '=', Auth::user()->id];
        }

        $parcels = Parcel::query()
            ->orderByDesc('id')
            ->where([
                [$whereUser[0], $whereUser[1], $whereUser[2]],
                $whereStatus
            ])
            ->where(function ($query) {
                $query->where($this->whereName)
                    ->orWhere($this->whereEmail);
            })
            ->get();

        $statuses = Status::query()->where('table_name', '=', 'parcels')->get();

        return view('parcels.index', [
            'parcels' => $parcels,
            'search' => $request->search,
            'statuses' => $statuses
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
        $addresses = new Address();
        if (Auth::user()->hasRole('superAdmin')) {
            $clients = User::query()
                ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
                ->where('user_roles.role_id', '=', 4)
                ->get();
            $addresses = Address::query()->where('user_id', '=', Auth::user()->id)->get();
        }elseif (Auth::user()->hasRole('client')) {
            $clients = User::query()
                ->where('id', '=', Auth::user()->id)
                ->get();
            $addresses = Address::query()->where('user_id', '=', Auth::user()->id)->get();
        }

        return view('parcels.form', [
            'parcel' => new Parcel(),
            'addresses' => $addresses,
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
        if ($request->isMethod('post')) {
            $request->flash();

            $this->validate($request, Parcel::rules());

            $parcel = new Parcel();
            $parcel->address_id = $request->address_id ? (int)$request->address_id : null;
            $parcel->title = $request->title;
            $parcel->description = $request->description;
            $parcel->user_id = $request->user_id;
            $address = Address::query()->where('id', '=', (int)$request->address_id)->first();

            $fio = '';
            $addressStr = '';
            if ($address) {
                $fio = "{$address->lastname} {$address->firstname} {$address->othername}";
                $addressStr = "{$address->postal_code}, {$address->country->title}, {$address->region}, {$address->city}, {$address->street}, дом {$address->building}";
                if ($address->body) {
                    $addressStr .= ", кор. {$address->body}";
                }
                if ($address->apartment) {
                    $addressStr .= ", кв. {$address->apartment}";
                }
            }

            $parcel->fio = trim($fio);
            $parcel->address = trim($addressStr);
            $parcel->phone = $address->phone ?? '';

            if ($parcel->save()) {
                //$this->ship($request, $parcel->id);
                return redirect()->route('parcel.show', $parcel)
                    ->with('success', 'Данные успешно добавлены!');
            }

            return redirect()->route('parcel.create')
                ->with('success', 'Ошибка добавления данных!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Parcel $parcel
     * @return \Illuminate\Http\Response
     */
    public function show(Parcel $parcel)
    {
        $this->authorize('view', $parcel);

        $statuses = Status::query()
            ->where([
                ['table_name', '=', 'parcels'],
                ['id', '>', 9]
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

        $orders = Order::query()
            ->where([
                ['user_id', '=', $parcel->user_id],
                ['parcel_id', '=', null],
                ['isDeleted', '=', 0],
                ['status_id', '=', 5]
            ])
            ->orderByDesc('id')
            ->get();
        return view('parcels.show', [
            'item' => $parcel,
            'orders' => $orders,
            'statuses' => $statuses,
            'managers' => $managers
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Parcel $parcel
     * @return \Illuminate\Http\Response
     */
    public function edit(Parcel $parcel)
    {
        $this->authorize('update', $parcel);

        if (!Gate::allows('canEditByStatus', $parcel)) {
            return redirect()->back();
        }

        $clients = new User();
        $addresses = new Address();
        if (Auth::user()->hasRole('superAdmin')) {
            $clients = User::query()
                ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
                ->where('user_roles.role_id', '=', 4)
                ->get();
            $addresses = Address::query()->where('user_id', '=', $parcel->user_id)->get();
        }elseif (Auth::user()->hasRole('client')) {
            $clients = User::query()
                ->where('id', '=', Auth::user()->id)
                ->get();
            $addresses = Address::query()->where('user_id', '=', Auth::user()->id)->get();
        }

        return view('parcels.form', [
            'parcel' => $parcel,
            'addresses' => $addresses,
            'clients' => $clients
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Parcel $parcel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Parcel $parcel)
    {
        $this->authorize('update', $parcel);

        if (!Gate::allows('canEditByStatus', $parcel)) {
            return redirect()->back();
        }

        if ($request->isMethod('put')) {
            $request->flash();

            $this->validate($request, Parcel::rules());

            $parcel->address_id = (int)$request->address_id;
            $parcel->title = $request->title;
            $parcel->description = $request->description;
            $parcel->user_id = $request->user_id;
            $address = Address::query()->where('id', '=', (int)$request->address_id)->first();
            $fio = "{$address->lastname} {$address->firstname} {$address->othername}";
            $parcel->fio = trim($fio);
            $addressStr = "{$address->postal_code}, {$address->country->title}, {$address->region}, {$address->city}, {$address->street}, дом {$address->building}";
            if ($address->body) {
                $addressStr .= ", кор. {$address->body}";
            }
            if ($address->apartment) {
                $addressStr .= ", кв. {$address->apartment}";
            }
            $parcel->address = trim($addressStr);
            $parcel->phone = $address->phone;

            if ($parcel->save()) {
                //$this->ship($request, $parcel->id);
                return redirect()->route('parcel.show', $parcel)
                    ->with('success', 'Данные успешно добавлены!');
            }

            return redirect()->route('parcel.create')
                ->with('success', 'Ошибка добавления данных!');
        }
    }

    /**
     * Функция для принятия посылки клиента
     * @param Request $request
     * @param Parcel $parcel
     * @return \Illuminate\Http\RedirectResponse
     */
    public function accept(Request $request, Parcel $parcel)
    {
        $this->authorize('accept', $parcel);

        if ($request->isMethod('put')) {
            $parcel->manager_id = Auth::user()->id;
            $parcel->save();
        }

        return redirect()->back();
    }

    /**
     * Функция для изменения статуса заказа
     * @param Request $request
     * @param Parcel $parcel
     * @return \Illuminate\Http\RedirectResponse
     */
    public function status(Request $request, Parcel $parcel)
    {
        $this->authorize('status', $parcel);

        if ($request->isMethod('put')) {
            $parcel->status_id = (int)$request->status_id;
            $parcel->save();
        }

        return redirect()->back()
            ->with('success', 'Статус изменен!');
    }

    /**
     * Передача заказа клиента другому менеджеру
     * @param Request $request
     * @param Parcel $parcel
     * @return \Illuminate\Http\RedirectResponse
     */
    public function transfer(Request $request, Parcel $parcel)
    {
        $this->authorize('transfer', $parcel);

        if ($request->isMethod('put')) {
            $parcel->manager_id = (int)$request->manager_id;
            $parcel->save();
        }

        return redirect()->route('parcel.my');
    }

    /**
     * Назначение трекера
     * @param Request $request
     * @param Parcel $parcel
     * @return \Illuminate\Http\RedirectResponse
     */
    public function tracker(Request $request, Parcel $parcel)
    {
        $this->authorize('tracker', $parcel);

        if ($request->isMethod('put')) {
            if (!$request->tracker) {
                return redirect()->back()
                    ->with('error', 'Поле трекера не должно быть пустым!');
            }

            $parcel->tracker = htmlspecialchars(trim($request->tracker));
            $parcel->save();
        }

        return redirect()->back()
            ->with('success', 'Трекер добавлена!');
    }

    /**
     * Назначение цены
     * @param Request $request
     * @param Parcel $parcel
     * @return \Illuminate\Http\RedirectResponse
     */
    public function price(Request $request, Parcel $parcel)
    {
        $this->authorize('price', $parcel);

        if ($request->isMethod('put')) {
            $file = $request->file('receipt');

            if (!$request->price) {
                return redirect()->back()
                    ->with('error', 'Поле цены не должно быть пустым или равным 0!');
            }

            if (!$file) {
                return redirect()->back()
                    ->with('error', 'Счет должен быть прекреплен!');
            }

            //перемещаем загруженный файл
            $destinationPath = 'public/files/receipts';
            Storage::putFileAs($destinationPath, $file, $file->getClientOriginalName());

            $parcel->price = $request->price;
            $parcel->receipt = $file->getClientOriginalName();
            $parcel->status_id = 8;
            $parcel->save();
        }

        return redirect()->back()
            ->with('success', 'Цена и статус изменены!');
    }

    /**
     * Оплачено
     * @param Request $request
     * @param Parcel $parcel
     * @return \Illuminate\Http\RedirectResponse
     */
    public function isPaid(Request $request, Parcel $parcel)
    {
        $this->authorize('isPaid', $parcel);

        if ($request->isMethod('put')) {
            if ((boolean)$request->isPaid !== true) {
                return redirect()->back()
                    ->with('error', 'Ошибка оплаты, обратитесь к администратору сайта!');
            }

            if ((boolean)$request->isPaid) {
                $parcel->isPaid = 1;
                $parcel->status_id = 9;
                $parcel->save();
            }
        }

        return redirect()->back()
            ->with('success', 'Посылка оплачена!');
    }

    /**
     * Функция для добавления заказа в посылку
     * @param Request $request
     * @param Parcel $parcel
     * @return \Illuminate\Http\RedirectResponse
     */
    public function orderAddParcelID(Request $request, Parcel $parcel)
    {
        $this->authorize('orderAddParcelID', $parcel);

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
        $this->authorize('orderDeleteParcelID', Parcel::class);

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
        $this->authorize('parcelSendToPackaging', $parcel);

        if ($request->isMethod('put')) {

            $orders = Order::query()->where('parcel_id', '=', $parcel->id)->get();
            if (empty($orders->toArray())) {
                return redirect()->back()
                    ->with('error', 'Нельзя отправить на упаковку! Необходимо прекрепить хотя бы один заказ!');
            }

            $parcel->status_id = 7;
            $parcel->save();
        }

        return redirect()->back()
            ->with('success', 'Посылка отправлена на упоковку!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @param  Parcel $parcel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Parcel $parcel)
    {
        $this->authorize('delete', $parcel);

        if (!Gate::allows('canEditByStatus', $parcel)) {
            return redirect()->back();
        }

        if ($request->isMethod('delete')) {
            foreach ($parcel->orders as $orderParcel) {
                if ($order = Order::find($orderParcel->id)) {
                    $order->parcel_id = null;
                    $order->save();
                }
            }
            foreach ($parcel->supports as $supportParcel) {
                if ($support = Support::find($supportParcel->id)) {
                    foreach ($support->messages as $messageParcel) {
                        if ($message = Message::find($messageParcel->id)) {
                            $message->delete();
                        }
                    }
                    $support->delete();
                }
            }
            if ($parcel->delete()) {
                return redirect()->route(Auth::user()->hasRole('superAdmin') ? 'parcel.index' : 'parcel.my')
                    ->with('success', 'Данные успешно добавлены!');
            }
        }
    }

    /**
     * Ship the given parcel.
     *
     * @param  Request  $request
     * @param  int  $orderId
     * @return Response
     */
    public function ship(Request $request, $parcelId)
    {
        $parcel = Parcel::findOrFail($parcelId);

        // Ship parcel...

        Mail::to($request->user())->send(new ParcelShipped($parcel));
    }
}
