<?php
$title = 'Статистика пользователя';
$breadcrumbs = [
    [
        'name' => 'Личный кабинет',
        'route' => route(\Illuminate\Support\Facades\Auth::user()->roles[0]->name . '.index'),
    ],
    [
        'name' => 'Пользователи',
        'route' => route('superAdmin.user-view'),
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
                <h1>{{ $user->email }}</h1>
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-order" role="tab" aria-controls="pills-home" aria-selected="true">
                            Заказы <span class="badge badge-danger badge-pill">{{ count($orders) }}</span></a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-parcel" role="tab" aria-controls="pills-profile" aria-selected="false">
                            Посылки <span class="badge badge-danger badge-pill">{{ count($parcels) }}</span></a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-support" role="tab" aria-controls="pills-contact" aria-selected="false">
                            Поддержка <span class="badge badge-danger badge-pill">{{ count($supports) }}</span></a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-order" role="tabpanel" aria-labelledby="pills-home-tab">
                        <table class="table table-hover">
                            <thead class="background-color-default">
                            <tr>
                                <th scope="col">Заказы</th>
                                <th scope="col" class="align-middle text-center">
                                    @if($role === 'manager')
                                        Клиент
                                    @endif
                                    @if($role === 'client')
                                        Менеджер
                                    @endif
                                </th>
                                <th scope="col" class="align-middle text-center">Статус</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $item)
                                <tr>
                                    <th scope="row" class="align-middle">{{ $item->title }}</th>
                                    <td class="align-middle text-center">
                                        @if($role === 'manager')
                                            {{ $item->user['name'] }}
                                        @endif
                                        @if($role === 'client')
                                            {{ $item->manager['name'] }}
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="badge badge-warning">{{ $item->status->title }}</span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="pills-parcel" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <table class="table table-hover">
                            <thead class="background-color-default">
                            <tr>
                                <th scope="col">Посылки</th>
                                <th scope="col" class="align-middle text-center">
                                    @if($role === 'manager')
                                        Клиент
                                    @endif
                                    @if($role === 'client')
                                        Менеджер
                                    @endif
                                </th>
                                <th scope="col" class="align-middle text-center">Статус</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($parcels as $item)
                                <tr>
                                    <th scope="row" class="align-middle">{{ $item->title }}</th>
                                    <td class="align-middle text-center">
                                        @if($role === 'manager')
                                            {{ $item->client['name'] }}
                                        @endif
                                        @if($role === 'client')
                                            {{ $item->manager['name'] }}
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="badge badge-warning">{{ $item->status->title }}</span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="pills-support" role="tabpanel" aria-labelledby="pills-contact-tab">
                        <table class="table table-hover">
                            <thead class="background-color-default">
                            <tr>
                                <th scope="col">Поддержка</th>
                                <th scope="col" class="align-middle text-center">
                                    @if($role === 'manager')
                                        Клиент
                                    @endif
                                    @if($role === 'client')
                                        Менеджер
                                    @endif
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($supports as $item)
                                <tr>
                                    <th scope="row" class="align-middle">{{ $item->title }}</th>
                                    <td class="align-middle text-center">
                                        @if($role === 'manager')
                                            {{ $item->client['name'] }}
                                        @endif
                                        @if($role === 'client')
                                            {{ $item->manager['name'] }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection