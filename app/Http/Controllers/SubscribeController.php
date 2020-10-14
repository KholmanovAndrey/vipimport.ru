<?php

namespace App\Http\Controllers;

use App\Subscribe;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, Subscribe::rules());

            if(!Subscribe::query()->where('email', '=', $request->email)->first()){
                $subscribe = new Subscribe();
                $subscribe->fill($request->all());
                $subscribe->save();
            }

            return redirect()->back();
        }
    }
}
