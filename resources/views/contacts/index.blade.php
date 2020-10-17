<?php
$title = 'Все контакты';
$breadcrumbs = [
    [
        'name' => 'Мои аккаунт',
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
        <x-user-title/>
        <div class="card py-4 mb-4">
            <div class="card-body">
                <div class="items__btn">
                    @auth
                    <a href="{{ route('contact.create') }}" class="btn btn-danger items__link">Добавить контакты</a>
                    @endauth
                </div>
                <section class="items__section">
                    @foreach ($contacts as $item)
                        <article class="items__item">
                            <header><h2 class="items__title">{{ $item->title }}</h2></header>
                            <footer class="items__footer">
                                @auth
                                <a href="{{ route('contact.edit', $item) }}" class="btn btn-danger items__link">Редактировать</a>
                                <form method="POST"
                                      action="{{ route('contact.destroy', $item) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger item__link">
                                        {{ __('Удалить') }}
                                    </button>
                                </form>
                                @endauth
                            </footer>
                        </article>
                    @endforeach
                </section>
            </div>
        </div>
    </div>
@endsection