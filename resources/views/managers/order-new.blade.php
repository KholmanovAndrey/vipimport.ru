<?php
$title = 'Новые посылки';
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
                <h2>Заказы:</h2>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col" class="align-middle text-center">#</th>
                            <th scope="col" class="align-middle">Наименование</th>
                            <th scope="col" class="align-middle text-center d-none d-md-block">Клиент</th>
                            <th scope="col" class="align-middle text-center">Статус</th>
                            <th scope="col" class="align-middle text-center">Кол-во</th>
                            <th scope="col" class="align-middle text-center">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $item)
                            <tr>
                                <th scope="row" class="align-middle text-center">Z{{ $item->id }}</th>
                                <td class="align-middle">{{ $item->title }}</td>
                                <td class="align-middle text-center d-none d-md-block">
                                    <a href="{{ route('manager.client-view', $item->user) }}">{{ $item->user->name }}</a>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="badge badge-warning">{{ $item->status->title }}</span>
                                </td>
                                <td class="align-middle text-center">{{ $item->count }}</td>
                                <td class="align-middle text-center">
                                    <div class="d-flex justify-content-center">
                                        <form method="POST"
                                              action="{{ route('manager.order-accept', $item) }}">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-primary" title="Принять заказ">
                                                <i class="czi-add align-middle"></i>
                                            </button>
                                        </form>
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