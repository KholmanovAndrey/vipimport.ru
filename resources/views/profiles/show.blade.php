<?php
$title = 'Личные данные';
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

@section('title', $title )

@section('dashboard')
    <x-dashboard :title="$title" :breadcrumbs="$breadcrumbs"/>
@endsection

@section('sidebar')
    @parent

    <div class="sidebar col">
        <x-office/>
    </div>
@endsection

@section('content')
    <div class="item col-lg-9">
        {{ $item->lastname }}
        {{ $item->firstname }}
        {{ $item->othername }}
        <a href="{{ route('profile.edit', $item) }}" class="btn btn-danger">{{ __('Редактировать') }}</a>
        <a href="#" class="btn btn-danger">{{ __('Сменить пароль') }}</a>
    </div>
@endsection