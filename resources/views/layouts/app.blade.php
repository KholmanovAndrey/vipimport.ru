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
@section('scripts')
@show

<!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/cartzilla-icons.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <header class="header">
        <div class="topbar topbar-dark bg-dark">
            <div class="container-fluid py-2">
                <a class="topbar__link" href="tel:+100331697720"><i class="topbar__icon czi-support mr-2"></i>(00) 33 169 7720</a>
            </div>
        </div>

        <div class="container-fluid py-3 d-none d-md-block">
            <div class="row align-items-center">
                <div class="header__col col-md-3">
                    <a class="header__logo" href="{{ url('/') }}"><img width="80%" src="{{ asset('public/storage/images/logo.png') }}"></a>
                </div>
                <div class="header__col col-md-6">

                </div>
                <div class="header__col col-md-3">
                    <x-header-drop-controls/>
                </div>
            </div>
        </div>

        <div class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand d-block d-md-none" href="{{ url('/') }}">
                    <img width="100" src="{{ asset('public/storage/images/logo.png') }}">
                </a>

                <div class="d-block d-md-none">
                    <x-header-drop-controls/>
                </div>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">{{ __('Главная') }}</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ __('Полезная информация') }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('category.view', \App\Category::find(2)) }}">
                                    {{ __('Информация для клиентов') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('category.view', \App\Category::find(3)) }}">
                                    {{ __('Юридическая информация') }}
                                </a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ __('Наши услуги') }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('category.view', \App\Category::find(4)) }}">
                                    {{ __('Запчасти из США') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('category.view', \App\Category::find(5)) }}">
                                    {{ __('Техника') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('category.view', \App\Category::find(6)) }}">
                                    {{ __('Одежда и Аксессуары') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('category.view', \App\Category::find(7)) }}">
                                    {{ __('Электроника') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('category.view', \App\Category::find(8)) }}">
                                    {{ __('Товары для дома и офиса') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('category.view', \App\Category::find(9)) }}">
                                    {{ __('Другие услуги') }}
                                </a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contact.view') }}">{{ __('Контакты') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <main>
        @section('topbar')
        @show
        @section('dashboard')
        @show
        <div class="container-fluid py-5 mb-2 mb-md-4">
            <div class="row">
                @section('sidebar')
                @show

                @yield('content')
            </div>
        </div>
        @yield('index')
    </main>

    <footer class="footer bg-dark">
        <div class="container-fluid pt-5">
            <div class="row">
                <div class="footer__nav col-md-4 col-sm-6">
                    <h3 class="footer__title">Магазин</h3>
                    <ul class="footer__menu">
                        <li><a class="footer__link" href="{{ route('category.view', \App\Category::find(4)) }}">
                            {{ __('Запчасти из США') }}
                        </a></li>
                        <li><a class="footer__link" href="{{ route('category.view', \App\Category::find(5)) }}">
                            {{ __('Техника') }}
                        </a></li>
                        <li><a class="footer__link" href="{{ route('category.view', \App\Category::find(6)) }}">
                            {{ __('Одежда и Аксессуары') }}
                        </a></li>
                        <li><a class="footer__link" href="{{ route('category.view', \App\Category::find(7)) }}">
                            {{ __('Электроника') }}
                        </a></li>
                        <li><a class="footer__link" href="{{ route('category.view', \App\Category::find(8)) }}">
                            {{ __('Товары для дома и офиса') }}
                        </a></li>
                        <li><a class="footer__link" href="{{ route('category.view', \App\Category::find(9)) }}">
                            {{ __('Другие услуги') }}
                        </a></li>
                    </ul>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="footer__nav">
                        <h3 class="footer__title">Личный кабинет</h3>
                        @guest
                            <ul class="footer__menu">
                                <li><a class="footer__link" href="{{ route('login') }}">{{ __('Вход') }}</a></li>
                                @if (Route::has('register'))
                                    <li><a class="footer__link" href="{{ route('register') }}">{{ __('Регистрация') }}</a></li>
                                @endif
                            </ul>
                        @endguest
                        @auth
                            @if(Auth::user()->hasRole('client'))
                                <ul class="footer__menu">
                                    <li><a class="footer__link" href="{{ route('client.index') }}">{{ __('Ваш аккаунт') }}</a></li>
                                    <li><a class="footer__link" href="{{ route('order.index') }}">{{ __('Заказы') }}</a></li>
                                    <li><a class="footer__link" href="{{ route('parcel.index') }}">{{ __('Посылки') }}</li>
                                    <li><a class="footer__link" href="{{ route('client.support-all') }}">{{ __('Поддержка') }}</a></li>
                                </ul>
                            @endif
                        @endauth
                    </div>
                    <div class="footer__nav">
                        <h3 class="footer__title">О нас</h3>
                        <ul class="footer__menu">
                            <li><a class="footer__link" href="{{ route('article.view', \App\Article::find(2)) }}">О компании</a></li>
                            <li><a class="footer__link" href="{{ route('contact.view') }}">{{ __('Контакты') }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div>
                        <h3 class="footer__title">Будьте в курсе событий</h3>
                        <div>
                            <noscript>Пожалуйста, включите JavaScript в вашем браузере для заполнения данной формы.</noscript>
                            <form method="post" action="{{ route('subscribe.store') }}">
                                @csrf
                                <div class="subscribe row justify-content-start">
                                    <div class="subscribe__col1">
                                        <input class="subscribe__email" type="email" name="email" placeholder="E-mail">
                                    </div>
                                    <div class="subscribe__col2">
                                        <input class="subscribe__submit" type="submit" name="submit" value="Подписаться">
                                    </div>
                                </div>
                            </form>
                            <p><small class="form-text text-light opacity-50">*Подпишитесь на нашу рассылку новостей, чтобы получать ранние скидки, обновления и новые продукты.</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-5 bg-darker">
            <div class="container-fluid">
                <hr class="hr-light pb-4 mb-3">
                <div class="row pb-2">
                    <div class="col-md-6 text-center text-md-left mb-4">
                        <div class="text-nowrap mb-4">
                            <img width="50%" src="{{ asset('public/storage/images/logo.png') }}">
                        </div>
                        <div class="widget widget-links widget-light">
                            <ul class="footer__menu list-inline mb-0">
                                <li class="list-inline-item mr-20">
                                    <a class="footer__link" title="Privacy" href="{{ route('article.view', \App\Article::find(3)) }}">Конфиденциальность</a>
                                </li>
                                <li class="list-inline-item mr-20">
                                    <a class="footer__link" title="Terms of use" href="#">Условия использования</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 text-center text-md-right mb-4">
                        <div class="mb-3">
                            <ul id="menu-social-media" class="footer__menu list-inline mb-0">
                                <li class="list-inline-item mr-20"><a title="Facebook" target="_blank" href="https://www.facebook.com/vipimport.ru" class="footer__link"><i class="czi-facebook" aria-hidden="true"></i> Facebook</a></li>
                                <li class="list-inline-item mr-20"><a title="Instagram" target="_blank" href="https://www.instagram.com/vipimport.ru" class="footer__link"><i class="czi-instagram" aria-hidden="true"></i> Instagram</a></li>
                                <li class="list-inline-item mr-20"><a title="Vk" href="https://vk.com/marketusa" class="footer__link"><i class="czi-vk" aria-hidden="true"></i> Вконтакте</a></li>
                            </ul>
                        </div>
                        <div class="d-inline-block payment-methods" style="width: 187px">
                            <img width="100%" src="{{ asset('public/storage/images/cards-alt.png') }}">
                            <!-- Global site tag (gtag.js) - Google Analytics -->
                            <script async src="https://www.googletagmanager.com/gtag/js?id=UA-153092867-1"></script>
                            <script>
                                window.dataLayer = window.dataLayer || [];
                                function gtag(){dataLayer.push(arguments);}
                                gtag('js', new Date());

                                gtag('config', 'UA-153092867-1');
                            </script>
                        </div>
                    </div>
                </div>

                <div class="pb-4 font-size-xs text-center text-md-left copyright text-light opacity-50">© Все права защищены.</div>

            </div>
        </div>
    </footer>
</div>
</body>
</html>