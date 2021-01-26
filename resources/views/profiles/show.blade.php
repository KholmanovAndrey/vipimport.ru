<?php
$title = 'Личные данные';
$breadcrumbs = [
    [
        'name' => 'Личный кабинет',
        'route' => route('home'),
    ],
    [
        'name' => $title,
        'route' => '',
    ]
];
?>
@extends('layouts.app')

@section('title', $title )

@section('dashboard')
    <x-dashboard :title="$title" :breadcrumbs="$breadcrumbs"/>
@endsection

@section('content')
    <div class="item">
        <div class="card py-4 mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-3">ФИО</div>
                    <div class="col-9">{{ $item->lastname }} {{ $item->firstname }} {{ $item->othername }}</div>
                </div>
                <div class="row">
                    <div class="col-3">Страна</div>
                    <div class="col-9">{{ $item->country->title }}</div>
                </div>
                <div class="row">
                    <div class="col-3">E-mail</div>
                    <div class="col-9">{{ $item->email }}</div>
                </div>
                <div class="row">
                    <div class="col-3">Телефон</div>
                    <div class="col-9">{{ $item->phone }}</div>
                </div>
                <div class="row px-4 mt-4 justify-content-end">
                    <a href="{{ route('profile.edit', $item) }}" class="btn btn-primary mr-2">{{ __('Редактировать') }}</a>
                    @if (Route::has('password.request'))
                        <a class="btn btn-primary" href="{{ route('password.request') }}">
                            {{ __('Сменить пароль') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection