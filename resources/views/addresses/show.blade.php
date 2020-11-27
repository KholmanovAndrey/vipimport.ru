<?php
$title = 'Адрес';
$breadcrumbs = [
    [
        'name' => 'Личный кабинет',
        'route' => route(\Illuminate\Support\Facades\Auth::user()->roles[0]->name . '.index'),
    ],
    [
        'name' => 'Все адреса',
        'route' => route('address.index'),
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
    <div class="col-lg-9">
        <x-user-title/>
        <div class="card py-4 mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col" class="align-middle text-center"></th>
                            <th scope="col">Данные получателя</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="th-dark">ФИО получателя:</th>
                                <td>{{ $item->lastname }} {{ $item->firstname }} {{ $item->othername }}</td>
                            </tr>
                            <tr>
                                <th>Адрес получателя:</th>
                                <td>
                                    {{ $item->postal_code }},
                                    {{ $item->region }},
                                    {{ $item->city }},
                                    {{ $item->street }},
                                    {{ $item->building }}
                                    @if($item->body), кор. {{ $item->body }}@endif
                                    @if($item->apartment), кв. {{ $item->apartment }}@endif
                                </td>
                            </tr>
                            <tr>
                                <th>Телефон получателя:</th>
                                <td>{{ $item->phone }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection