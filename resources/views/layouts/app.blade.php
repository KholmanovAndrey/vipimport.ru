<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - VIP IMPORT</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
@section('scripts')
@show

<!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/cartzilla-icons.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <header class="header">
        <div class="container py-4">
            <div class="row align-items-center">
                <div class="header__col col-md-3 d-none d-md-block">
                    <a class="header__logo" href="{{ url('/') }}"><img width="80%" src="{{ asset('storage/images/logo.png') }}"></a>
                </div>
                <div class="header__col col-md-6">
                    <form method="post" action="#">
                        <div class="search row justify-content-start d-none">
                            <div class="search__col1 col-10 px-0">
                                <input class="search__text" type="text" name="text" placeholder="Поиск по сайту">
                            </div>
                            <div class="search__col2 col-2 px-0">
                                <button class="search__submit" type="submit" name="submit">Поиск</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="header__col col-md-3">
                    <div class="row align-items-center">
                        <div class="header__account col-6 px-0">
                            <!-- Right Side Of Navbar -->
                            <ul class="navbar-nav ml-auto">
                                <!-- Authentication Links -->
                                @guest
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="d-flex align-items-center justify-content-center nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            <span class="icon d-inline-flex align-items-center justify-content-center mr-1">
                                                <i class="icon__i czi-user"></i>
                                            </span>
                                            <span class="d-none d-inline-block">
                                                <span class="d-block">Мои</span>
                                                <span class="d-block">Аккаунт</span>
                                            </span>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="{{ route('login') }}">{{ __('Вход') }}</a>
                                            @if (Route::has('register'))
                                                <a class="dropdown-item" href="{{ route('register') }}">{{ __('Регистрация') }}</a>
                                            @endif
                                        </div>
                                    </li>
                                @else
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="d-flex align-items-center justify-content-center nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="icon d-inline-flex align-items-center justify-content-center mr-1">
                                                <i class="icon__i czi-user"></i>
                                            </span>
                                            <span class="d-none d-inline-block">
                                                <span class="d-block">Привет!</span>
                                                <span class="d-block">{{ Auth::user()->name }}</span>
                                            </span>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                            <x-office/>
                                        </div>
                                    </li>
                                    @endguest
                            </ul>
                        </div>
                        <div class="header__basket col-6 px-0">
                            <!-- Right Side Of Navbar -->
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="d-flex align-items-center justify-content-center nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <span class="icon d-inline-flex align-items-center justify-content-center mr-1">
                                            <i class="icon__i czi-cart"></i>
                                        </span>
                                        <span class="d-none d-inline-block">
                                            <span class="d-block">Корзина</span>
                                            <span class="d-block">10 000 руб.</span>
                                        </span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        Корзина пуста
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand d-block d-md-none" href="{{ url('/') }}">
                    <img width="100" src="{{ asset('storage/images/logo.png') }}">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
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
        </nav>
    </header>

    <main>
        @section('topbar')
        @show
        @section('dashboard')
        @show
        <div class="container">
            <div class="row py-4">
                @section('sidebar')
                @show

                @yield('content')
            </div>
        </div>
    </main>

    <footer class="footer bg-dark">
        <div class="container pt-5">
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
                        <ul class="footer__menu">
                            <li><a class="footer__link" href="{{ route('client.index') }}">{{ __('Ваш аккаунт') }}</a></li>
                            <li><a class="footer__link" href="{{ route('order.index') }}">{{ __('Заказы') }}</a></li>
                            <li><a class="footer__link" href="{{ route('parcel.index') }}">{{ __('Посылки') }}</li>
                            <li><a class="footer__link" href="{{ route('client.support-all') }}">{{ __('Поддержка') }}</a></li>
                            <li><a class="footer__link" href="#">История</a></li>
                        </ul>
                    </div>
                    <div class="footer__nav">
                        <h3 class="footer__title">О нас</h3>
                        <ul class="footer__menu">
                            <li><a class="footer__link" href="#">О компании</a></li>
                            <li><a class="footer__link" href="#">Наша команда</a></li>
                            <li><a class="footer__link" href="{{ route('contact.view') }}">{{ __('Контакты') }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div>
                        <h3 class="footer__title">Будьте в курсе событий</h3>
                        <div>
                            <noscript>Пожалуйста, включите JavaScript в вашем браузере для заполнения данной формы.</noscript>
                            <form method="post" enctype="multipart/form-data" action="#">
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
            <div class="container">
                {{--<div class="mas-static-content footer-static-content">--}}
                    {{--<div class="icon-block bg-darker">--}}
                        {{--<div class="container">--}}
                            {{--<div class="row pb-3">--}}
                                {{--<div class="col-sm-6 col-md-3 mb-4">--}}
                                    {{--<div class="media">--}}
                                        {{--<i class="czi czi-rocket text-primary font-size-36 text-primary"></i>--}}
                                        {{--<div class="media-body pl-3">--}}
                                            {{--<div class="font-size-base mb-1 text-light">Fast and free delivery</div>--}}
                                            {{--<p class="mb-0 font-size-ms opacity-50 text-light">Free delivery for all orders over $200</p>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="col-sm-6 col-md-3 mb-4">--}}
                                    {{--<div class="media">--}}
                                        {{--<i class="czi czi-currency-exchange text-primary font-size-36 text-primary"></i>--}}
                                        {{--<div class="media-body pl-3">--}}
                                            {{--<div class="font-size-base mb-1 text-light">Money back guarantee</div>--}}
                                            {{--<p class="mb-0 font-size-ms opacity-50 text-light">We return money within 30 days</p>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="col-sm-6 col-md-3 mb-4">--}}
                                    {{--<div class="media">--}}
                                        {{--<i class="czi czi-support text-primary font-size-36 text-primary"></i>--}}
                                        {{--<div class="media-body pl-3">--}}
                                            {{--<div class="font-size-base mb-1 text-light">24/7 customer support</div>--}}
                                            {{--<p class="mb-0 font-size-ms opacity-50 text-light">Friendly 24/7 customer support</p>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="col-sm-6 col-md-3 mb-4">--}}
                                    {{--<div class="media">--}}
                                        {{--<i class="czi czi-card text-primary font-size-36 text-primary"></i>--}}
                                        {{--<div class="media-body pl-3">--}}
                                            {{--<div class="font-size-base mb-1 text-light">Secure online payment</div>--}}
                                            {{--<p class="mb-0 font-size-ms opacity-50 text-light">We possess SSL / Secure сertificate</p>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <hr class="hr-light pb-4 mb-3">
                <div class="row pb-2">
                    <div class="col-md-6 text-center text-md-left mb-4">
                        <div class="text-nowrap mb-4">
                            <img width="50%" src="{{ asset('storage/images/logo.png') }}">
                        </div>
                        <div class="widget widget-links widget-light">
                            <ul class="footer__menu list-inline mb-0">
                                <li class="list-inline-item mr-20">
                                    <a class="footer__link" title="Outlets" href="https://usgo.ru/contacts/">Торговые точки</a>
                                </li>
                                <li class="list-inline-item mr-20">
                                    <a class="footer__link" title="Privacy" href="https://usgo.ru/privacy-policy-2/">Конфиденциальность</a>
                                </li>
                                <li class="list-inline-item mr-20">
                                    <a class="footer__link" title="Terms of use" href="https://usgo.ru/terms-conditions/">Условия использования</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 text-center text-md-right mb-4">
                        <div class="mb-3">
                            <ul id="menu-social-media" class="footer__menu list-inline mb-0">
                                <li class="list-inline-item mr-20"><a title="Twitter" target="_blank" href="https://twitter.com/" class="footer__link"><i class="czi-twitter" aria-hidden="true"></i> Twitter</a></li>
                                <li class="list-inline-item mr-20"><a title="Facebook" target="_blank" href="https://facebook.com/" class="footer__link"><i class="czi-facebook" aria-hidden="true"></i> Facebook</a></li>
                                <li class="list-inline-item mr-20"><a title="Instagram" target="_blank" href="https://instagram.com/" class="footer__link"><i class="czi-instagram" aria-hidden="true"></i> Instagram</a></li>
                                <li class="list-inline-item mr-20"><a title="Pinterest" href="https://pinterest.com" class="footer__link"><i class="czi-pinterest" aria-hidden="true"></i> Pinterest</a></li>
                                <li class="list-inline-item mr-20"><a title="YouTube" href="https://youtube.com/" class="footer__link"><i class="czi-youtube" aria-hidden="true"></i> YouTube</a></li>
                            </ul>
                        </div>
                        <div class="d-inline-block payment-methods" style="width: 187px">
                            <img width="100%" src="{{ asset('storage/images/cards-alt.png') }}">
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