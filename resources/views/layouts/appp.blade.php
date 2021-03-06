<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - VIP IMPORT</title>
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">

    <!-- Scripts -->
    <script src="{{ asset('public/js/app.js') }}" defer></script>
    <script src="{{ asset('public/js/popup.js') }}" defer></script>
    @section('scripts')
    @show

<!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/lk.css') }}" rel="stylesheet">
    <link href="{{ asset('public/fontawesome/css/all.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <div class="wrapper bg-appp">
        <div class="top py-2 px-4 m-4">
            <div class="logo">
                <a class="logo__link" href="{{ url('/') }}">
                    <img class="logo__img" src="{{ asset('public/storage/images/logo.png') }}">
                </a>
            </div>
        </div>
        <div class="middle d-lg-flex t-0 l-0">
            <div class="content col-lg-12">
                @yield('content')
            </div>
        </div>
    </div>
</div>
</body>
</html>