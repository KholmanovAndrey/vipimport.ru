<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Order;
use App\Parcel;
use App\Role;
use App\Status;
use App\Support;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SuperAdminController extends Controller
{
    function __construct()
    {
        $this->middleware('role:superAdmin');
    }

    public function index()
    {
        return view('superadmins.index');
    }

    public function userView(Request $request)
    {
        $where = ['id', '!=', '1'];
        if ($request->search) {
            $where = ['name', 'like', "%{$request->search}%"];
        }
        $users = User::query()
            ->where([
                ['id', '!=', '1'],
                $where
            ])
            ->get();
        return view('superadmins.users.view', [
            'users' => $users,
            'search' => $request->search
        ]);
    }

    public function statistic()
    {
        $role = Role::find(3);
        $managers = $role->users;
        foreach ($managers as $key => $manager) {
            if ($manager->email === 'andrekho@mail.ru') {
                unset($managers[$key]);
            }
        }
        $role = Role::find(4);
        $clients = $role->users;

        $statusOrders = Status::query()->where('table_name', '=', 'orders')->get();
        $statusParcels = Status::query()->where('table_name', '=', 'parcels')->get();

        return view('superadmins.statistic', [
            'managers' => $managers,
            'clients' => $clients,
            'statusOrders' => $statusOrders,
            'statusParcels' => $statusParcels,
        ]);
    }

    public function userStatistic(User $user)
    {
        if ($user->hasRole('manager')) {
            $orders = Order::query()->where('manager_id', '=', $user->id)->get();
            $parcels = Parcel::query()->where('manager_id', '=', $user->id)->get();
            $supports = Support::query()->where('manager_id', '=', $user->id)->get();

            return view('superadmins.users.statistic', [
                'user' => $user,
                'role' => 'manager',
                'orders' => $orders,
                'parcels' => $parcels,
                'supports' => $supports,
            ]);
        }
        if ($user->hasRole('client')) {
            $orders = Order::query()->where('user_id', '=', $user->id)->get();
            $parcels = Parcel::query()->where('user_id', '=', $user->id)->get();
            $supports = Support::query()->where('client_id', '=', $user->id)->get();

            return view('superadmins.users.statistic', [
                'user' => $user,
                'role' => 'client',
                'orders' => $orders,
                'parcels' => $parcels,
                'supports' => $supports,
            ]);
        }
    }

//    public function userDelete(Request $request, User $user)
//    {
//        if ($request->isMethod('delete')) {
//            DB::table('user_roles')->where('user_id', '=', $user->id)->delete();
//            DB::table('parcels')->where('user_id', '=', $user->id)->delete();
//            DB::table('addresses')->where('user_id', '=', $user->id)->delete();
//            DB::table('messages')->where('user_id', '=', $user->id)->delete();
//            DB::table('orders')->where('user_id', '=', $user->id)->delete();
//            DB::table('profiles')->where('user_id', '=', $user->id)->delete();
//            DB::table('supports')->where('client_id', '=', $user->id)->delete();
//            $user->delete();
//        }
//
//        return redirect()->back();
//    }

    public function userOrder(User $user)
    {
        $orders = Order::query()
            ->where('user_id', '=', $user->id)
            ->get();
        return view('superadmins.users.order', [
            'orders' => $orders,
            'user' => $user
        ]);
    }

    public function userParcel(User $user)
    {
        $parcels = Parcel::query()
            ->where('user_id', '=', $user->id)
            ->get();
        return view('superadmins.users.parcel', [
            'parcels' => $parcels,
            'user' => $user
        ]);
    }
}
