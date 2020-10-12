<?php
$title = 'Создание/Редактирование профиля';
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
    <div class="col-lg-9">
        <div class="d-flex justify-content-between align-items-center pt-lg-2 pb-4 pb-lg-5 mb-lg-3">
            <h6 class="font-size-base text-light mb-0">Привет, {{ Auth::user()->name }}</h6>
            <a class="btn btn-primary btn-sm d-none d-lg-inline-block" href="{{ route('logout') }}"
               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="czi-sign-out mr-2"></i>Выйти</a>
        </div>
        <form method="POST"
              action="@if (!$profile->id){{ route('profile.store') }}@else{{ route('profile.update', $profile) }}@endif">
            @csrf
            @if ($profile->id) @method('PUT') @endif

            <div class="form-group row">
                <label for="lastname" class="col-md-4 col-form-label text-md-right">{{ __('Фамилия') }}</label>
                <div class="col-md-6">
                    <input id="lastname"
                           type="text"
                           class="form-control @error('lastname') is-invalid @enderror"
                           name="lastname"
                           value="{{ $profile->lastname ?? old('lastname') }}"
                           required autofocus>
                    @error('lastname')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="firstname" class="col-md-4 col-form-label text-md-right">{{ __('Имя') }}</label>
                <div class="col-md-6">
                    <input id="firstname"
                           type="text"
                           class="form-control @error('firstname') is-invalid @enderror"
                           name="firstname"
                           value="{{ $profile->firstname ?? old('firstname') }}"
                           required autofocus>
                    @error('firstname')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="othername" class="col-md-4 col-form-label text-md-right">{{ __('Отчество') }}</label>
                <div class="col-md-6">
                    <input id="othername"
                           type="text"
                           class="form-control @error('othername') is-invalid @enderror"
                           name="othername"
                           value="{{ $profile->othername ?? old('othername') }}"
                           required autofocus>
                    @error('othername')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="country_id" class="col-md-4 col-form-label text-md-right">{{ __('Страна') }}</label>
                <div class="col-md-6">
                    <select name="country_id"
                            id="country_id"
                            class="form-control @error('country_id') is-invalid @enderror"
                            required>
                        @foreach ($countries as $country)
                            <option {{ $country->id === $profile->country_id ? 'selected="selected"' : '' }} value="{{ $country->id }}">
                                {{ $country->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('country_id')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-mail') }}</label>
                <div class="col-md-6">
                    <input id="email"
                           type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           name="email"
                           value="{{ $profile->email ?? (old('email') ?? \Illuminate\Support\Facades\Auth::user()->email) }}"
                           required autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Телефон') }}</label>
                <div class="col-md-6">
                    <input id="phone"
                           type="text"
                           class="form-control @error('phone') is-invalid @enderror"
                           name="phone"
                           value="{{ $profile->phone ?? old('phone') }}"
                           required autofocus>
                    @error('phone')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Сохранить') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection