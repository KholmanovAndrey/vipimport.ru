@extends('layouts.app')

@section('title', $item->title )

@section('sidebar')
    @parent

    <div class="sidebar col">
        <x-office/>
    </div>
@endsection

@section('content')
    <div class="item col-lg-9">
        <article class="item__article">
            <header><h1 class="item__title">{{ $item->title }}</h1></header>
            <div class="item__text">{{ $item->description }}</div>
            <footer class="item__footer">
                @auth
                    <a href="{{ route('category.edit', $item) }}" class="btn btn-danger item__link">Редактировать</a>
                    <form method="POST"
                          action="{{ route('category.destroy', $item) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger item__link">
                            {{ __('Удалить') }}
                        </button>
                    </form>
                @endauth
            </footer>
        </article>

        <h2>Заказы:</h2>
        <a href="{{ route('parcel-order.create') }}" class="btn btn-danger items__link">Добавить заказ в посылку</a>
        <section class="items__section">
            @foreach ($item->parcelOrders as $order)
                <article class="items__item">
                    <header><h2 class="items__title">{{ $order->title }}</h2></header>
                    <footer class="items__footer">
                        @auth
                            <a href="{{ route('order.edit', $order) }}" class="btn btn-danger items__link">Редактировать</a>
                            @if($item->category_id !== 1)
                                <form method="POST"
                                      action="{{ route('parcel-order.destroy', $order) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger items__link">
                                        {{ __('Удалить') }}
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </footer>
                </article>
            @endforeach
        </section>
    </div>
@endsection