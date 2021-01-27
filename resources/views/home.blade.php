@extends('layouts.app')

@section('title', 'Товары из США и других стран')

@section('content')
    <div class="mb-4 d-flex flex-wrap justify-content-around align-items-stretch">
        @if(Auth::user()->hasRole('superAdmin'))@endif
        @if(Auth::user()->hasRole('admin'))@endif
        @if(Auth::user()->hasRole('manager'))@endif
        @if(Auth::user()->hasRole('client'))
            <div class="mb-4 col-12 col-lg-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="background-color-default">
                                <tr>
                                    <th scope="col" colspan="2">Заказы</th>
                                </tr>
                                </thead>
                                <tbody>
                                {{--<tr>--}}
                                    {{--<th>Новые</th>--}}
                                    {{--<td class="align-middle text-right">0</td>--}}
                                {{--</tr>--}}
                                {{--<tr>--}}
                                    {{--<th>Все</th>--}}
                                    {{--<td class="align-middle text-right">0</td>--}}
                                {{--</tr>--}}
                                <tr>
                                    <td colspan="2">
                                        <div class="d-flex justify-content-first flex-wrap">
                                            <a href="{{ route('order.create') }}" class="btn btn-primary mb-2 mr-2">
                                                <i class="fas fa-plus-square mr-2"></i>Новый заказ
                                            </a>
                                            <a href="{{ route('order.my') }}" class="btn btn-primary mb-2">
                                                <i class="fas fa-shopping-cart mr-2"></i>Мой заказы
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-4 col-12 col-lg-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="background-color-default">
                                <tr>
                                    <th scope="col" colspan="2">Посылки</th>
                                </tr>
                                </thead>
                                <tbody>
                                {{--<tr>--}}
                                    {{--<th>Новые</th>--}}
                                    {{--<td class="align-middle text-right">0</td>--}}
                                {{--</tr>--}}
                                {{--<tr>--}}
                                    {{--<th>Все</th>--}}
                                    {{--<td class="align-middle text-right">0</td>--}}
                                {{--</tr>--}}
                                <tr>
                                    <td colspan="2">
                                        <div class="d-flex justify-content-first flex-wrap">
                                            <a href="{{ route('parcel.create') }}" class="btn btn-primary mb-2 mr-2">
                                                <i class="fas fa-plus-square mr-2"></i>Новая посылка
                                            </a>
                                            <a href="{{ route('parcel.my') }}" class="btn btn-primary mb-2">
                                                <i class="fas fa-shopping-basket mr-2"></i>Мой посылки
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-4 col-12 col-lg-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="background-color-default">
                                <tr>
                                    <th scope="col" colspan="2">Поддержка</th>
                                </tr>
                                </thead>
                                <tbody>
                                {{--<tr>--}}
                                    {{--<th>Кол-во запросов</th>--}}
                                    {{--<td class="align-middle text-right">0</td>--}}
                                {{--</tr>--}}
                                <tr>
                                    <td colspan="2">
                                        <div class="d-flex justify-content-first flex-wrap">
                                            <a href="{{ route('support.create') }}" class="btn btn-primary mb-2 mr-2">
                                                <i class="fas fa-plus-square mr-2"></i>{{ __('Написать в поддержку') }}
                                            </a>
                                            <a href="{{ route('support.my') }}" class="btn btn-primary mb-2">
                                                <span><i class="fas fa-question-circle mr-2"></i>Поддержка</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-4 col-12 col-lg-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="background-color-default">
                                <tr>
                                    <th scope="col" colspan="2">Адреса доставки</th>
                                </tr>
                                </thead>
                                <tbody>
                                {{--<tr>--}}
                                    {{--<th>Кол-во адресов</th>--}}
                                    {{--<td class="align-middle text-right">0</td>--}}
                                {{--</tr>--}}
                                <tr>
                                    <td colspan="2">
                                        <div class="d-flex justify-content-first flex-wrap">
                                            <a href="{{ route('address.create') }}" class="btn btn-primary mb-2 mr-2">
                                                <i class="fas fa-plus-square mr-2"></i>Новый адрес
                                            </a>
                                            <a href="{{ route('address.my') }}" class="btn btn-primary mb-2">
                                                <i class="fas fa-map-marker-alt mr-2"></i>Мои адреса
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
