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
        <div class="items__btn">
            <a class="btn btn-danger" href="{{ route('client.support-create') }}">{{ __('Написать в поддержку') }}</a>
        </div>
        <section>
            <div class="row item-font">
                <div class="col-sm-2">№</div>
                <div class="col-sm-4">Наименование</div>
                <div class="col-sm-2">Тема</div>
                <div class="col-sm-2"></div>
            </div>
            @foreach($supports as $item)
                <div class="row item-font">
                    <div class="col-sm-2">SUP{{ $item->id }}</div>
                    <div class="col-sm-4">{{ $item->title }}</div>
                    <div class="col-sm-2">
                        @if($item->order)
                            {{ $item->order->title }}
                        @endif
                        @if($item->parcel)
                            {{ $item->parcel->title }}
                        @endif
                        @if(!$item->parcel && !$item->order)
                            {{ __('Общий') }}
                        @endif
                    </div>
                    <div class="col-sm-2">
                        <div class="col-sm-2">
                            <a class="btn btn-danger" href="{{ route('client.support-view', $item) }}">{{ __('Перейти') }}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </section>
    </div>
@endsection