@extends('layouts.app')

@section('title', 'Создание/Редактирование' )

@section('sidebar')
    @parent

    <div class="sidebar col">
        <x-office/>
    </div>
@endsection

@section('content')
    <form class="col-lg-9"
          method="POST"
          action="@if (!$order->id){{ route('order.store') }}@else{{ route('order.update', $order) }}@endif">
        @csrf
        @if ($order->id) @method('PUT') @endif

        <div class="form-group row">
            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Наименование заказа') }}</label>
            <div class="col-md-6">
                <input id="title"
                       type="text"
                       class="form-control @error('title') is-invalid @enderror"
                       name="title[]"
                       placeholder="Наименование заказа"
                       value="{{ $order->title ?? old('title') }}"
                       required autofocus>
                @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="count" class="col-md-4 col-form-label text-md-right">{{ __('Количество') }}</label>
            <div class="col-md-6">
                <input id="count"
                       type="number"
                       class="form-control @error('count') is-invalid @enderror"
                       name="count[]"
                       value="{{ $order->count ?? (old('count') ?? 1) }}"
                       required>
                @error('count')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="link" class="col-md-4 col-form-label text-md-right">{{ __('Ссылка') }}</label>
            <div class="col-md-6">
                <input id="link"
                       type="url"
                       class="form-control @error('link') is-invalid @enderror"
                       name="link[]"
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
            <label for="price" class="col-md-4 col-form-label text-md-right">{{ __('Цена') }}</label>
            <div class="col-md-6">
                <input id="price"
                       type="text"
                       class="form-control @error('price') is-invalid @enderror"
                       name="price[]"
                       placeholder="Цена"
                       value="{{ $order->price ?? old('price') }}">
                @error('price')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="color" class="col-md-4 col-form-label text-md-right">{{ __('Цвет') }}</label>
            <div class="col-md-6">
                <input id="color"
                       type="text"
                       class="form-control @error('color') is-invalid @enderror"
                       name="color[]"
                       placeholder="Цвет"
                       value="{{ $order->color ?? old('color') }}">
                @error('color')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="size" class="col-md-4 col-form-label text-md-right">{{ __('Размер') }}</label>
            <div class="col-md-6">
                <input id="size"
                       type="text"
                       class="form-control @error('size') is-invalid @enderror"
                       name="size[]"
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
            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Описание') }}</label>
            <div class="col-md-6">
                <textarea name="description[]"
                          id="description"
                          class="form-control @error('description') is-invalid @enderror"
                          placeholder="Описание заказа"
                          required
                          cols="30" rows="10">{!! $article->description ?? old('description') !!}</textarea>
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