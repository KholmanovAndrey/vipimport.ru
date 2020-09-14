@extends('layouts.app')

@section('title', 'Все адреса')

@section('sidebar')
    @parent
    
@endsection

@section('content')
    <div class="items col-lg-9">
        <div class="items__btn">
            @auth
                <a href="{{ route('address.create') }}" class="btn btn-danger items__link">Добавить новую статью</a>
            @endauth
        </div>
        <section class="items__section">
            @foreach ($addresses as $item)
                <address class="items__item">
                    <header><h2 class="items__title">{{ $item->title }}</h2></header>
                    <footer class="items__footer">
                        @auth
                            <a href="{{ route('address.edit', $item) }}" class="btn btn-danger items__link">Редактировать</a>
                            @if($item->category_id !== 1)
                                <form method="POST"
                                      action="{{ route('address.destroy', $item) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger items__link">
                                        {{ __('Удалить') }}
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </footer>
                </address>
            @endforeach
        </section>
    </div>
@endsection