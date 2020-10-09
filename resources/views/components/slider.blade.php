<div id="carouselExampleCaptions" class="slider carousel slide" data-ride="carousel" style="width: 100%;">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
        <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{ asset('storage/images/slider/img1.jpg') }}" class="d-block w-100" alt="...">
            <div class="slider__text carousel-caption">

                <div class="slider__description">
                    <h2 class="slider__title1">Добро пожаловать в VIP сервис</h2>
                    <h1 class="slider__title2">товаров из США</h1>
                    <p class="slider__p">Мы организуем приобретение и отправку любых товаров для Вас</p>
                    @guest
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-primary">
                                <span class="czgb-button--inner">{{ __('Зарегистрироваться') }}</span><i class="czi czi-arrow-right ml-2 mr-n1"></i>
                            </a>
                        @endif
                    @endguest
                </div>

            </div>
        </div>
        <div class="carousel-item">
            <img src="{{ asset('storage/images/slider/img2.jpg') }}" class="d-block w-100" alt="...">
            <div class="slider__text carousel-caption">

                <div class="slider__description">
                    <h2 class="slider__title1">Начни покупать в США</h2>
                    <h2 class="slider__title2">Прямо сейчас</h2>
                    <p class="slider__p">Миллионы товаров по выгодным ценам выбирай качество, будь в тренде</p>
                    @guest
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-primary">
                                <span class="czgb-button--inner">{{ __('Зарегистрироваться') }}</span><i class="czi czi-arrow-right ml-2 mr-n1"></i>
                            </a>
                        @endif
                    @endguest
                </div>

            </div>
        </div>
        <div class="carousel-item">
            <img src="{{ asset('storage/images/slider/img3.jpg') }}" class="d-block w-100" alt="...">
            <div class="slider__text carousel-caption">

                <div class="slider__description">
                    <h2 class="slider__title1">Регистрируйся и заказывай</h2>
                    <h2 class="slider__title2">любые товары из США</h2>
                    <p class="slider__p">Мы берем на себя полностью всю работу по подбору подходящего по Вашей заявки товара, согласуем с Вами, выкупим и отправим в Ваш адрес.</p>
                    @guest
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-primary">
                                <span class="czgb-button--inner">{{ __('Зарегистрироваться') }}</span><i class="czi czi-arrow-right ml-2 mr-n1"></i>
                            </a>
                        @endif
                    @endguest
                </div>

            </div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>