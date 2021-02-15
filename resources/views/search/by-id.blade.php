<?php
$title = 'Поиск по ID';
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
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="background-color-default">
                    <tr>
                        <th scope="col" class="align-middle text-center">#</th>
                        <th scope="col">Тип</th>
                        <th scope="col">Наименование</th>
                        <th scope="col">Статус</th>
                        <th scope="col">Цена</th>
                        <th scope="col" class="align-middle text-right">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $item)
                        <tr>
                            <th scope="row" class="align-middle text-center">{{ $item->id }}</th>
                            <td class="align-middle">Заказ</td>
                            <td class="align-middle">{{ $item->title }}</td>
                            <td class="align-middle">
                                <span class="badge badge-warning">{{ $item->status->title }}</span>
                            </td>
                            <td class="align-middle">
                                @if($item->price)
                                    {{ $item->price }} руб.
                                @endif
                            </td>
                            <td class="align-middle text-right">
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('order.show', $item) }}" class="btn btn-primary">
                                        <i class="fas fa-eye"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    @foreach($parcels as $item)
                    <tr>
                        <th scope="row" class="align-middle text-center">{{ $item->id }}</th>
                        <td class="align-middle">Посылка</td>
                        <td class="align-middle">{{ $item->title }}</td>
                        <td class="align-middle">
                            <span class="badge badge-warning">{{ $item->status->title }}</span>
                        </td>
                        <td class="align-middle">
                            @if($item->price)
                            {{ $item->price }} руб.
                            @endif
                        </td>
                        <td class="align-middle text-right">
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('parcel.show', $item) }}" class="btn btn-primary">
                                    <i class="fas fa-eye"></i></a>
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