@extends('layouts.app')

@section('title', 'Ошибка 404')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        <h2>{{ __('Ошибка "401 - Unauthorized"') }}</h2>
                    </div>
                    <div class="card-body">
                        <h4>Вы не авторизованны или у Вас нет доступа к данной странице</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
