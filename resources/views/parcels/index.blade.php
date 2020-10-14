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
        <x-user-title/>
        <div class="card py-4 mb-4">
            <div class="card-body">
                <div class="items__btn">
                    @auth
                    <a href="{{ route('parcel.create') }}" class="btn btn-primary items__link">Добавить новую посылку</a>
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
                                <a href="{{ route('parcel.show', $item) }}" class="btn btn-primary items__link">Перейти в посылку</a>
                                @if((int)$item->status_id === 6)
                                    <form method="POST"
                                          action="{{ route('parcel.destroy', $item) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-primary item__link">
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
        </div>
    </div>
@endsection