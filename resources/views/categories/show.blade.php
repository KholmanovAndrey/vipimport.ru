@extends('layouts.app')

@section('title', $item->title )

@section('sidebar')
    @parent

    <div class="sidebar col">
        <div class="list-group">
            @foreach ($categories as $cat)
                <a href="{{ route('category.show', $cat) }}"
                    @if($cat->id === $item->id)
                        class="list-group-item list-group-item-action list-group-item-danger"
                    @else
                        class="list-group-item list-group-item-action"
                    @endif>
                    {{ $cat->title }}
                </a>
            @endforeach
        </div>
    </div>
@endsection

@section('content')
    <div class="item col-lg-9">
        <article class="item__article">
            <header><h1 class="item__title">{{ $item->title }}</h1></header>
            <div class="item__text">{{ $item->text }}</div>
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

        <h2>Статьи данной категории</h2>
        <section class="items__section">
            @foreach ($articles as $item)
                <article class="items__item">
                    <header><h2 class="items__title">{{ $item->title }}</h2></header>
                    <footer class="items__footer">
                        @auth
                            <a href="{{ route('article.edit', $item) }}" class="btn btn-danger items__link">Редактировать</a>
                            @if($item->category_id !== 1)
                                <form method="POST"
                                      action="{{ route('article.destroy', $item) }}">
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