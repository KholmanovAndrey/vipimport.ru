<?php
$title = 'Личный кабинет';
$breadcrumbs = [
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
        <div class="card text-center py-4 mb-4">
            <div class="card-body">
                <i class="czi-home text-muted h2 font-weight-normal opacity-60 mb-4"></i>
                <h5 class="pb-2">С помощью панели управления вашей учетной записи вы можете:</h5>
                @if(!$profile = \App\Profile::query()->where('user_id', '=', Auth::user()->id)->first())
                    <a href="{{ route('profile.create') }}" class="btn btn-outline-primary btn-sm m-2">Профиль</a>
                @else
                    <a href="{{ route('profile.show', $profile) }}" class="btn btn-outline-primary btn-sm m-2">Профиль</a>
                @endif
                <a href="#" class="btn btn-outline-primary btn-sm m-2">Все пользователи</a>
                <a href="#" class="btn btn-outline-primary btn-sm m-2">Статистика менеджеров</a>
                <a href="#" class="btn btn-outline-primary btn-sm m-2">Статистика клиентов</a>
            </div>
        </div>
    </div>
@endsection