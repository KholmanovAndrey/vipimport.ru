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

@section('content')
    <div class="items">
        <div class="card py-4 mb-4">
            <div class="card-body">
                @if(Auth::user()->hasRole('superAdmin') || Auth::user()->hasRole('client'))
                    <div class="mb-2">
                        <a href="@if(Auth::user()->hasRole('superAdmin'))
                            {{ route('superAdmin.parcel.create') }}
                        @elseif(Auth::user()->hasRole('client'))
                            {{ route('parcel.create') }}
                        @endif" class="btn btn-primary"><i class="fas fa-plus"></i> Добавить посылку</a>
                    </div>
                @endif
                @if(Auth::user()->hasRole('superAdmin') || Auth::user()->hasRole('manager'))
                    <div class="search mb-2 position-relative">
                        <form method="get" action="@if(Auth::user()->hasRole('superAdmin'))
                            {{ route('superAdmin.parcel.index') }}
                        @elseif(Auth::user()->hasRole('client'))
                            {{ route('parcel.index') }}
                        @endif" class="search__form">
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
                                                {{ route('manager.user.show', $item->client) }}
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
                                                  action="{{ route('manager.parcel.accept', $item) }}">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-primary mr-2" title="Принять заказ">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </form>
                                        @endif

                                        <a href="@if(Auth::user()->hasRole('superAdmin') && !Auth::user()->hasRole('manager'))
                                            {{ route('superAdmin.parcel.show', $item) }}
                                        @elseif(Auth::user()->hasRole('manager'))
                                            {{ route('manager.parcel.show', $item) }}
                                        @elseif(Auth::user()->hasRole('client'))
                                            {{ route('parcel.show', $item) }}
                                        @endif" class="btn btn-primary mr-2">
                                            <i class="fas fa-eye"></i></a>

                                        @can('canEditByStatus', $item)
                                            <a href="@if(Auth::user()->hasRole('superAdmin'))
                                                {{ route('superAdmin.parcel.edit', $item) }}
                                            @elseif(Auth::user()->hasRole('client'))
                                                {{ route('parcel.edit', $item) }}
                                            @endif" class="btn btn-primary mr-2">
                                                <i class="far fa-edit"></i></a>
                                            <form method="POST"
                                                  action="@if(Auth::user()->hasRole('superAdmin'))
                                                    {{ route('superAdmin.parcel.destroy', $item) }}
                                                  @elseif(Auth::user()->hasRole('client'))
                                                    {{ route('parcel.destroy', $item) }}
                                                  @endif">
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