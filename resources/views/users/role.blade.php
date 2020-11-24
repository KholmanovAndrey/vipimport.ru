<?php
$title = 'Роли пользователя';
$breadcrumbs = [
    [
        'name' => 'Личный кабинет',
        'route' => route(\Illuminate\Support\Facades\Auth::user()->roles[0]->name . '.index'),
    ],
    [
        'name' => 'Пользователи',
        'route' => route('superAdmin.user.index'),
    ],
    [
        'name' => $title,
        'route' => '',
    ]
];
?>
@extends('layouts.app')

@section('title', $title)

@section('dashboard')
    <x-dashboard :title="$title" :breadcrumbs="$breadcrumbs"/>
@endsection

@section('sidebar')
    @parent

    <div class="sidebar col-lg-3">
        <x-office/>
    </div>
@endsection

@section('content')
    <div class="items col-lg-9">
        <x-user-title/>
        <div class="card py-4 mb-4">
            <div class="card-body">
                <h1>{{ $user->email }}
                    @if($user->profile)
                        {{ $user->profile['lastname'] }} {{ $user->profile['firstname'] }} {{ $user->profile['othername'] }}
                    @endif
                </h1>
                <form method="post" action="{{ route('superAdmin.user.role.update', $user) }}">
                    @csrf
                    @method('PUT')
                    <table class="table table-hover">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Роль</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $item)
                            <tr>
                                <th scope="row" class="my-0 py-0"><label for="{{ $item->name }}" class="d-block mb-0 py-2">{{ $item->name }}</label></th>
                                <td class="d-flex justify-content-center align-items-center">
                                    <input type="checkbox"
                                           name="role[]"
                                           id="{{ $item->name }}"
                                           value="{{ $item->id }}"
                                           class="form-check mb-0 py-2"
                                           @if(in_array($item->name, \Illuminate\Support\Arr::pluck($user->roles->toArray(), 'name')))
                                               checked="checked"
                                           @endif
                                    >
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary">
                        Сохранить
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection