@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('sidebar')
    @parent

    <div class="sidebar col">
        <x-office/>
    </div>
@endsection

@section('content')
    <div class="item col-lg-9">
        <article class="item__article">
            <header><h1 class="item__title">{{ $parcel->title }}
                    <span class="badge badge-warning">{{ $parcel->status->title }}</span>
                </h1></header>
            <div class="item__text row">
                <div class="col-md-6">
                    <div class="item__client">Клиент: {{ $parcel->client->name }}</div>
                    <div>Дата создания: {{ date('d.m.Y H:i', date_timestamp_get($parcel->created_at)) }}</div>
                    <div>Дата обновления: {{ date('d.m.Y H:i', date_timestamp_get($parcel->updated_at)) }}</div>
                    <div class="item__description">{{ $parcel->description }}</div>
                </div>
                <div class="col-md-6">
                    <div class="item__title">Данные доставки:</div>
                    <div class="item__fio">ФИО: {{ $parcel->fio }}</div>
                    <div class="item__address">Адрес: {{ $parcel->address }}</div>
                    <div class="item__phone">Телефон: {{ $parcel->phone }}</div>
                </div>
            </div>
            <footer class="item__footer">
                <form method="POST"
                      action="{{ route('manager.parcel-status', $parcel) }}">
                    @csrf
                    @method('PUT')
                    <select name="status_id"
                            id="status_id"
                            class="form-control"
                            required>
                        @foreach ($statuses as $status)
                            <option {{ (int)$status->id === (int)$parcel->status_id ? 'selected="selected"' : '' }} value="{{ $status->id }}">
                                {{ $status->title }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-danger item__link">
                        {{ __('Изменить статус') }}
                    </button>
                </form>

                <form method="POST"
                      action="{{ route('manager.parcel-transfer', $parcel) }}">
                    @csrf
                    @method('PUT')
                    <select name="manager_id"
                            id="manager_id"
                            class="form-control"
                            required>
                        @foreach ($managers as $manager)
                            <option {{ (int)$manager->id === (int)$parcel->manager_id ? 'selected="selected"' : '' }} value="{{ $manager->id }}">
                                {{ $manager->profile['lastname'] }} ({{ $manager->name }})
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-danger item__link">
                        {{ __('Передать заказ') }}
                    </button>
                </form>
            </footer>
        </article>

        <h2>Заказы в посылке</h2>
        <section>
            <div class="row item-font">
                <div class="col-sm-2">№</div>
                <div class="col-sm-6">Наименование</div>
                <div class="col-sm-2">Кол-во</div>
            </div>
            @foreach($parcel->orders as $order)
                <div class="row item-font">
                    <div class="col-sm-2">Z{{ $order->id }}</div>
                    <div class="col-sm-6">{{ $order->title }}</div>
                    <div class="col-sm-2">{{ $order->count }}</div>
                </div>
            @endforeach
        </section>
    </div>
@endsection