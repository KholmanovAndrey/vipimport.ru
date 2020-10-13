@extends('layouts.app')

@section('title', 'Создание/Редактирование')

@section('sidebar')
    @parent

    <div class="sidebar col-lg-3">
        <x-office/>
    </div>
@endsection

@section('content')
    <div class="col-lg-9">
        <x-user-title/>
        <form method="POST"
              action="@if (!$contact->id){{ route('contact.store') }}@else{{ route('contact.update', $contact) }}@endif">
            @csrf
            @if ($contact->id) @method('PUT') @endif

            <div class="form-group row">
                <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Наименование') }}</label>
                <div class="col-md-6">
                    <input id="title"
                           type="text"
                           class="form-control @error('title') is-invalid @enderror"
                           name="title"
                           value="{{ $contact->title ?? old('title') }}"
                           required autofocus>
                    @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Адрес') }}</label>
                <div class="col-md-6">
                    <input id="address"
                           type="text"
                           class="form-control @error('address') is-invalid @enderror"
                           name="address"
                           value="{{ $contact->address ?? old('address') }}"
                           required>
                    @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Телефоны') }}</label>
                <div class="col-md-6">
                    <input id="phone"
                           type="text"
                           class="form-control @error('phone') is-invalid @enderror"
                           name="phone"
                           value="{{ $contact->phone ?? old('phone') }}"
                           required>
                    @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-mail') }}</label>
                <div class="col-md-6">
                    <input id="email"
                           type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           name="email"
                           value="{{ $contact->email ?? old('email') }}"
                           required>
                    @error('email')
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
                              cols="30" rows="10">{{ $contact->description ?? old('description') }}</textarea>
                    @error('description')
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
                           {{--value="{{ $contact->image ?? old('image') }}"--}}
                           {{--required>--}}
                    {{--@error('image')--}}
                    {{--<span class="invalid-feedback" role="alert">--}}
                        {{--<strong>{{ $message }}</strong>--}}
                    {{--</span>--}}
                    {{--@enderror--}}
                {{--</div>--}}
            {{--</div>--}}

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