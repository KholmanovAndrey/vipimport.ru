<?php
$title = 'Создание/Редактирование посылок';
$breadcrumbs = [
    [
        'name' => 'Личный кабинет',
        'route' => route(\Illuminate\Support\Facades\Auth::user()->roles[0]->name . '.index'),
    ],
    [
        'name' => 'Пользователи',
        'route' => route('superAdmin.user.index'),
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
    <div class="col-lg-9">
        <x-user-title/>
        <div class="card py-4 mb-4">
            <div class="card-body">
                <form method="POST"
                      action="@if (!$user->id){{ route('superAdmin.user.store') }}@else{{ route('superAdmin.user.update', $user) }}@endif">
                    @csrf
                    @if ($user->id) @method('PUT') @endif

                    <div class="form-group row">
                        <div class="col">
                            <label for="name" class="col-form-label text-md-right">{{ __('Логин') }} <span class="star">*</span></label>
                            <input id="name"
                                   type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   name="name"
                                   value="{{ $user->name ?? old('name') }}"
                                   placeholder="Логин"
                                   required autofocus>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col">
                            <label for="email" class="col-form-label text-md-right">{{ __('E-mail') }} <span class="star">*</span></label>
                            <input id="email"
                                   type="text"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email"
                                   value="{{ $user->email ?? old('email') }}"
                                   placeholder="E-mail"
                                   required>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col">
                            <label for="password" class="col-form-label text-md-right">{{ __('Пароль') }} <span class="star">*</span></label>
                            <input id="password"
                                   type="text"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password"
                                   value=""
                                   placeholder="Пароль"
                                   required>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col">
                            <label for="confirm" class="col-form-label text-md-right">{{ __('Повторите пароль') }} <span class="star">*</span></label>
                            <input id="confirm"
                                   type="text"
                                   class="form-control @error('confirm') is-invalid @enderror"
                                   name="confirm"
                                   value=""
                                   placeholder="Повторите пароль"
                                   required>
                            @error('confirm')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Сохранить') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection