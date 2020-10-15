@extends('layouts.app')

@section('title', $category->title )

@section('content')
    <div class="content">
        <h1>{{ $category->title }}</h1>
        <section class="articles">
            @foreach ($category->articles as $article)
                <article class="articles__item">
                    <h2 class="articles__title">{{ $article->title }}</h2>
                    <p>{!! $article->text !!}</p>
                </article>
            @endforeach
        </section>
    </div>
@endsection