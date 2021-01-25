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

@section('content')
    <div class="items">
        <div class="card py-4 mb-4">
            <div class="card-body">
                @if(Auth::user()->hasRole('superAdmin') || Auth::user()->hasRole('client'))
                    <div class="mb-2">
                        <a href="@if(Auth::user()->hasRole('superAdmin'))
                            {{ route('superAdmin.order.create') }}
                        @elseif(Auth::user()->hasRole('client'))
                            {{ route('order.create') }}
                        @endif" class="btn btn-primary"><i class="fas fa-plus"></i> Добавить заказ</a>
                    </div>
                @endif
                @if(Auth::user()->hasRole('superAdmin') || Auth::user()->hasRole('manager'))
                    <div class="search mb-2 position-relative">
                        <form method="get" action="@if(Auth::user()->hasRole('superAdmin'))
                        {{ route('superAdmin.order.index') }}
                        @elseif(Auth::user()->hasRole('client'))
                        {{ route('order.index') }}
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
                <div class="mb-2">
                    @if(Auth::user()->hasRole('superAdmin'))
                        <a href="{{ route('order.index') }}">Все</a>
                    @endif
                    @if(Auth::user()->hasRole('superAdmin') || Auth::user()->hasRole('manager'))
                        <a href="{{ route('order.new') }}">Новые</a>
                    @endif
                    @if(Auth::user()->hasRole('manager') || Auth::user()->hasRole('client'))
                        <a href="{{ route('order.my') }}">Мои</a>
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
                        @foreach($orders as $item)
                            <tr>
                                <th scope="row" class="align-middle text-center">{{ $item->id }}</th>
                                <td class="align-middle">{{ $item->title }}</td>
                                @if(!Auth::user()->hasRole('client'))
                                    <td class="align-middle">
                                        @if($item->user)
                                            <a href="@if(Auth::user()->hasRole('manager'))
                                                {{ route('manager.user.show', $item->user) }}
                                            @endif">{{ $item->user->name }}</a>
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
                                        @if(Auth::user()->hasRole('manager') && $item->manager_id === null)
                                            <form method="POST"
                                                  action="{{ route('manager.order.accept', $item) }}">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-primary mr-2" title="Принять заказ">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </form>
                                        @endif

                                        <a href="@if(Auth::user()->hasRole('superAdmin') && !Auth::user()->hasRole('manager'))
                                            {{ route('superAdmin.order.show', $item) }}
                                        @elseif(Auth::user()->hasRole('manager'))
                                            {{ route('manager.order.show', $item) }}
                                        @elseif(Auth::user()->hasRole('client'))
                                            {{ route('order.show', $item) }}
                                        @endif" class="btn btn-primary mr-2">
                                            <i class="fas fa-eye"></i></a>

                                        @can('canEditByStatus', $item)
                                            @can('canDelete', $item)
                                                <a href="@if(Auth::user()->hasRole('superAdmin'))
                                                {{ route('superAdmin.order.edit', $item) }}
                                                @elseif(Auth::user()->hasRole('client'))
                                                {{ route('order.edit', $item) }}
                                                @endif" class="btn btn-primary mr-2">
                                                    <i class="far fa-edit"></i></a>
                                                <form method="POST"
                                                      action="@if(Auth::user()->hasRole('superAdmin'))
                                                      {{ route('superAdmin.order.destroy', $item) }}
                                                      @elseif(Auth::user()->hasRole('client'))
                                                      {{ route('order.destroy', $item) }}
                                                      @endif">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            @endcan
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