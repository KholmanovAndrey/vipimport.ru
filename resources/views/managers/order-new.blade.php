@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('sidebar')
    @parent

    <div class="sidebar col-lg-3">
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
                    <div class="col-sm-4">{{ $order->title }}</div>
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