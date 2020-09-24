@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('sidebar')
    @parent

    <div class="sidebar col">
        <x-office/>
    </div>
@endsection

@section('content')
    <div class="items col-lg-9">
        <h2>Заказы:</h2>
        <section>
            <div class="row item-font">
                <div class="col-sm-2">№</div>
                <div class="col-sm-4">Наименование</div>
                <div class="col-sm-2">Статус</div>
                <div class="col-sm-2">Кол-во</div>
                <div class="col-sm-2"></div>
            </div>
            @foreach($orders as $order)
                <div class="row item-font">
                    <div class="col-sm-2">Z{{ $order->id }}</div>
                    <div class="col-sm-4">
                        <a href="{{ route('manager.order-show', $order) }}">{{ $order->title }}</a>
                    </div>
                    <div class="col-sm-2">
                        <span class="badge badge-warning">{{ $order->status->title }}</span>
                    </div>
                    <div class="col-sm-2">{{ $order->count }}</div>
                    <div class="col-sm-2">
                        <a class="btn btn-danger" href="{{ route('manager.order-show', $order) }}">{{ __('Перейти') }}</a>
                    </div>
                </div>
            @endforeach
        </section>
    </div>
@endsection