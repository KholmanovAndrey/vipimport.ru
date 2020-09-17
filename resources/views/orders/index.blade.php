@extends('layouts.app')

@section('title', 'Все адреса')

@section('sidebar')
    @parent

    <div class="sidebar col">
        <x-office/>
    </div>
@endsection

@section('content')
    <div class="items col-lg-9">
        <div class="items__btn">
            @auth
                <a href="{{ route('order.create') }}" class="btn btn-danger items__link">Добавить заказ</a>
            @endauth
        </div>
        <section class="items__section">
            @foreach ($orders as $item)
                <address class="items__item">
                    <header><h2 class="items__title">{{ $item->title }}</h2></header>
                    <footer class="items__footer">
                        @auth
                            <a href="{{ route('order.edit', $item) }}" class="btn btn-danger items__link">Редактировать</a>
                            <form method="POST"
                                  action="{{ route('order.destroy', $item) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger items__link">
                                    {{ __('Удалить') }}
                                </button>
                            </form>
                        @endauth
                    </footer>
                </address>
            @endforeach
        </section>
    </div>
@endsection