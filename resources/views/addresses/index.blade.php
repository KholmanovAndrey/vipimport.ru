<?php
    $title = 'Все адреса';
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
                    <a href="{{ route('address.create') }}" class="btn btn-primary items__link">Добавить адрес доставки</a>
                </div>
                <section class="items__section">
                    @foreach ($addresses as $item)
                        <address class="items__item">
                            <header><h2 class="items__title">{{ $item->city }}{{ $item->street }}{{ $item->building }}</h2></header>
                            <footer class="items__footer">
                                <a href="{{ route('address.edit', $item) }}" class="btn btn-primary items__link">Редактировать</a>
                                <form method="POST"
                                      action="{{ route('address.destroy', $item) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-primary items__link">
                                        {{ __('Удалить') }}
                                    </button>
                                </form>
                            </footer>
                        </address>
                    @endforeach
                </section>
            </div>
        </div>
    </div>
@endsection