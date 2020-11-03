<?php

namespace App\Http\Controllers\Api;

use App\Address;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AddressController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $address = Address::all();
        return $this->sendResponse($address->toArray(), 'Address retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, Address::rules(), Address::messages());
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $address = new Address();
        $address->user_id = Auth::user()->id;
        $address->fill($input);
        $address->save();
        return $this->sendResponse($address->toArray(), 'Address created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $address = Address::find($id);
        if (is_null($address)) {
            return $this->sendError('Address not found.');
        }
        return $this->sendResponse($address->toArray(), 'Address retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Address $address
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Address $address)
    {
        $input = $request->all();
        $validator = Validator::make($input, Address::rules(), Address::messages());
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $address->fill($input);
        $address->save();
        return $this->sendResponse($address->toArray(), 'Address updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Address $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        $address->delete();
        return $this->sendResponse($address->toArray(), 'Address deleted successfully.');
    }
}
