<?php
$title = 'Создание/Редактирование заказов';
$breadcrumbs = [
    [
        'name' => 'Личный кабинет',
        'route' => route(\Illuminate\Support\Facades\Auth::user()->roles[0]->name . '.index'),
    ],
    [
        'name' => 'Все адреса',
        'route' => route('order.index'),
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

@section('scripts')
    <script src="{{ asset('js/order.link.js') }}" defer></script>
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
                      action="@if (!$order->id)
                          @if(Auth::user()->hasRole('superAdmin'))
                            {{ route('superAdmin.order.store') }}
                          @elseif(Auth::user()->hasRole('client'))
                            {{ route('order.store') }}
                          @endif
                      @else
                          @if(Auth::user()->hasRole('superAdmin'))
                            {{ route('superAdmin.order.update', $order) }}
                          @elseif(Auth::user()->hasRole('client'))
                            {{ route('order.update', $order) }}
                          @endif
                      @endif">
                    @csrf
                    @if ($order->id) @method('PUT') @endif

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
                                    <option {{ $client->id === $order->user_id ? 'selected="selected"' : '' }} value="{{ $client->id }}">
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

                    <div class="div-order">
                        <div class="form-group row">
                            <div class="col">
                                <label for="title" class="col-form-label text-md-right">{{ __('Наименование заказа') }} <span class="star">*</span></label>
                                <input id="title"
                                       type="text"
                                       class="form-control @error('title') is-invalid @enderror"
                                       name="title"
                                       placeholder="Наименование заказа"
                                       minlength="3"
                                       maxlength="50"
                                       value="{{ $order->title ?? old('title') }}"
                                       required autofocus>
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label><input type="checkbox" class="btn-link-visible" /> добавить ссылку</label>
                            </div>
                        </div>

                        <div class="form-group row div-link-visible">
                            <div class="col">
                                <label for="link" class="col-form-label text-md-right">{{ __('Ссылка') }}</label>
                                <input id="link"
                                       type="url"
                                       class="form-control @error('link') is-invalid @enderror"
                                       name="link"
                                       placeholder="http://"
                                       value="{{ $order->link ?? old('link') }}">
                                @error('link')
                                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3">
                                <label for="count" class="col-form-label text-md-right">{{ __('Количество') }} <span class="star">*</span></label>
                                <input id="count"
                                       type="number"
                                       class="form-control @error('count') is-invalid @enderror"
                                       name="count"
                                       value="{{ $order->count ?? (old('count') ?? 1) }}"
                                       required>
                                @error('count')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="price" class="col-form-label text-md-right">{{ __('Цена') }}</label>
                                <input id="price"
                                       type="text"
                                       class="form-control @error('price') is-invalid @enderror"
                                       name="price"
                                       placeholder="Цена"
                                       value="{{ $order->price ?? old('price') }}">
                                @error('price')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="color" class="col-form-label text-md-right">{{ __('Цвет') }}</label>
                                <input id="color"
                                       type="text"
                                       class="form-control @error('color') is-invalid @enderror"
                                       name="color"
                                       placeholder="Цвет"
                                       value="{{ $order->color ?? old('color') }}">
                                @error('color')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="size" class="col-form-label text-md-right">{{ __('Размер') }}</label>
                                <input id="size"
                                       type="text"
                                       class="form-control @error('size') is-invalid @enderror"
                                       name="size"
                                       placeholder="Размер"
                                       value="{{ $order->size ?? old('size') }}">
                                @error('size')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <label for="description" class="col-form-label text-md-right">{{ __('Описание') }} <span class="star">*</span></label>
                                <textarea name="description"
                                          id="description"
                                          class="form-control @error('description') is-invalid @enderror"
                                          placeholder="Описание заказа"
                                          required
                                          minlength="3"
                                          maxlength="250"
                                          cols="20" rows="5">{!! $order->description ?? old('description') !!}</textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
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