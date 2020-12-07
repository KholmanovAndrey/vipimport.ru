<?php
$title = 'Все заказы';
$breadcrumbs = [
    [
        'name' => 'Личный кабинет',
        'route' => route(\Illuminate\Support\Facades\Auth::user()->roles[0]->name . '.index'),
    ],
    [
        'name' => 'Все заказы',
        'route' => route('order.index'),
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
                            <th class="th-dark">Наименование:</th>
                            <td>{{ $item->title }}</td>
                        </tr>
                        <tr>
                            <th class="th-dark">Заказчик:</th>
                            <td>{{ $item->user->name }} ({{ $item->user->email }})</td>
                        </tr>
                        <tr>
                            <th class="th-dark">Манеджер:</th>
                            <td>{{ $item->manager->name ?? 'нет менеджера' }}</td>
                        </tr>
                        <tr>
                            <th>Статус:</th>
                            <td>
                                <span class="badge badge-warning">{{ $item->status->title }}</span>
                                @if($item->isDeleted)
                                    <span class="badge badge-danger">На удалении</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Количество:</th>
                            <td>{{ $item->count }}</td>
                        </tr>
                        <tr>
                            <th>Цена:</th>
                            <td>{{ $item->price ?? 'не указана' }}</td>
                        </tr>
                        <tr>
                            <th>Цвет:</th>
                            <td>{{ $item->color ?? 'не указан' }}</td>
                        </tr>
                        <tr>
                            <th>Размер:</th>
                            <td>{{ $item->size ?? 'не указан' }}</td>
                        </tr>
                        <tr>
                            <th>Описание:</th>
                            <td>{{ $item->description }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection