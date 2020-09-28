<?php

namespace App\Http\Controllers;

use App\Parcel;
use Illuminate\Http\Request;

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
}
