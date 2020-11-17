<?php
$title = $category->meta_title ?? $category->title;
$meta_description = $category->meta_description;
$meta_keywords = $category->meta_keywords;
?>
@extends('layouts.app')

@section('title', $title)
@section('description', $meta_description)
@section('keywords', $meta_keywords)

@section('content')
    <div class="card w-100">
        <div class="card-body">
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
    </div>
@endsection