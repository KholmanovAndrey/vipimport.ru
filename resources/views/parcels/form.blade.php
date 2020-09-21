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
          action="@if (!$parcel->id){{ route('parcel.store') }}@else{{ route('parcel.update', $parcel) }}@endif">
        @csrf
        @if ($parcel->id) @method('PUT') @endif

        <div class="form-group row">
            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Наименование') }} <span class="star">*</span></label>
            <div class="col-md-6">
                <input id="title"
                       type="text"
                       class="form-control @error('title') is-invalid @enderror"
                       name="title"
                       value="{{ $parcel->title ?? old('title') }}"
                       required autofocus>
                @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="address_id" class="col-md-4 col-form-label text-md-right">{{ __('Адрес') }} <span class="star">*</span></label>
            <div class="col-md-6">
                <select name="address_id"
                        id="address_id"
                        class="form-control @error('address_id') is-invalid @enderror"
                        required>
                    @foreach ($addresses as $address)
                        <option {{ $address->id === $parcel->address_id ? 'selected="selected"' : '' }} value="{{ $address->id }}">
                            {{ $address->city }} {{ $address->street }} {{ $address->building }}
                        </option>
                    @endforeach
                </select>
                @error('address_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Описание') }}</label>
            <div class="col-md-6">
                <textarea name="description"
                          id="description"
                          class="form-control @error('description') is-invalid @enderror"
                          required
                          cols="30" rows="10">{{ $parcel->description ?? old('description') }}</textarea>
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