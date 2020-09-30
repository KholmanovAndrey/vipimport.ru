@extends('layouts.app')

@section('title', 'Создание/Редактирование')

@section('scripts')
    <script src="{{ asset('js/support.theme.js') }}" defer></script>
@endsection

@section('sidebar')
    @parent

    <div class="sidebar col">
        <x-office/>
    </div>
@endsection

@section('content')
    <form class="col-lg-9"
          method="POST"
          action="{{ route('client.support-store') }}">
        @csrf

        <div class="form-group row">
            <label for="title" class="col-form-label text-md-right">{{ __('Наименование запроса в тех. поддержку') }} <span class="star">*</span></label>
            <input id="title"
                   type="text"
                   class="form-control @error('title') is-invalid @enderror"
                   name="title"
                   value="{{ old('title') }}"
                   placeholder="Наименование запроса в тех. поддержку"
                   required autofocus>
            @error('title')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-group row">
            <label for="support_id" class="col-form-label text-md-right">{{ __('Тема запроса') }}</label>
            <select name="support_id"
                    id="support_id"
                    class="form-control @error('support_id') is-invalid @enderror">
                <option value="common">Общий вопрос</option>
                <option value="order">Вопрос по заказу</option>
                <option value="parcel">Вопрос по посылке</option>
            </select>
            @error('support_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div id="div_order_id" class="form-group row">
            <label for="order_id" class="col-form-label text-md-right">{{ __('Заказы:') }}</label>
            <select name="order_id"
                    id="order_id"
                    class="form-control @error('order_id') is-invalid @enderror">
                <option value="">Выберите заказ</option>
                @foreach($orders as $order)
                    <option value="{{ $order->id }}">{{ $order->title }}</option>
                @endforeach
            </select>
            @error('order_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div id="div_parcel_id" class="form-group row">
            <label for="parcel_id" class="col-form-label text-md-right">{{ __('Посылки:') }}</label>
            <select name="parcel_id"
                    id="parcel_id"
                    class="form-control @error('parcel_id') is-invalid @enderror">
                <option value="">Выберите посылки</option>
                @foreach($parcels as $parcel)
                    <option value="{{ $parcel->id }}">{{ $parcel->title }}</option>
                @endforeach
            </select>
            @error('parcel_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-group row mb-0">
            <div class="col">
                <button type="submit" class="btn btn-primary">{{ __('Сохранить') }}</button>
            </div>
        </div>
    </form>
@endsection