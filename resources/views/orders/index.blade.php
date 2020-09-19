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
                <article class="items__item item-border-bottom">
                    <header>
                        <h3 class="items__title">{{ $item->title }}
                            <span class="badge badge-warning">{{ $item->status->title }}</span>
                            @if($item->isDeleted)
                                <span class="badge badge-danger">На удалении</span>
                            @endif
                        </h3>
                    </header>
                    <div class="items__body">
                        <div>
                            @if((int)$item->manager_id !== 1)
                                <div>Ваш менеджер: {{ $item->manager->name }}</div>
                            @endif
                            <div>Дата создания заказа: {{ date('d.m.Y H:i', date_timestamp_get($item->created_at)) }}</div>
                            <div>Дата обновления заказа: {{ date('d.m.Y H:i', date_timestamp_get($item->updated_at)) }}</div>
                        </div>
                        <div>
                            <div>Количество: {{ $item->count }}</div>
                            @if($item->link)
                                <div>Ссылка: <a href="{{ $item->link }}">{{ $item->link }}</a></div>
                            @endif
                            @if($item->color)
                                <div>Ссылка: {{ $item->color }}</div>
                            @endif
                            @if($item->size)
                                <div>Ссылка: {{ $item->size }}</div>
                            @endif
                            <p>{{ $item->description }}</p>
                        </div>
                    </div>
                    <footer class="items__footer">
                        @auth
                            @if((int)$item->status_id === 1)
                                <a href="{{ route('order.edit', $item) }}" class="btn btn-danger items__link">Редактировать</a>
                            @endif
                            @if(!$item->isDeleted)
                                <form method="POST"
                                      action="{{ route('order.destroy', $item) }}">
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