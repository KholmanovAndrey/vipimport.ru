<?php
$title = 'Создание/Редактирование категории';
$breadcrumbs = [
    [
        'name' => 'Мои аккаунт',
        'route' => route(\Illuminate\Support\Facades\Auth::user()->roles[0]->name . '.index'),
    ],
    [
        'name' => 'Все категории',
        'route' => route('category.index'),
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
                      action="@if (!$category->id){{ route('category.store') }}@else{{ route('category.update', $category) }}@endif">
                    @csrf
                    @if ($category->id) @method('PUT') @endif

                    <div class="form-group row">
                        <label for="title" class="col-12 col-form-label">{{ __('Наименование') }}</label>
                        <div class="col-12">
                            <input id="title"
                                   type="text"
                                   class="form-control @error('title') is-invalid @enderror"
                                   name="title"
                                   value="{{ $category->title ?? old('title') }}"
                                   required autofocus>
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-12 col-form-label">{{ __('Наименование на английском') }}</label>
                        <div class="col-12">
                            <input id="name"
                                   type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   name="name"
                                   value="{{ $category->name ?? old('name') }}"
                                   required>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="description" class="col-12 col-form-label">{{ __('Описание') }}</label>
                        <div class="col-12">
                    <textarea name="description"
                              id="description"
                              class="form-control @error('description') is-invalid @enderror"
                              required
                              cols="30" rows="10">{{ $category->description ?? old('description') }}</textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="meta">
                        <h2>SEO</h2>
                        <div class="form-group row">
                            <label for="meta_title" class="col-12 col-form-label">{{ __('Заголовок страницы') }}</label>
                            <div class="col-12">
                                <input id="meta_title"
                                       type="text"
                                       class="form-control @error('meta_title') is-invalid @enderror"
                                       name="meta_title"
                                       value="{{ $category->meta_title ?? old('meta_title') }}"
                                >
                                @error('meta_title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="meta_description" class="col-12 col-form-label">{{ __('Описание страницы') }}</label>
                            <div class="col-12">
                                <input id="meta_description"
                                       type="text"
                                       class="form-control @error('meta_description') is-invalid @enderror"
                                       name="meta_description"
                                       value="{{ $category->meta_description ?? old('meta_description') }}"
                                >
                                @error('meta_description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="meta_keywords" class="col-12 col-form-label">{{ __('Ключи страницы') }}</label>
                            <div class="col-12">
                                <input id="meta_keywords"
                                       type="text"
                                       class="form-control @error('meta_keywords') is-invalid @enderror"
                                       name="meta_keywords"
                                       value="{{ $category->meta_keywords ?? old('meta_keywords') }}"
                                >
                                @error('meta_keywords')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Сохранить') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection