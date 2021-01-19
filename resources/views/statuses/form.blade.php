<?php
$title = 'Создание/Редактирование посылок';
$breadcrumbs = [
    [
        'name' => 'Личный кабинет',
        'route' => route('home'),
    ],
    [
        'name' => 'Все статусы',
        'route' => route('status.index'),
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
                      action="@if (!$item->id)
                          {{ route('status.store') }}
                      @else
                          {{ route('status.update', $item) }}
                      @endif">
                    @csrf
                    @if ($item->id) @method('PUT') @endif

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="title" class="col-form-label text-md-right">{{ __('Наименование') }} <span class="star">*</span></label>
                            <input id="title"
                                   type="text"
                                   class="form-control @error('title') is-invalid @enderror"
                                   name="title"
                                   value="{{ $item->title ?? old('title') }}"
                                   placeholder="Наименование посылки"
                                   required autofocus>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="table_name" class="col-form-label text-md-right">{{ __('Таблица') }} <span class="star">*</span></label>
                            <select name="table_name"
                                    id="table_name"
                                    class="form-control @error('table_name') is-invalid @enderror"
                                    required>
                                <option value="orders">Заказы</option>
                                <option value="parcels">Посылки</option>
                            </select>
                            @error('table_name')
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