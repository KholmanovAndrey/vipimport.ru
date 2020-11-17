<?php
$title = $item->meta_title ?? $item->title;
$meta_description = $item->meta_description;
$meta_keywords = $item->meta_keywords;
?>
@extends('layouts.app')

@section('title', $title)
@section('description', $meta_description)
@section('keywords', $meta_keywords)

@section('content')
    <div class="card w-100">
        <article class="card-body">
            <header><h1 class="item__title">{{ $item->title }}</h1></header>
            <div class="item__text">{!! $item->text !!}</div>
        </article>
    </div>
@endsection