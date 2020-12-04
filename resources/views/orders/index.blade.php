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
        <x-user-title/>
        <div class="card py-4 mb-4">
            <div class="card-body">
                <div class="mb-2">
                    @auth
                    <a href="@if(Auth::user()->hasRole('superAdmin'))
                        {{ route('superAdmin.order.create') }}
                    @elseif(Auth::user()->hasRole('client'))
                        {{ route('order.create') }}
                    @endif" class="btn btn-primary"><i class="czi-add align-middle"></i> Добавить заказ</a>
                    @endauth
                </div>
                @if(Auth::user()->hasRole('superAdmin') || Auth::user()->hasRole('manager'))
                    <div class="search mb-2 position-relative">
                        <form method="get" action="@if(Auth::user()->hasRole('superAdmin'))
                        {{ route('superAdmin.order.index') }}
                        @elseif(Auth::user()->hasRole('client'))
                        {{ route('order.index') }}
                        @endif" class="search__form">
                            <button type="submit" class="btn btn-primary position-absolute">
                                <i class="czi-search align-middle"></i>
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
                        <thead class="thead-dark">
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
                                            {{ $item->user->name }}
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
                                        <a href="@if(Auth::user()->hasRole('superAdmin'))
                                            {{ route('superAdmin.order.show', $item) }}
                                        @elseif(Auth::user()->hasRole('client'))
                                            {{ route('order.show', $item) }}
                                        @endif" class="btn btn-primary mr-2">
                                            <i class="czi-view-list align-middle"></i></a>
                                        @can('canEditByStatus', $item)
                                            @can('canDelete', $item)
                                                <a href="@if(Auth::user()->hasRole('superAdmin'))
                                                {{ route('superAdmin.order.edit', $item) }}
                                                @elseif(Auth::user()->hasRole('client'))
                                                {{ route('order.edit', $item) }}
                                                @endif" class="btn btn-primary mr-2">
                                                    <i class="czi-edit align-middle"></i></a>
                                                <form method="POST"
                                                      action="@if(Auth::user()->hasRole('superAdmin'))
                                                      {{ route('superAdmin.order.destroy', $item) }}
                                                      @elseif(Auth::user()->hasRole('client'))
                                                      {{ route('order.destroy', $item) }}
                                                      @endif">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="czi-trash align-middle"></i>
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