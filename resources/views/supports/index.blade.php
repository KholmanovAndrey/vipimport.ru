<?php
$title = 'Поддержка';
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
                @if(Auth::user()->hasRole('client'))
                    <div class="items__btn">
                        <a class="btn btn-primary" href="{{ route('support.create') }}">{{ __('Написать в поддержку') }}</a>
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col" class="align-middle text-center">#</th>
                            <th scope="col" class="align-middle">Наименование</th>
                            <th scope="col" class="align-middle text-center">Тема</th>
                            <th scope="col" class="align-middle text-center">Действие</th>
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
                                <td class="align-middle text-center">
                                    <div class="d-flex justify-content-center">
                                        <a class="btn btn-primary mr-2" href="{{ route('support.show', $item) }}" title="Перейти в запрос">
                                            <i class="czi-document align-middle"></i></a>
                                        @if(Auth::user()->hasRole('manager') && !$item->manager_id)
                                            <form class="row" method="POST"
                                                  action="{{ route('manager.support-accept', $item) }}">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-primary" title="Принять в работу">
                                                    <i class="czi-add align-middle"></i>
                                                </button>
                                            </form>
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