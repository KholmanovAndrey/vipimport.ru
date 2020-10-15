@extends('layouts.app')

@section('title', 'Товары из США и других стран')

@section('topbar')
    @parent

        <x-slider/>
@endsection

@section('index')
    <section class="index-advantages text-center mb-5" id="advantages">
        <div class="container-fluid">
            <h2 class="index-advantages-title">Наши преимущества</h2>
            <div class="advantages row">
                <div class="col-md-3 advantage"><i class="czi-smile"></i>Недорого и&nbsp;удобно</div>
                <div class="col-md-3 advantage"><i class="czi-basket-alt"></i>Купим товары за&nbsp;вас</div>
                <div class="col-md-3 advantage"><i class="czi-percent advantage-line-through"></i>Нет скрытых комиссий</div>
                <div class="col-md-3 advantage"><i class="czi-dollar-circle advantage-line-through"></i>Базовые услуги бесплатны</div>
            </div>
        </div>
    </section>

    <section class="index-about mb-5">
        <div class="container-fluid">
            <div class="index-about-content col-md-5">
                <div class="headlines">
                    <h2 class="index-about-title">Как мы работаем</h2>
                    <h3 class="index-about-title-sub">Покупаем для вас!</h3>
                </div>
                <p>От Вас требуется только ссылка на товар и деньги, чтоб оплатить покупку и доставку. Не нужно регистрироваться в интернет-магазинах, все это мы сделаем за Вас!</p>
                <p class="button">
                    @guest
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                                <span class="czgb-button--inner">{{ __('Сделать заказ') }}</span><i class="czi czi-arrow-right ml-2 mr-n1"></i>
                            </a>
                        @endif
                    @else
                        <a href="{{ route('order.create') }}" class="btn btn-primary btn-lg">
                            <span class="czgb-button--inner">{{ __('Сделать заказ') }}</span><i class="czi czi-arrow-right ml-2 mr-n1"></i>
                        </a>
                    @endguest
                </p>
            </div>
        </div>
    </section>

    <section class="index-services text-center mb-5">
        <div class="container-fluid">
            <h2 class="index-services-title">А что с гарантиями?</h2>
            <h3 class="index-services-title-sub">Мы&nbsp;доставили по&nbsp;всему миру более 1&nbsp;млн посылок с&nbsp;2008&nbsp;года</h3>
            <div class="services row">
                <div class="col-md-4 service">
                    <i class="czi-check-circle"></i>
                    <div class="h4 title">Проверим товар</div>
                    <div class="description">Сфотографируем товар, проверим важные параметры по&nbsp;вашей просьбе</div>
                </div>
                <div class="col-md-4 service">
                    <i class="czi-security-prohibition"></i>
                    <div class="h4 title">Защитим посылку</div>
                    <div class="description">Компенсируем потери, если с посылкой что-то случится в пути</div>
                </div>
                <div class="col-md-4 service">
                    <i class="czi-reply"></i>
                    <div class="h4 title">Поможем с&nbsp;возвратом</div>
                    <div class="description">Поможем вернуть товар, если он&nbsp;не&nbsp;подошел или не&nbsp;понравился</div>
                </div>
            </div>
        </div>
    </section>

    <section class="index-reg text-center">
        <div class="container-fluid">
            <h2>Начните покупать за&nbsp;рубежом сегодня!</h2>
            <div class="button">
                @guest
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-warning btn-lg">
                        <span class="czgb-button--inner">{{ __('Зарегистрироваться') }}</span><i class="czi czi-arrow-right ml-2 mr-n1"></i>
                    </a>
                @endif
                @endguest
            </div>
        </div>
    </section>

    <section class="index-seo" data-selector="index-seo">

    </section>

@endsection
