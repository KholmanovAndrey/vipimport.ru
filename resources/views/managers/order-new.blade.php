<?php
$title = 'Новые посылки';
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
        <h2>Заказы:</h2>
        <section>
            <div class="row item-font">
                <div class="col-sm-1">№</div>
                <div class="col-sm-3">Наименование</div>
                <div class="col-sm-2">Клиент</div>
                <div class="col-sm-2">Статус</div>
                <div class="col-sm-2">Кол-во</div>
                <div class="col-sm-2"></div>
            </div>
            @foreach($orders as $order)
                <div class="row item-font">
                    <div class="col-sm-1">Z{{ $order->id }}</div>
                    <div class="col-sm-3">{{ $order->title }}</div>
                    <div class="col-sm-2">{{ $order->user->name }}</div>
                    <div class="col-sm-2">
                        <span class="badge badge-warning">{{ $order->status->title }}</span>
                    </div>
                    <div class="col-sm-2">{{ $order->count }}</div>
                    <div class="col-sm-2">
                        <form method="POST"
                              action="{{ route('manager.order-accept', $order) }}">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-danger item__link">
                                {{ __('Принять') }}
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </section>
    </div>
@endsection