@extends('layouts.app')

@section('content')
    <form class="col-12"
          method="POST"
          action="@if (!$profile->id){{ route('article.store') }}@else{{ route('article.update', $profile) }}@endif">
        @csrf
        @if ($profile->id) @method('PUT') @endif

        <div class="form-group row">
            <label for="firstname" class="col-md-4 col-form-label text-md-right">{{ __('Имя') }}</label>
            <div class="col-md-6">
                <input id="firstname"
                       type="text"
                       class="form-control @error('firstname') is-invalid @enderror"
                       name="firstname"
                       value="{{ $profile->firstname ?? old('firstname') }}"
                       required autofocus>
                @error('firstname')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="lastname" class="col-md-4 col-form-label text-md-right">{{ __('Фамилия') }}</label>
            <div class="col-md-6">
                <input id="lastname"
                       type="text"
                       class="form-control @error('lastname') is-invalid @enderror"
                       name="lastname"
                       value="{{ $profile->lastname ?? old('lastname') }}"
                       required autofocus>
                @error('lastname')
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
                       value="{{ $profile->othername ?? old('othername') }}"
                       required autofocus>
                @error('othername')
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
                       value="{{ $profile->email ?? old('email') }}"
                       required autofocus>
                @error('email')
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