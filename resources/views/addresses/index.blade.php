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
                <div class="mb-2">
                    <a href="@if(Auth::user()->hasRole('superAdmin'))
                        {{ route('superAdmin.address.create') }}
                    @elseif(Auth::user()->hasRole('client'))
                        {{ route('address.create') }}
                    @endif" class="btn btn-primary">
                        <i class="czi-add align-middle"></i> Добавить адрес доставки</a>
                </div>
                @if(Auth::user()->hasRole('superAdmin'))
                    <div class="search mb-2 position-relative">
                        <form method="get" action="{{ route('superAdmin.address.index') }}" class="search__form">
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
                            <th scope="col">Клиент</th>
                            <th scope="col">Адрес</th>
                            <th scope="col" class="align-middle text-right">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($addresses as $item)
                            <tr>
                                <th scope="row" class="align-middle text-center">{{ $item->id }}</th>
                                <td class="align-middle">
                                    @if($item->client)
                                        {{ $item->client->name }}
                                    @endif
                                </td>
                                <td class="align-middle">
                                    {{ $item->postal_code }},
                                    {{ $item->region }},
                                    {{ $item->city }},
                                    {{ $item->street }},
                                    {{ $item->building }}
                                    @if($item->body), кор. {{ $item->body }}@endif
                                    @if($item->apartment), кв. {{ $item->apartment }}@endif
                                </td>
                                <td class="align-middle text-center">
                                    <div class="d-flex justify-content-end">
                                        <a href="@if(Auth::user()->hasRole('superAdmin'))
                                            {{ route('superAdmin.address.show', $item) }}
                                        @elseif(Auth::user()->hasRole('client'))
                                            {{ route('address.show', $item) }}
                                        @endif" class="btn btn-primary mr-2">
                                            <i class="czi-view-list align-middle"></i></a>
                                        <a href="@if(Auth::user()->hasRole('superAdmin'))
                                            {{ route('superAdmin.address.edit', $item) }}
                                        @elseif(Auth::user()->hasRole('client'))
                                            {{ route('address.edit', $item) }}
                                        @endif" class="btn btn-primary mr-2">
                                            <i class="czi-edit align-middle"></i></a>
                                        <form method="POST"
                                              action="@if(Auth::user()->hasRole('superAdmin'))
                                                {{ route('superAdmin.address.destroy', $item) }}
                                              @elseif(Auth::user()->hasRole('client'))
                                                {{ route('address.destroy', $item) }}
                                              @endif">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-primary">
                                                <i class="czi-trash align-middle"></i>
                                            </button>
                                        </form>
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