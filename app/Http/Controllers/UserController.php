<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);

        if (Auth::user()->email === 'andrekho@mail.ru') {
            $users = User::query()->get();
        } else {
            $users = User::query()
                ->where('email', '!=', 'andrekho@mail.ru')
                ->get();
        }

        return view('users.index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', User::class);

        return view('users.form', [
            'user' => new User()
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
        $this->authorize('create', User::class);

        if ($request->isMethod('post')) {
            $request->flash();

            $this->validate($request, User::rulesCreate());

            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'api_token' => Str::random(60)
            ]);

            if ($user) {
                DB::table('user_roles')->insert([
                    'user_id' => $user->id,
                    'role_id' => 4
                ]);
            }

            return redirect()->route('superAdmin.user.index', $user)
                ->with('success', 'Данные успешно добавлены!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        return view('users.show', [
            'item' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('users.form', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        if ($request->isMethod('put')) {
            $request->flash();

            $this->validate($request, User::rulesUpdate($user));

            $user->fill($request->all());
//            $user->password = Hash::make($request['password']);
            $user->save();

            return redirect()->route('user.index', $user)
                ->with('success', 'Данные успешно добавлены!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param User $user
     */
    public function destroy(Request $request, User $user)
    {
        $this->authorize('delete', $user);

        if ($request->isMethod('delete')) {
            $user->delete();
        }
    }

    public function role(User $user)
    {
        $this->authorize('role', $user);

        $roles = Role::all();
        return view('users.role', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    public function roleUpdate(Request $request, User $user)
    {
        $this->authorize('roleUpdate', $user);

        if ($request->isMethod('put')) {
            if($request->role) {
                DB::table('user_roles')->where('user_id', '=', $user->id)->delete();

                $data = array();
                foreach($request->role as $role){
                    $data[] = [
                        'user_id' => (int)$user->id,
                        'role_id' => (int)$role,
                    ];
                }
                DB::table('user_roles')->insert($data);
            }
        }

        return redirect()->back();
    }
}
