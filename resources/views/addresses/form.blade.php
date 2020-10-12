<?php
$title = 'Создание/Редактирование адресов';
$breadcrumbs = [
    [
        'name' => 'Личный кабинет',
        'route' => route(\Illuminate\Support\Facades\Auth::user()->roles[0]->name . '.index'),
    ],
    [
        'name' => 'Все адреса',
        'route' => route('address.index'),
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
              action="@if (!$address->id){{ route('address.store') }}@else{{ route('address.update', $address) }}@endif">
            @csrf
            @if ($address->id) @method('PUT') @endif

            <div class="form-group row">
                <label for="lastname" class="col-md-4 col-form-label text-md-right">{{ __('Фамилия') }}</label>
                <div class="col-md-6">
                    <input id="lastname"
                           type="text"
                           class="form-control @error('lastname') is-invalid @enderror"
                           name="lastname"
                           value="{{ $address->lastname ?? old('lastname') }}"
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
                           value="{{ $address->firstname ?? old('firstname') }}"
                           required>
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
                           value="{{ $address->othername ?? old('othername') }}"
                           required>
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
                            <option {{ $country->id === $address->country_id ? 'selected="selected"' : '' }} value="{{ $country->id }}">
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
                <label for="postal_code" class="col-md-4 col-form-label text-md-right">{{ __('Почтовый индекс') }}</label>
                <div class="col-md-6">
                    <input id="postal_code"
                           type="text"
                           class="form-control @error('postal_code') is-invalid @enderror"
                           name="postal_code"
                           value="{{ $address->postal_code ?? old('postal_code') }}"
                           required>
                    @error('postal_code')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="region" class="col-md-4 col-form-label text-md-right">{{ __('Область/край/республика') }}</label>
                <div class="col-md-6">
                    <input id="region"
                           type="text"
                           class="form-control @error('region') is-invalid @enderror"
                           name="region"
                           value="{{ $address->region ?? old('region') }}"
                           required>
                    @error('region')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="city" class="col-md-4 col-form-label text-md-right">{{ __('Город') }}</label>
                <div class="col-md-6">
                    <input id="city"
                           type="text"
                           class="form-control @error('city') is-invalid @enderror"
                           name="city"
                           value="{{ $address->city ?? old('city') }}"
                           required>
                    @error('city')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="street" class="col-md-4 col-form-label text-md-right">{{ __('Улица') }}</label>
                <div class="col-md-6">
                    <input id="street"
                           type="text"
                           class="form-control @error('street') is-invalid @enderror"
                           name="street"
                           value="{{ $address->street ?? old('street') }}"
                           required>
                    @error('street')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="building" class="col-md-4 col-form-label text-md-right">{{ __('№ здания') }}</label>
                <div class="col-md-6">
                    <input id="building"
                           type="text"
                           class="form-control @error('building') is-invalid @enderror"
                           name="building"
                           value="{{ $address->building ?? old('building') }}"
                           required>
                    @error('building')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="body" class="col-md-4 col-form-label text-md-right">{{ __('Корпус') }}</label>
                <div class="col-md-6">
                    <input id="body"
                           type="text"
                           class="form-control @error('body') is-invalid @enderror"
                           name="body"
                           value="{{ $address->body ?? old('body') }}"
                    >
                    @error('body')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="apartment" class="col-md-4 col-form-label text-md-right">{{ __('Квартира') }}</label>
                <div class="col-md-6">
                    <input id="apartment"
                           type="text"
                           class="form-control @error('apartment') is-invalid @enderror"
                           name="apartment"
                           value="{{ $address->apartment ?? old('apartment') }}"
                    >
                    @error('apartment')
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
                           value="{{ $address->phone ?? old('phone') }}"
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