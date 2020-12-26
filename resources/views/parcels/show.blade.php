<?php
$title = $item->title;
$breadcrumbs = [
    [
        'name' => 'Личный кабинет',
        'route' => route(\Illuminate\Support\Facades\Auth::user()->roles[0]->name . '.index'),
    ],
    [
        'name' => 'Все посылки',
        'route' => route('parcel.index'),
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
    <div class="item col-lg-9">
        <x-user-title/>
        <div class="card py-4 mb-4">
            <div class="card-body">
                <article class="item__article">
                    <header><h1 class="item__title">{{ $item->title }}
                            <span class="badge badge-warning">{{ $item->status->title }}</span>
                        </h1></header>
                    <div class="item__text row">
                        <div class="col-md-6">
                            <div class="item__client">Клиент: {{ $item->client->name }}</div>
                            <div>Дата создания: {{ date('d.m.Y H:i', date_timestamp_get($item->created_at)) }}</div>
                            <div>Дата обновления: {{ date('d.m.Y H:i', date_timestamp_get($item->updated_at)) }}</div>
                            <div class="item__description">{{ $item->description }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="item__title">Данные доставки:</div>
                            <div class="item__fio">ФИО: {{ $item->fio }}</div>
                            <div class="item__address">Адрес: {{ $item->address }}</div>
                            <div class="item__phone">Телефон: {{ $item->phone }}</div>
                        </div>
                    </div>
                    <footer class="item__footer">
                        @auth
                        @can('canEditByStatus', $item)
                            <form method="POST"
                                  action="{{ route('client.parcel-send-to-packaging', $item) }}">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-primary item__link">
                                    {{ __('Отправить на упаковку') }}
                                </button>
                            </form>
                            <a href="@if(Auth::user()->hasRole('superAdmin'))
                                {{ route('superAdmin.parcel.edit', $item) }}
                            @elseif(Auth::user()->hasRole('client'))
                                {{ route('parcel.edit', $item) }}
                            @endif" class="btn btn-primary item__link">Редактировать</a>
                            <form method="POST"
                                  action="{{ route('parcel.destroy', $item) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-primary item__link">
                                    {{ __('Удалить') }}
                                </button>
                            </form>
                        @endcan
                        @endauth
                    </footer>
                </article>

                @if(Auth::user()->hasRole('manager') && $item->manager !== null && $item->status_id != 6)
                <div class="manager">
                    <form method="POST"
                          action="{{ route('manager.parcel.status', $item) }}">
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
                          action="{{ route('manager.parcel.transfer', $item) }}">
                        @csrf
                        @method('PUT')
                        <select name="manager_id"
                                id="manager_id"
                                class="form-control"
                                required>
                            @foreach ($managers as $manager)
                                <option {{ (int)$manager->id === (int)$item->manager_id ? 'selected="selected"' : '' }} value="{{ $manager->id }}">
                                    {{ $manager->profile['lastname'] }} ({{ $manager->name }})
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-danger item__link">
                            {{ __('Передать заказ') }}
                        </button>
                    </form>
                </div>
                @endif

                <h2>Заказы:</h2>
                <section>
                    <div class="row item-font">
                        <div class="col-sm-2">№</div>
                        <div class="col-sm-6">Наименование</div>
                        <div class="col-sm-2">Кол-во</div>
                        @if((int)$item->status_id === 6)<div class="col-sm-2"></div>@endif
                    </div>
                    @foreach($item->orders as $order)
                        <div class="row item-font">
                            <div class="col-sm-2">Z{{ $order->id }}</div>
                            <div class="col-sm-6">{{ $order->title }}</div>
                            <div class="col-sm-2">{{ $order->count }}</div>
                            @if((int)$item->status_id === 6)
                                <div class="col-sm-2">
                                    <form method="POST"
                                          action="{{ route('client.order-delete-parcel-id', $order) }}">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-primary item__link">
                                            {{ __('Удалить') }}
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </section>
                @if((int)$item->status_id === 6)
                    <form method="POST"
                          action="{{ route('client.order-add-parcel-id', $item) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <div class="col">
                                <label for="order_id" class="col-form-label text-md-right">{{ __('Выберете заказы в посылку') }} (только заказы со статусом "На складе")</label>
                                <select name="order_id[]"
                                        id="order_id"
                                        class="form-control @error('order_id') is-invalid @enderror"
                                        multiple
                                        size="10"
                                        required>
                                    @foreach ($orders as $order)
                                        <option {{ $order->id === $item->order_id ? 'selected="selected"' : '' }} value="{{ $order->id }}">
                                            {{ $order->title }} (Статус: {{ $order->status->title }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('order_id')
                                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary item__link">
                            {{ __('Добавить заказы в посылку') }}
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection