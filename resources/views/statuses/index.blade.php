<?php
$title = 'Все статусы';
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
                <div class="mb-2">
                    <a href="{{ route('status.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus mr-1"></i>Добавить статус</a>
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
                            <th scope="col">Чей статус</th>
                            <th scope="col" class="align-middle text-right">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($statuses as $item)
                            <tr>
                                <th scope="row" class="align-middle text-center">{{ $item->id }}</th>
                                <td class="align-middle">{{ $item->title }}</td>
                                <td class="align-middle">{{ $item->table_name }}</td>
                                <td class="align-middle text-right">
                                    <div class="d-flex justify-content-end">
                                        {{--<a href="{{ route('status.show', $item) }}" class="btn btn-primary mr-2">--}}
                                            {{--<i class="fas fa-eye"></i></a>--}}
                                        <a href="{{ route('status.edit', $item) }}" class="btn btn-primary mr-2">
                                            <i class="far fa-edit"></i></a>
                                        <form method="POST"
                                              action="{{ route('status.destroy', $item) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-primary">
                                                <i class="far fa-trash-alt"></i>
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