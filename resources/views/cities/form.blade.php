@extends('layouts.app')

@section('title', 'Создание/Редактирование')

@section('sidebar')
    @parent

    <div class="sidebar col-lg-3">
        <x-office/>
    </div>
@endsection

@section('content')
    <form class="col-lg-9"
          method="POST"
          action="@if (!$city->id){{ route('city.store') }}@else{{ route('city.update', $city) }}@endif">
        @csrf
        @if ($city->id) @method('PUT') @endif

        <div class="form-group row">
            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Наименование') }}</label>
            <div class="col-md-6">
                <input id="title"
                       type="text"
                       class="form-control @error('title') is-invalid @enderror"
                       name="title"
                       value="{{ $city->title ?? old('title') }}"
                       required autofocus>
                @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('По-английски') }}</label>
            <div class="col-md-6">
                <input id="name"
                       type="text"
                       class="form-control @error('name') is-invalid @enderror"
                       name="title"
                       value="{{ $city->name ?? old('name') }}"
                       required autofocus>
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="country_id" class="col-md-4 col-form-label text-md-right">{{ __('Категория') }}</label>
            <div class="col-md-6">
                <select name="country_id"
                        id="country_id"
                        class="form-control @error('country_id') is-invalid @enderror"
                        required>
                    @foreach ($countries as $country)
                        <option {{ $country->id === $city->country_id ? 'selected="selected"' : '' }} value="{{ $city->id }}">
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

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Сохранить') }}
                </button>
            </div>
        </div>
    </form>
@endsection