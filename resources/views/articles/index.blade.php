@extends('layouts.app')

@section('title', 'Все статьи')

@section('sidebar')
    @parent

    <div class="sidebar col">
        <div class="list-group">
            @foreach ($categories as $item)
                <a href="{{ route('category.show', $item) }}" class="list-group-item list-group-item-action">
                    {{ $item->title }}
                </a>
            @endforeach
        </div>
    </div>
@endsection

@section('content')
    <div class="items col-lg-9">
        <div class="items__btn">
            @auth
                <a href="{{ route('article.create') }}" class="btn btn-danger items__link">Добавить новую статью</a>
            @endauth
        </div>
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