<?php
$title = $item->title;
$breadcrumbs = [
    [
        'name' => 'Личный кабинет',
        'route' => route(\Illuminate\Support\Facades\Auth::user()->roles[0]->name . '.index'),
    ],
    [
        'name' => 'Поддержка',
        'route' => route('client.support-all'),
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
    <div class="items col-lg-9">
        <div class="d-flex justify-content-between align-items-center pt-lg-2 pb-4 pb-lg-5 mb-lg-3">
            <h6 class="font-size-base text-light mb-0">Привет, {{ Auth::user()->name }}</h6>
            <a class="btn btn-primary btn-sm d-none d-lg-inline-block" href="{{ route('logout') }}"
               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="czi-sign-out mr-2"></i>Выйти</a>
        </div>
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

        @if(Auth::user()->hasRole('manager') && !$item->manager_id)
            <form method="POST"
                  action="{{ route('manager.support-accept', $item) }}">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-danger item__link">
                    {{ __('Принять') }}
                </button>
            </form>
        @endif

        <form class="col-lg-9"
              method="POST"
              action="{{ route('message.store') }}">
            @csrf

            <input type="hidden" name="support_id" value="{{ $item->id }}">
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