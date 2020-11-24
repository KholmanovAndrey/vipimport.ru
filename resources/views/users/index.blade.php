<?php
$title = 'Пользователи';
$breadcrumbs = [
    [
        'name' => 'Личный кабинет',
        'route' => route(\Illuminate\Support\Facades\Auth::user()->roles[0]->name . '.index'),
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
                <div class="button-panel mb-4">
                    <a href="{{ route('superAdmin.user.create') }}" class="btn btn-primary" title="Добавить пользователя">
                        <i class="czi-add-user align-middle"></i> Добавить пользователя</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col" class="align-middle text-center">#</th>
                            <th scope="col">Имя</th>
                            <th scope="col">ФИО</th>
                            <th scope="col">Роли</th>
                            <th scope="col" class="align-middle text-right">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $item)
                            <tr>
                                <th scope="row" class="align-middle text-center">{{ $item->id }}</th>
                                <td class="align-middle">{{ $item->name }}</td>
                                <td class="align-middle">
                                    @if($item->profile)
                                        {{ $item->profile['lastname'] }} {{ $item->profile['firstname'] }} {{ $item->profile['othername'] }}
                                    @endif
                                </td>
                                <td class="align-middle">
                                    @foreach($item->roles as $role)
                                        {{ $role->name }}<br/>
                                    @endforeach
                                </td>
                                <td class="align-middle text-center">
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('superAdmin.user.edit', $item) }}" class="btn btn-primary mr-2" title="Редактирование пользователя">
                                            <i class="czi-edit align-middle"></i></a>
                                        <a href="{{ route('superAdmin.user.role', $item) }}" class="btn btn-primary" title="Назначение ролей пользователя">
                                            <i class="czi-user-circle align-middle"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection