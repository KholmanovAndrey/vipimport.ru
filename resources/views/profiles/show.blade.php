@extends('layouts.app')

@section('title', $item->title )

@section('sidebar')
    @parent

    <div class="sidebar col">
        <p>{{ $item->name }} Lorem ipsum dolor sit amet, consectetur adipisicing elit. At, unde.</p>
    </div>
@endsection

@section('content')
    <div class="item col-lg-10">
        {{ $item->lastname }}
        {{ $item->firstname }}
        {{ $item->othername }}
        <a href="{{ route('profile.edit', $item) }}">{{ __('Редактировать') }}</a>
    </div>
@endsection