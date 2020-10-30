
<?php
$title = 'Просмотр клиента';
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
                <h1>Клиент {{ $client->name }}</h1>
                <p>ФИО: {{ $client->profile->lastname }} {{ $client->profile->firstname }} {{ $client->profile->othername }}</p>
                <p>Телефон: {{ $client->profile->phone }}</p>
                <p>E-mail: {{ $client->profile->email }}</p>
            </div>
        </div>
    </div>
@endsection