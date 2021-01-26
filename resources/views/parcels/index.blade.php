<?php
$title = 'Все посылки';
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
                @if(Auth::user()->hasRole('superAdmin') || Auth::user()->hasRole('client'))
                    <div class="mb-2">
                        <a href="{{ route('parcel.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Добавить посылку</a>
                    </div>
                @endif
                @if(Auth::user()->hasRole('superAdmin') || Auth::user()->hasRole('manager'))
                    <div class="search mb-2 position-relative">
                        <form method="get" action="{{ route('parcel.index') }}" class="search__form">
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
                        <a href="{{ route('parcel.index', ['search' => $search]) }}">Все</a>
                    @endif
                    @if(Auth::user()->hasRole('superAdmin') || Auth::user()->hasRole('manager'))
                        <a href="{{ route('parcel.new', ['search' => $search]) }}">Новые</a>
                    @endif
                    @if(Auth::user()->hasRole('manager') || Auth::user()->hasRole('client'))
                        <a href="{{ route('parcel.my', ['search' => $search]) }}">Мои</a>
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
                            <th scope="col">Наименование</th>
                            @if(!Auth::user()->hasRole('client'))
                                <th scope="col">Клиент</th>
                            @endif
                            <th scope="col">Менеджер</th>
                            <th scope="col">Статус</th>
                            <th scope="col" class="align-middle text-right">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($parcels as $item)
                            <tr>
                                <th scope="row" class="align-middle text-center">{{ $item->id }}</th>
                                <td class="align-middle">{{ $item->title }}</td>
                                @if(!Auth::user()->hasRole('client'))
                                    <td class="align-middle">
                                        @if($item->client)
                                            <a href="@if(Auth::user()->hasRole('manager'))
                                                {{ route('user.show', $item->client) }}
                                            @endif">{{ $item->client->name }}</a>
                                        @endif
                                    </td>
                                @endif
                                <td class="align-middle">
                                    @if($item->manager)
                                        {{ $item->manager->name }}
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <span class="badge badge-warning">{{ $item->status->title }}</span>
                                    @if($item->isDeleted)
                                        <span class="badge badge-danger">На удалении</span>
                                    @endif
                                </td>
                                <td class="align-middle text-right">
                                    <div class="d-flex justify-content-end">
                                        @if(Auth::user()->hasRole('manager') &&
                                        $item->manager_id === null &&
                                        $item->status_id != 6)
                                            <form method="POST"
                                                  action="{{ route('parcel.accept', $item) }}">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-primary mr-2" title="Принять заказ">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </form>
                                        @endif

                                        <a href="{{ route('parcel.show', $item) }}" class="btn btn-primary">
                                            <i class="fas fa-eye"></i></a>

                                        @can('canEditByStatus', $item)
                                            <a href="{{ route('parcel.edit', $item) }}" class="btn btn-primary mx-2">
                                                <i class="far fa-edit"></i></a>
                                            <form method="POST"
                                                  action="{{ route('parcel.destroy', $item) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        @endcan
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