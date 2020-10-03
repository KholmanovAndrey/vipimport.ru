@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('sidebar')
    @parent

    <div class="sidebar col">
        <x-office/>
    </div>
@endsection

@section('content')
    <div class="items col-lg-9">
        <div>SUP{{ $item->id }}</div>
        <div>{{ $item->title }}</div>

        <div class="messages">
            @foreach($item->messages as $message)
                <div class="message">
                    <div class="message__user">{{ $message->user->name }}</div>
                    <div class="message__text">{{ $message->message }}</div>
                </div>
            @endforeach
        </div>

        <form class="col-lg-9"
              method="POST"
              action="{{ route('client.message-store', $item) }}">
            @csrf

            <div class="form-group row">
                <div class="col">
                    <textarea name="message"
                              id="message"
                              class="form-control @error('message') is-invalid @enderror"
                              placeholder="Введите свой вопрос"
                              required
                              cols="30" rows="5"
                              minlength="5"
                    ></textarea>
                    @error('message')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col">
                    <button type="submit" class="btn btn-primary">{{ __('Отправить') }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection