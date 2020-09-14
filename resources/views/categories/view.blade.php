@extends('layouts.app')

@section('title', $category->title )

{{--@section('sidebar')--}}
    {{--@parent--}}

    {{--<div class="sidebar col">--}}
        {{--<div class="list-group">--}}
            {{--@foreach ($articles as $art)--}}
                {{--<a href="{{ route('article.show', $art) }}"--}}
                    {{--@if($art->id === $item->id)--}}
                        {{--class="list-group-item list-group-item-action list-group-item-danger"--}}
                    {{--@else--}}
                        {{--class="list-group-item list-group-item-action"--}}
                    {{--@endif>--}}
                    {{--{{ $art->title }}--}}
                {{--</a>--}}
            {{--@endforeach--}}
        {{--</div>--}}
    {{--</div>--}}
{{--@endsection--}}

@section('content')
    <div class="item col-lg-9">
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