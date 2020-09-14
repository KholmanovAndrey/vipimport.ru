@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="items">
            <h1 class="items__header">Статьи</h1>
            <div class="items_button">
                @guest
                @else
                    <a href="{{ route('article.create') }}" class="btn btn-primary items__link">Создать</a>
                    @endguest
            </div>
            <div class="items_body">
                @forelse($articles as $item)
                    <div class="item">
                        <h2 class="item__header">{{ $item->title }}</h2>
                        <div class="item__body">
                            {{ $item->text }}
                        </div>
                        <div class="item__footer">
                            @guest
                            <a href="{{ route('article.show', $item) }}" class="btn btn-success item__link">Подробнее</a>
                            @else
                                <a href="{{ route('article.show', $item) }}" class="btn btn-success item__link">Подробнее</a>
                                <a href="{{ route('article.edit', $item) }}" class="btn btn-primary item__link">Редактировать</a>
                                @if($item->category_id !== 1)
                                    <form method="POST"
                                          action="{{ route('article.destroy', $item) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger item__link">
                                            {{ __('Удалить') }}
                                        </button>
                                    </form>
                                @endif
                                @endguest
                        </div>
                    </div>
                @empty
                    <div class="item">
                        <h2>Нет статей</h2>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection