<?php
$title = 'Поддержка';
$breadcrumbs = [
    [
        'name' => 'Личный кабинет',
        'route' => route('home'),
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

@section('content')
    <div class="items">
        <div class="card py-4 mb-4">
            <div class="card-body">
                @if(Auth::user()->hasRole('client'))
                    <div class="mb-2">
                        <a href="{{ route('support.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus mr-1"></i>{{ __('Написать в поддержку') }}</a>
                    </div>
                @endif
                    @if(Auth::user()->hasRole('superAdmin') || Auth::user()->hasRole('manager'))
                        <div class="search mb-2 position-relative">
                            <form method="get" action="{{ route('support.index') }}" class="search__form">
                                <button type="submit" class="btn btn-primary position-absolute">
                                    <i class="fas fa-search"></i>
                                </button>
                                <input type="text"
                                       name="search"
                                       class="form-control pl-5"
                                       value="{{ $search ?? '' }}"
                                       placeholder="Введите логин или E-mail клиента">
                            </form>
                        </div>
                    @endif
                <div class="mb-2">
                    @if(Auth::user()->hasRole('superAdmin'))
                        <a href="{{ route('support.index', ['search' => $search]) }}">Все</a>
                    @endif
                    @if(Auth::user()->hasRole('superAdmin') || Auth::user()->hasRole('manager'))
                        <a href="{{ route('support.new', ['search' => $search]) }}">Новые</a>
                    @endif
                    @if(Auth::user()->hasRole('manager'))
                        <a href="{{ route('support.my', ['search' => $search]) }}">Мои</a>
                    @endif
                </div>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="background-color-default">
                        <tr>
                            <th scope="col" class="align-middle text-center">#</th>
                            <th scope="col" class="align-middle">Наименование</th>
                            <th scope="col" class="align-middle text-center">Тема</th>
                            @if(!Auth::user()->hasRole('client'))
                                <th scope="col">Клиент</th>
                            @endif
                            <th scope="col">Менеджер</th>
                            <th scope="col" class="align-middle text-center">&nbsp;</th>
                            <th scope="col" class="align-middle text-right">Действие</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($supports as $item)
                            <tr>
                                <th scope="row" class="align-middle text-center">SUP{{ $item->id }}</th>
                                <td class="align-middle">{{ $item->title }}</td>
                                <td class="align-middle text-center">
                                    @if($item->order)
                                        {{ $item->order->title }}
                                    @endif
                                    @if($item->parcel)
                                        {{ $item->parcel->title }}
                                    @endif
                                    @if(!$item->parcel && !$item->order)
                                        {{ __('Общий') }}
                                    @endif
                                </td>
                                @if(!Auth::user()->hasRole('client'))
                                    <td class="align-middle">
                                        @if($item->client)
                                            <a href="{{ route('user.show', $item->client) }}">
                                                {{ $item->client->name }}</a>
                                        @endif
                                    </td>
                                @endif
                                <td class="align-middle">
                                    @if($item->manager)
                                        {{ $item->manager->name }}
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    @if(Auth::user()->hasRole('superAdmin') && $item->client_add_at > $item->manager_add_at)
                                        есть новые сообщения
                                    @endif
                                    @if(Auth::user()->hasRole('manager') && $item->client_add_at > $item->manager_add_at)
                                        есть новые сообщения
                                    @endif
                                    @if(Auth::user()->hasRole('client') && $item->client_add_at < $item->manager_add_at)
                                        есть новые сообщения
                                    @endif
                                </td>
                                <td class="align-middle text-right">
                                    <div class="d-flex justify-content-end">
                                        @if(Auth::user()->hasRole('manager') && !$item->manager_id)
                                            <form method="POST"
                                                  action="{{ route('support.accept', $item) }}">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-primary" title="Принять в работу">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </form>
                                        @else
                                        <a class="btn btn-primary" href="{{ route('support.show', $item) }}" title="Перейти в запрос">
                                            <i class="fas fa-file-alt"></i></a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection