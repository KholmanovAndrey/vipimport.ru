<?php
$title = 'Создание/Редактирование статей';
$breadcrumbs = [
    [
        'name' => 'Мои аккаунт',
        'route' => route(\Illuminate\Support\Facades\Auth::user()->roles[0]->name . '.index'),
    ],
    [
        'name' => 'Все статьи',
        'route' => route('article.index'),
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
                      action="@if (!$article->id){{ route('article.store') }}@else{{ route('article.update', $article) }}@endif">
                    @csrf
                    @if ($article->id) @method('PUT') @endif

                    <div class="form-group row">
                        <label for="title" class="col-12 col-form-label">{{ __('Наименование') }}</label>
                        <div class="col-12">
                            <input id="title"
                                   type="text"
                                   class="form-control @error('title') is-invalid @enderror"
                                   name="title"
                                   value="{{ $article->title ?? old('title') }}"
                                   required autofocus>
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="title" class="col-12 col-form-label">{{ __('Наименование на английском') }}</label>
                        <div class="col-12">
                            <input id="name"
                                   type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   name="name"
                                   value="{{ $article->name ?? old('name') }}"
                                   required>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="title" class="col-12 col-form-label">{{ __('Категория') }}</label>
                        <div class="col-12">
                            <select name="category_id"
                                    id="category_id"
                                    class="form-control @error('category_id') is-invalid @enderror"
                                    required>
                                @foreach ($categories as $cat)
                                    <option {{ $cat->id === $article->category_id ? 'selected="selected"' : '' }} value="{{ $cat->id }}">
                                        {{ $cat->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="title" class="col-12 col-form-label">{{ __('Описание') }}</label>
                        <div class="col-12">
                    <textarea name="text"
                              id="text"
                              class="form-control @error('text') is-invalid @enderror"
                              required
                              cols="30" rows="10">{!! $article->text ?? old('text') !!}</textarea>
                            @error('text')
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror
                        </div>
                    </div>

                    {{--<div class="form-group row">--}}
                    {{--<label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Картинка') }}</label>--}}
                    {{--<div class="col-md-6">--}}
                    {{--<input id="image"--}}
                    {{--type="text"--}}
                    {{--class="form-control @error('image') is-invalid @enderror"--}}
                    {{--name="image"--}}
                    {{--value="{{ $article->image ?? old('image') }}"--}}
                    {{--required>--}}
                    {{--@error('image')--}}
                    {{--<span class="invalid-feedback" role="alert">--}}
                    {{--<strong>{{ $message }}</strong>--}}
                    {{--</span>--}}
                    {{--@enderror--}}
                    {{--</div>--}}
                    {{--</div>--}}

                    <div class="meta">
                        <h2>SEO</h2>
                        <div class="form-group row">
                            <label for="meta_title" class="col-12 col-form-label">{{ __('Заголовок страницы') }}</label>
                            <div class="col-12">
                                <input id="meta_title"
                                       type="text"
                                       class="form-control @error('meta_title') is-invalid @enderror"
                                       name="meta_title"
                                       value="{{ $article->meta_title ?? old('meta_title') }}"
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
                                       value="{{ $article->meta_description ?? old('meta_description') }}"
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
                                       value="{{ $article->meta_keywords ?? old('meta_keywords') }}"
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
    <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
    <script>
        var options = {
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
        };
    </script>
    <script>
        CKEDITOR.replace('text', options);
    </script>
@endsection