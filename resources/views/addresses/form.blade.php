@extends('layouts.app')

@section('content')
    <form class="col-12"
          method="POST"
          action="@if (!$address->id){{ route('address.store') }}@else{{ route('address.update', $address) }}@endif">
        @csrf
        @if ($address->id) @method('PUT') @endif

        <div class="form-group row">
            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Наименование') }}</label>
            <div class="col-md-6">
                <input id="title"
                       type="text"
                       class="form-control @error('title') is-invalid @enderror"
                       name="title"
                       value="{{ $address->title ?? old('title') }}"
                       required autofocus>
                @error('title')
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