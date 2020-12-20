<?php
$title = 'Пользователь';
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
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col" class="align-middle text-center"></th>
                            <th scope="col">Данные заказа</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th class="th-dark">Логин:</th>
                            <td>{{ $item->name }}</td>
                        </tr>
                        <tr>
                            <th class="th-dark">E-mail:</th>
                            <td>{{ $item->email }}</td>
                        </tr>
                        @if($item->profile)
                            <tr>
                                <th class="th-dark">ФИО:</th>
                                <td>{{ $item->profile['lastname'] }} {{ $item->profile['firstname'] }} {{ $item->profile['othername'] }}</td>
                            </tr>
                            <tr>
                                <th class="th-dark">Телефоны:</th>
                                <td>{{ $item->profile['phone'] }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection