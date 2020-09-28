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
                <a href="{{ route('parcel.create') }}" class="btn btn-danger items__link">Добавить новую посылку</a>
            @endauth
        </div>
        <section class="items__section">
            @foreach ($parcels as $item)
                <article class="items__item">
                    <header><h2 class="items__title">{{ $item->title }}
                            <span class="badge badge-warning">{{ $item->status->title }}</span>
                        </h2></header>
                    <footer class="items__footer">
                        @auth
                            <a href="{{ route('parcel.show', $item) }}" class="btn btn-danger items__link">Перейти в посылку</a>
                            @if((int)$item->status_id === 6)
                                <form method="POST"
                                      action="{{ route('parcel.destroy', $item) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger item__link">
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