@extends('layouts.app')

@section('title', 'Создание/Редактирование')

@section('sidebar')
    @parent

    <div class="sidebar col">
        <x-office/>
    </div>
@endsection

@section('content')
    <form class="col-lg-9"
          method="POST"
          action="@if (!$category->id){{ route('category.store') }}@else{{ route('category.update', $category) }}@endif">
        @csrf
        @if ($category->id) @method('PUT') @endif

        <div class="form-group row">
            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Наименование') }}</label>
            <div class="col-md-6">
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
            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Наименование на английском') }}</label>
            <div class="col-md-6">
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

        {{--<div class="form-group row">--}}
            {{--<label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Категория') }}</label>--}}
            {{--<div class="col-md-6">--}}
                {{--<select name="category_id"--}}
                        {{--id="category_id"--}}
                        {{--class="form-control @error('category_id') is-invalid @enderror"--}}
                        {{--required>--}}
                    {{--@foreach ($categories as $cat)--}}
                        {{--<option {{ $cat->id === $category->category_id ? 'selected="selected"' : '' }} value="{{ $cat->id }}">--}}
                            {{--{{ $cat->title }}--}}
                        {{--</option>--}}
                    {{--@endforeach--}}
                {{--</select>--}}
                {{--@error('category_id')--}}
                {{--<span class="invalid-feedback" role="alert">--}}
                    {{--<strong>{{ $message }}</strong>--}}
                {{--</span>--}}
                {{--@enderror--}}
            {{--</div>--}}
        {{--</div>--}}

        <div class="form-group row">
            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Описание') }}</label>
            <div class="col-md-6">
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

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Сохранить') }}
                </button>
            </div>
        </div>
    </form>
@endsection