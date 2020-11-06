<?php
$title = 'Статистика';
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
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-common" role="tab" aria-controls="pills-home" aria-selected="true">
                            Общая</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="pills-home-tab" data-toggle="pill" href="#pills-managers" role="tab" aria-controls="pills-home" aria-selected="true">
                            Менеджеры <span class="badge badge-danger badge-pill">{{ count($managers) }}</span></a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="pills-home-tab" data-toggle="pill" href="#pills-clients" role="tab" aria-controls="pills-home" aria-selected="true">
                            Клиенты <span class="badge badge-danger badge-pill">{{ count($clients) }}</span></a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-common" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col" class="align-middle">Пользователи</th>
                                    <th scope="col" class="align-middle text-right">Количество</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th scope="row" class="align-middle">Менеджеры</th>
                                    <td class="align-middle text-right">
                                        {{ count($managers) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="align-middle">Клиенты</th>
                                    <td class="align-middle text-right">
                                        {{ count($clients) }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col" class="align-middle">Заказы</th>
                                    <th scope="col" class="align-middle text-right">Количество</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($statusOrders as $item)
                                    <tr>
                                        <th scope="row" class="align-middle">{{ $item->title }}</th>
                                        <td class="align-middle text-right">
                                            {{ count($item->orders) }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col" class="align-middle">Посылки</th>
                                    <th scope="col" class="align-middle text-right">Количество</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($statusParcels as $item)
                                    <tr>
                                        <th scope="row" class="align-middle">{{ $item->title }}</th>
                                        <td class="align-middle text-right">
                                            {{ count($item->parcels) }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-managers" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col" class="align-middle text-center">#</th>
                                    <th scope="col">Имя</th>
                                    <th scope="col">E-mail</th>
                                    <th scope="col" class="align-middle text-center">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($managers as $item)
                                    <tr>
                                        <th scope="row" class="align-middle text-center">{{ $item->id }}</th>
                                        <td class="align-middle">{{ $item->name }}</td>
                                        <td class="align-middle">{{ $item->email }}</td>
                                        <td class="align-middle text-center">
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('superAdmin.user-statistic', $item) }}" class="btn btn-primary mr-1" title="Статистика пользователя">
                                                    <i class="czi-document align-middle"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-clients" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col" class="align-middle text-center">#</th>
                                    <th scope="col">Имя</th>
                                    <th scope="col">E-mail</th>
                                    <th scope="col" class="align-middle text-center">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($clients as $item)
                                    <tr>
                                        <th scope="row" class="align-middle text-center">{{ $item->id }}</th>
                                        <td class="align-middle">{{ $item->name }}</td>
                                        <td class="align-middle">{{ $item->email }}</td>
                                        <td class="align-middle text-center">
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('superAdmin.user-statistic', $item) }}" class="btn btn-primary mr-1" title="Статистика пользователя">
                                                    <i class="czi-document align-middle"></i></a>
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
        </div>
    </div>
@endsection