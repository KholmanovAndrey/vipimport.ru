<?php
$title = 'Мои посылки';
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
        <h2>Посылки:</h2>
        <section>
            <div class="row item-font">
                <div class="col-sm-2">№</div>
                <div class="col-sm-4">Наименование</div>
                <div class="col-sm-2">Статус</div>
                <div class="col-sm-2">Кол-во</div>
                <div class="col-sm-2"></div>
            </div>
            @foreach($parcels as $parcel)
                <div class="row item-font">
                    <div class="col-sm-2">P{{ $parcel->id }}</div>
                    <div class="col-sm-4">
                        <a href="{{ route('manager.parcel-show', $parcel) }}">{{ $parcel->title }}</a>
                    </div>
                    <div class="col-sm-2">
                        <span class="badge badge-warning">{{ $parcel->status->title }}</span>
                    </div>
                    <div class="col-sm-2">{{ $parcel->count }}</div>
                    <div class="col-sm-2">
                        <a class="btn btn-danger" href="{{ route('manager.parcel-show', $parcel) }}">{{ __('Перейти') }}</a>
                    </div>
                </div>
            @endforeach
        </section>
    </div>
@endsection