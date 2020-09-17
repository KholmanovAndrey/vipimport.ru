@extends('layouts.app')

@section('title', 'Все категории')

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
                <a href="{{ route('category.create') }}" class="btn btn-danger items__link">Добавить новую категорию</a>
            @endauth
        </div>
        <section class="items__section">
            @foreach ($categories as $item)
                <article class="items__item">
                    <header><h2 class="items__title">{{ $item->title }}</h2></header>
                    <footer class="items__footer">
                        @auth
                            <a href="{{ route('category.edit', $item) }}" class="btn btn-danger items__link">Редактировать</a>
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
            @endforeach
        </section>
    </div>
@endsection