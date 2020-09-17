@extends('layouts.app')

@section('title', $item->title )

@section('sidebar')
    @parent

    <div class="sidebar col">
        <x-office/>
    </div>
@endsection

@section('content')
    <div class="item col-lg-9">
        {{ $item->lastname }}
        {{ $item->firstname }}
        {{ $item->othername }}
        <a href="{{ route('profile.edit', $item) }}" class="btn btn-danger">{{ __('Редактировать') }}</a>
        <a href="#" class="btn btn-danger">{{ __('Сменить пароль') }}</a>
    </div>
@endsection