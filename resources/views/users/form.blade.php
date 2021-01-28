<?php
$title = 'Создание/Редактирование посылок';
$breadcrumbs = [
    [
        'name' => 'Личный кабинет',
        'route' => route('home'),
    ],
    [
        'name' => 'Пользователи',
        'route' => route('user.index'),
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

@section('content')
    <div>
        <div class="card py-4 mb-4">
            <div class="card-body">
                <form method="POST"
                      action="@if (!$user->id){{ route('user.store') }}@else{{ route('user.update', $user) }}@endif">
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

                    @if (!$user->id)
                    <div class="form-group row">
                        <div class="col">
                            <label for="password" class="col-form-label text-md-right">{{ __('Пароль') }} <span class="star">*</span></label>
                            <input id="password"
                                   type="password"
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
                            <label for="password_confirmation" class="col-form-label text-md-right">{{ __('Повторите пароль') }} <span class="star">*</span></label>
                            <input id="password_confirmation"
                                   type="password"
                                   class="form-control @error('password_confirmation') is-invalid @enderror"
                                   name="password_confirmation"
                                   value=""
                                   placeholder="Повторите пароль"
                                   required>
                            @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    @endif

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