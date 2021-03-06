<?php
$title = 'Все заказы';
$breadcrumbs = [
    [
        'name' => 'Личный кабинет',
        'route' => route('home'),
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
                                @if($item->isPaid)<span class="badge badge-danger">Оплачено</span>@endif
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
                        @if($item->receipt)
                            <tr>
                                <th></th>
                                <td><a target="_blank" href="{{ asset('storage/files/receipts/' . $item->receipt) }}" class="btn btn-danger">Счет на оплату</a></td>
                            </tr>
                        @endif
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
                    <div class="d-flex flex-wrap">
                        @if((int)$item->status_id > 3)
                            <form method="POST" class="col-12 col-lg-6 d-flex mb-4"
                                  action="{{ route('order.status', $item) }}">
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
                              action="{{ route('order.transfer', $item) }}">
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
                            <button type="submit" class="btn btn-danger col-6 col-lg-4 ml-2">
                                {{ __('Передать заказ') }}
                            </button>
                        </form>
                    </div>
                        @if (!$item->isPaid)
                            <div>
                                <h3>Расчетные данные:</h3>
                                <div class="d-flex flex-wrap">
                                    <form method="POST" enctype="multipart/form-data" class="col-12 col-lg-9 d-flex mb-4"
                                          action="{{ route('order.price', $item) }}">
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
                                            {{ __('Назначить цену заказа') }}
                                        </button>
                                    </form>
                                    <form method="POST" class="col-12 col-lg-3 d-flex mb-4"
                                          action="{{ route('order.is-paid', $item) }}">
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
            </div>
        </div>
    </div>
@endsection