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
        <x-user-title/>
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