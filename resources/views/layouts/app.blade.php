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
    {{--<link href="{{ asset('public/css/cartzilla-icons.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('public/fontawesome/css/all.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <div class="wrapper">
        <div class="top d-lg-flex">
            <div class="sidebar background-color-default col-lg-2 d-flex">
                <div class="logo">
                    <a class="logo__link" href="{{ url('/') }}">
                        <img class="logo__img" src="{{ asset('public/storage/images/logo.png') }}">
                    </a>
                </div>
                <div id="popup-open" class="popup-open d-lg-none mx-2"><i class="fas fa-bars"></i></div>
                <div class="user d-lg-none d-flex flex-grow-1 justify-content-end">
                    <x-account/>
                </div>
            </div>
            <div class="content d-none d-lg-flex col-lg-10">
                <div class="user-dark d-flex flex-grow-1 justify-content-end">
                    <x-account/>
                </div>
            </div>
        </div>
        <div class="middle d-lg-flex t-0 l-0">
            <div class="sidebar background-color-default d-none d-lg-block col-lg-2">
                <?php $css = 'menu' ?>
                <x-office :css="$css"/>
            </div>
            <div class="content col-lg-10">
                @yield('content')
            </div>
        </div>
    </div>
    <div id="popup" class="popup invisible w-100 min-vh-100 position-absolute top-0 start-0">
        <div id="popup-close" class="popup-close">X</div>
        <?php $css = 'popup-menu' ?>
        <x-office :css="$css"/>
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</div>
</body>
</html>