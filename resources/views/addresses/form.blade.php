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

@section('content')
    <div>
        <div class="card py-4 mb-4">
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <form method="POST"
                      action="@if (!$address->id)
                          @if(Auth::user()->hasRole('superAdmin'))
                            {{ route('superAdmin.address.store') }}
                          @elseif(Auth::user()->hasRole('client'))
                            {{ route('address.store') }}
                          @endif
                      @else
                          @if(Auth::user()->hasRole('superAdmin'))
                            {{ route('superAdmin.address.update', $address) }}
                          @elseif(Auth::user()->hasRole('client'))
                            {{ route('address.update', $address) }}
                          @endif
                      @endif">
                    @csrf
                    @if ($address->id) @method('PUT') @endif

                    <div class="form-group row @if(Auth::user()->hasRole('superAdmin'))
                            row
                    @elseif(Auth::user()->hasRole('client'))
                        d-none
                    @endif">
                        <label for="user_id" class="col-md-4 col-form-label text-md-right">{{ __('Клиент') }}
                            <span class="star">*</span>
                        </label>
                        <div class="col-md-6">
                            <select name="user_id"
                                    id="user_id"
                                    class="form-control @error('user_id') is-invalid @enderror"
                                    required>
                                @foreach ($clients as $client)
                                    <option {{ $client->id === $address->user_id ? 'selected="selected"' : '' }} value="{{ $client->id }}">
                                        {{ $client->email }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lastname" class="col-md-4 col-form-label text-md-right">{{ __('Фамилия') }}
                            <span class="star">*</span>
                        </label>
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
                        <label for="firstname" class="col-md-4 col-form-label text-md-right">{{ __('Имя') }}
                            <span class="star">*</span></label>
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
                                   >
                            @error('othername')
                            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="country_id" class="col-md-4 col-form-label text-md-right">{{ __('Страна') }}
                            <span class="star">*</span>
                        </label>
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
                        <label for="postal_code" class="col-md-4 col-form-label text-md-right">
                            {{ __('Почтовый индекс') }}
                            <span class="star">*</span>
                        </label>
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
                        <label for="region" class="col-md-4 col-form-label text-md-right">
                            {{ __('Область/край/республика') }}
                            <span class="star">*</span>
                        </label>
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
                        <label for="city" class="col-md-4 col-form-label text-md-right">
                            {{ __('Город') }}
                            <span class="star">*</span>
                        </label>
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
                        <label for="street" class="col-md-4 col-form-label text-md-right">
                            {{ __('Улица') }}
                            <span class="star">*</span>
                        </label>
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
                        <label for="building" class="col-md-4 col-form-label text-md-right">
                            {{ __('№ здания') }}
                            <span class="star">*</span>
                        </label>
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
                        <label for="phone" class="col-md-4 col-form-label text-md-right">
                            {{ __('Телефон') }}
                            <span class="star">*</span>
                        </label>
                        <div class="col-md-6">
                            <input id="phone"
                                   type="text"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   name="phone"
                                   value="{{ $address->phone ?? old('phone') }}"
                                   required>
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
        </div>
    </div>
@endsection