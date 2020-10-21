<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminController extends Controller
{
    public function index()
    {
        debug(Auth::user(), true);
        echo csrf_token();
        return view('superadmins.index');
    }
}
