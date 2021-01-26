<?php
$title = 'Пользователи';
$breadcrumbs = [
    [
        'name' => 'Личный кабинет',
        'route' => route('home'),
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

@section('content')
    <div class="items">
        <div class="card py-4 mb-4">
            <div class="card-body">
                <div class="button-panel mb-4">
                    <a href="{{ route('user.create') }}" class="btn btn-primary" title="Добавить пользователя">
                        <i class="fas fa-plus mr-1"></i>Добавить пользователя</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col" class="align-middle text-center">#</th>
                            <th scope="col">Имя</th>
                            <th scope="col">E-mail</th>
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
                                <td class="align-middle">{{ $item->email }}</td>
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
                                        <a href="{{ route('user.show', $item) }}" class="btn btn-primary mr-2">
                                            <i class="fas fa-eye"></i></a>
                                        <a href="{{ route('user.edit', $item) }}" class="btn btn-primary mr-2" title="Редактирование пользователя">
                                            <i class="far fa-edit"></i></a>
                                        <a href="{{ route('user.role', $item) }}" class="btn btn-primary mr-2" title="Назначение ролей пользователя">
                                            <i class="fas fa-user-tag"></i></a>
                                        <a href="{{ route('order.index', ['search' => $item->email]) }}" class="btn btn-primary mr-2" title="Заказы пользователя">
                                            <i class="fas fa-shopping-cart"></i></a>
                                        <a href="{{ route('parcel.index', ['search' => $item->email]) }}" class="btn btn-primary" title="Посылки пользователя">
                                            <i class="fas fa-shopping-basket"></i></a>
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