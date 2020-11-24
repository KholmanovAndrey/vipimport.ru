<?php
$title = 'Заказы пользователя';
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
                <h1>{{ $user->email }} ({{ $user->profile['lastname'] }} {{ $user->profile['firstname'] }} {{ $user->profile['othername'] }})</h1>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col" class="align-middle text-center">#</th>
                            <th scope="col">Имя</th>
                            <th scope="col">Статус</th>
                            <th scope="col" class="align-middle text-right">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $item)
                            <tr>
                                <th scope="row" class="align-middle text-center">Z{{ $item->id }}</th>
                                <td class="align-middle">{{ $item->title }}</td>
                                <td class="align-middle">
                                    <span class="badge badge-warning">{{ $item->status->title }}</span>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('order.edit', $item) }}" class="btn btn-primary" title="Заказ">
                                            <i class="czi-view-grid align-middle"></i></a>
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