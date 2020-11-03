@extends('layouts.app')

@section('title', 'Ошибка 404')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        <h2>{{ __('Ошибка "500 - Internal Server Error"') }}</h2>
                    </div>
                    <div class="card-body">
                        <h4>Внутренняя ошибка сервера. Приносим свои извинения. Зайдите на сайт позже.</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
