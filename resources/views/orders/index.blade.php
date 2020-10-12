<?php
$title = 'Все заказы';
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
                <a href="{{ route('order.create') }}" class="btn btn-danger items__link">Добавить заказ</a>
            @endauth
        </div>
        <section class="items__section">
            @foreach ($orders as $item)
                <article class="items__item item-border-bottom">
                    <header>
                        <h3 class="items__title">{{ $item->title }}
                            <span class="badge badge-warning">{{ $item->status->title }}</span>
                            @if($item->isDeleted)
                                <span class="badge badge-danger">На удалении</span>
                            @endif
                        </h3>
                    </header>
                    <div class="items__body">
                        <div>
                            @if($item->manager_id !== null)
                                <div>Ваш менеджер: {{ $item->manager->name }}</div>
                            @endif
                            @if($item->parcel_id !== null)
                                <div>Посылка: {{ $item->parcel['title'] }}</div>
                            @endif
                            <div>Дата создания заказа: {{ date('d.m.Y H:i', date_timestamp_get($item->created_at)) }}</div>
                            <div>Дата обновления заказа: {{ date('d.m.Y H:i', date_timestamp_get($item->updated_at)) }}</div>
                        </div>
                        <div>
                            <div>Количество: {{ $item->count }}</div>
                            @if($item->link)
                                <div>Ссылка: <a href="{{ $item->link }}">{{ $item->link }}</a></div>
                            @endif
                            @if($item->color)
                                <div>Ссылка: {{ $item->color }}</div>
                            @endif
                            @if($item->size)
                                <div>Ссылка: {{ $item->size }}</div>
                            @endif
                            <p>{{ $item->description }}</p>
                        </div>
                    </div>
                    <footer class="items__footer">
                        @auth
                            @can('canEditByStatus', $item)
                                @can('canDelete', $item)
                                    <a href="{{ route('order.edit', $item) }}" class="btn btn-danger items__link">Редактировать</a>
                                    <form method="POST"
                                          action="{{ route('order.destroy', $item) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger items__link">
                                            {{ __('Удалить') }}
                                        </button>
                                    </form>
                                @endcan
                            @endcan
                        @endauth
                    </footer>
                </article>
            @endforeach
        </section>
    </div>
@endsection