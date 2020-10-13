@extends('layouts.app')

@section('title', 'Контактная информация')

@section('content')
    <div class="items">
        <h1>Контактная информация</h1>
        <p>{!! $article->text !!}</p>
        <section class="items__section row">
            @foreach ($contacts as $item)
                <article class="items__item col-6">
                    <h2 class="items__title">{{ $item->title }}</h2>
                    <p>{!! $item->address !!}</p>
                    <p>{{ $item->phone }}</p>
                    <p>{{ $item->email }}</p>
                </article>
            @endforeach
        </section>
    </div>
@endsection