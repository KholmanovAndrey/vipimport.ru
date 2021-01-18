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

@section('content')
    <div class="items">
        <div class="card py-4 mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="background-color-default">
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

                @if(Auth::user()->hasRole('manager') && $item->manager !== null)
                    <form method="POST"
                          action="{{ route('manager.order.status', $item) }}">
                        @csrf
                        @method('PUT')
                        <select name="status_id"
                                id="status_id"
                                class="form-control"
                                required>
                            @foreach ($statuses as $status)
                                <option {{ (int)$status->id === (int)$item->status_id ? 'selected="selected"' : '' }} value="{{ $status->id }}">
                                    {{ $status->title }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-danger item__link">
                            {{ __('Изменить статус') }}
                        </button>
                    </form>

                    <form method="POST"
                          action="{{ route('manager.order.transfer', $item) }}">
                        @csrf
                        @method('PUT')
                        <select name="manager_id"
                                id="manager_id"
                                class="form-control"
                                required>
                            @foreach ($managers as $manager)
                                <option {{ (int)$manager->id === (int)$item->manager_id ? 'selected="selected"' : '' }} value="{{ $manager->id }}">
                                    @if($manager->profile)
                                        {{ $manager->profile->lastname }}
                                    @endif
                                    ({{ $manager->name }})
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-danger item__link">
                            {{ __('Передать заказ') }}
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection