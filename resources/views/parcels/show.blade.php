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
        <div class="d-flex justify-content-between align-items-center pt-lg-2 pb-4 pb-lg-5 mb-lg-3">
            <h6 class="font-size-base text-light mb-0">Привет, {{ Auth::user()->name }}</h6>
            <a class="btn btn-primary btn-sm d-none d-lg-inline-block" href="{{ route('logout') }}"
               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="czi-sign-out mr-2"></i>Выйти</a>
        </div>
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
                            <button type="submit" class="btn btn-danger item__link">
                                {{ __('Отправить на упаковку') }}
                            </button>
                        </form>
                        <a href="{{ route('parcel.edit', $item) }}" class="btn btn-danger item__link">Редактировать</a>
                        <form method="POST"
                              action="{{ route('parcel.destroy', $item) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger item__link">
                                {{ __('Удалить') }}
                            </button>
                        </form>
                    @endcan
                @endauth
            </footer>
        </article>

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
                                <button type="submit" class="btn btn-danger item__link">
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
                    <label for="order_id" class="col-form-label text-md-right">{{ __('Выберете заказы в посылку') }} <span class="star">*</span></label>
                    <select name="order_id[]"
                            id="order_id"
                            class="form-control @error('order_id') is-invalid @enderror"
                            multiple
                            size="10"
                            required>
                        @foreach ($orders as $order)
                            <option {{ $order->id === $item->order_id ? 'selected="selected"' : '' }} value="{{ $order->id }}">
                                {{ $order->title }}
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
            <button type="submit" class="btn btn-danger item__link">
                {{ __('Добавить заказы в посылку') }}
            </button>
        </form>
        @endif
    </div>
@endsection