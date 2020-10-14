<?php
$title = 'Поддержка';
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
        <div class="card py-4 mb-4">
            <div class="card-body">
                @if(Auth::user()->hasRole('client'))
                    <div class="items__btn">
                        <a class="btn btn-primary" href="{{ route('support.create') }}">{{ __('Написать в поддержку') }}</a>
                    </div>
                @endif
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
                                    <div class="row">
                                        <a class="btn btn-primary mr-2" href="{{ route('support.show', $item) }}">{{ __('Перейти') }}</a>
                                        @if(Auth::user()->hasRole('manager') && !$item->manager_id)
                                            <form method="POST"
                                                  action="{{ route('manager.support-accept', $item) }}">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-primary item__link">
                                                    {{ __('Принять') }}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </section>
            </div>
        </div>
    </div>
@endsection