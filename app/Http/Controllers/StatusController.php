<?php

namespace App\Http\Controllers;

use App\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * StatusController constructor.
     */
    function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Status::class);

        return view('statuses.index', [
            'statuses' => Status::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Status::class);

        return view('statuses.form', [
            'item' => new Status(),
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
        $this->authorize('create', Status::class);

        if ($request->isMethod('post')) {
            $request->flash();

            $this->validate($request, Status::rules());
            $status = new Status();
            $status->fill($request->all());

            if ($status->save()) {
                return redirect()->route('status.index')
                    ->with('success', 'Данные успешно добавлены!');
            }

            return redirect()->route('status.index')
                ->with('error', 'Данные не были добавлены!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Status $status
     * @return \Illuminate\Http\Response
     */
    public function show(Status $status)
    {
        $this->authorize('view', $status);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Status $status
     * @return \Illuminate\Http\Response
     */
    public function edit(Status $status)
    {
        $this->authorize('update', $status);

        return view('statuses.form', [
            'item' => $status,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Status $status
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Status $status)
    {
        $this->authorize('update', $status);

        if ($request->isMethod('put')) {
            $request->flash();

            $this->validate($request, Status::rules());
            $status->fill($request->all());

            if ($status->save()) {
                return redirect()->route('status.index')
                    ->with('success', 'Данные успешно обновлены!');
            }

            return redirect()->route('status.index')
                ->with('error', 'Данные не были обновлены!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @param  Status $status
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Status $status)
    {
        $this->authorize('delete', $status);

        if ($request->isMethod('delete')) {
            if ($status->delete()) {
                return redirect()->route('status.index')
                    ->with('success', 'Данные успешно удалены!');
            }

            return redirect()->route('status.index')
                ->with('error', 'Данные не были удалены!');
        }
    }
}
