<?php
$title = 'Все посылки';
$breadcrumbs = [
    [
        'name' => 'Личный кабинет',
        'route' => route(\Illuminate\Support\Facades\Auth::user()->roles[0]->name . '.index'),
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
        <div class="items__btn">
            @auth
                <a href="{{ route('parcel.create') }}" class="btn btn-danger items__link">Добавить новую посылку</a>
            @endauth
        </div>
        <section class="items__section">
            @foreach ($parcels as $item)
                <article class="items__item">
                    <header><h2 class="items__title">{{ $item->title }}
                            <span class="badge badge-warning">{{ $item->status->title }}</span>
                        </h2></header>
                    <footer class="items__footer">
                        @auth
                            <a href="{{ route('parcel.show', $item) }}" class="btn btn-danger items__link">Перейти в посылку</a>
                            @if((int)$item->status_id === 6)
                                <form method="POST"
                                      action="{{ route('parcel.destroy', $item) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger item__link">
                                        {{ __('Удалить') }}
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </footer>
                </article>
            @endforeach
        </section>
    </div>
@endsection