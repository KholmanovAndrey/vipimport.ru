<?php
$title = 'Мои посылки';
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
                <h2>Мои посылки:</h2>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col" class="align-middle text-center">#</th>
                            <th scope="col" class="align-middle">Наименование</th>
                            <th scope="col" class="align-middle text-center d-none d-md-block">Клиент</th>
                            <th scope="col" class="align-middle text-center">Статус</th>
                            <th scope="col" class="align-middle text-center">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($parcels as $item)
                            <tr>
                                <th scope="row" class="align-middle text-center">P{{ $item->id }}</th>
                                <td class="align-middle">{{ $item->title }}</td>
                                <td class="align-middle text-center d-none d-md-block">
                                    <a href="{{ route('manager.client-view', $item->client) }}">{{ $item->client->name }}</a>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="badge badge-warning">{{ $item->status->title }}</span>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="d-flex justify-content-center">
                                        <a class="btn btn-primary" href="{{ route('manager.parcel-show', $item) }}" title="Перейти к посылке">
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
@endsection