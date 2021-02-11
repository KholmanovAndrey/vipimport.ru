<?php
$title = $item->title;
$breadcrumbs = [
    [
        'name' => 'Личный кабинет',
        'route' => route('home'),
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

@section('content')
    <div class="item">
        <div class="card py-4 mb-4">
            <div class="card-body">
                <article class="item__article">
                    <header>
                        <h1 class="item__title">{{ $item->title }}
                            <span class="badge badge-warning">{{ $item->status->title }}</span>
                            @if($item->isPaid)<span class="badge badge-danger">Оплачено</span>@endif
                        </h1>
                    </header>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="item__text row">
                        <div class="col-md-6">
                            <div class="item__client">Клиент: {{ $item->client->name }}</div>
                            <div>Дата создания: {{ date('d.m.Y H:i', date_timestamp_get($item->created_at)) }}</div>
                            <div>Дата обновления: {{ date('d.m.Y H:i', date_timestamp_get($item->updated_at)) }}</div>
                            <div>Трекер: {{ $item->tracker }}</div>
                            @if($item->price)
                                <div>Цена доставки: {{ $item->price }} руб.</div>
                            @endif
                            @if($item->receipt)
                                <a target="_blank" href="{{ asset('storage/files/receipts/' . $item->receipt) }}" class="btn btn-danger">Счет на оплату</a>
                            @endif
                            <div class="item__description">{{ $item->description }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="item__title">Данные доставки:</div>
                            <div class="item__fio">ФИО: {{ $item->fio }}</div>
                            <div class="item__address">Адрес: {{ $item->address }}</div>
                            <div class="item__phone">Телефон: {{ $item->phone }}</div>
                        </div>
                    </div>
                    <footer class="mt-2 d-flex flex-wrap">
                        @auth
                        @can('canEditByStatus', $item)
                            <form method="POST"
                                  action="{{ route('parcel.parcel-send-to-packaging', $item) }}">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-primary mb-2 mr-2" title="Отправить на упаковку">
                                    <i class="fas fa-box-open"></i>
                                    <span class="ml-2 d-lg-inline">{{ __('Отправить на упаковку') }}</span>
                                </button>
                            </form>
                            <a href="{{ route('parcel.edit', $item) }}" class="btn btn-primary  mb-2 mr-2" title="Редактировать">
                                <i class="far fa-edit"></i>
                                <span class="ml-2 d-none d-lg-inline">{{ __('Редактировать') }}</span>
                            </a>
                            <form method="POST"
                                  action="{{ route('parcel.destroy', $item) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-primary  mb-2" title="Удалить">
                                    <i class="far fa-trash-alt"></i>
                                    <span class="ml-2 d-none d-lg-inline">{{ __('Удалить') }}</span>
                                </button>
                            </form>
                        @endcan
                        @endauth
                    </footer>
                </article>

                @if(Auth::user()->hasRole('manager') && $item->manager !== null && $item->status_id != 6)
                    <div class="d-flex flex-wrap">
                        @if((int)$item->status_id > 8)
                            <form method="POST" class="col-12 col-lg-6 d-flex mb-4"
                                  action="{{ route('parcel.status', $item) }}">
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
                                <button type="submit" class="btn btn-danger col-6 col-lg-4 ml-2">
                                    {{ __('Изменить статус') }}
                                </button>
                            </form>
                        @endif

                        <form method="POST" class="col-12 col-lg-6 d-flex mb-4"
                              action="{{ route('parcel.transfer', $item) }}">
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
                            <button type="submit" class="btn btn-danger col-6 col-lg-4 ml-2">
                                {{ __('Передать заказ') }}
                            </button>
                        </form>

                        <form method="POST" class="col-12 col-lg-6 d-flex mb-4"
                              action="{{ route('parcel.tracker', $item) }}">
                            @csrf
                            @method('PUT')
                            <input name="tracker"
                                   id="tracker"
                                   class="form-control"
                                   value="{{ $item->tracker }}"
                                   required />
                            <button type="submit" class="btn btn-danger col-6 col-lg-4 ml-2">
                                {{ __('Назначить трекер') }}
                            </button>
                        </form>
                    </div>
                    @if (!$item->isPaid)
                    <div>
                        <h3>Расчетные данные:</h3>
                        <div class="d-flex flex-wrap">
                            <form method="POST" enctype="multipart/form-data" class="col-12 col-lg-9 d-flex mb-4"
                                  action="{{ route('parcel.price', $item) }}">
                                @csrf
                                @method('PUT')
                                <input name="price"
                                       id="price"
                                       class="form-control mr-2"
                                       value="{{ $item->price }}"
                                />
                                <input name="receipt"
                                       id="receipt"
                                       type="file"
                                       accept=".pdf"
                                       class="form-control"
                                />
                                <button type="submit" class="btn btn-danger col-6 col-lg-4 ml-2">
                                    {{ __('Назначить цену доставки') }}
                                </button>
                            </form>
                            <form method="POST" class="col-12 col-lg-3 d-flex mb-4"
                                  action="{{ route('parcel.is-paid', $item) }}">
                                @csrf
                                @method('PUT')
                                <input name="isPaid"
                                       id="isPaid"
                                       type="hidden"
                                       class="form-control"
                                       value="true"
                                />
                                <button type="button" class="btn btn-danger col-6 col-lg-12" data-toggle="modal" data-target="#is-paid">
                                    {{ __('Оплачено') }}
                                </button>

                                <?php $name = 'is-paid' ?>
                                <x-confirm :name="$name"/>
                            </form>
                        </div>
                    </div>
                    @endif
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
                                          action="{{ route('parcel.order-delete-parcel-id', $order) }}">
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
                          action="{{ route('parcel.order-add-parcel-id', $item) }}">
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
                            <i class="fas fa-plus mr-2"></i>{{ __('Добавить заказы в посылку') }}
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection