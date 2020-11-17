<div class="d-flex align-items-center justify-content-end">
    <div class="header__account px-0 mr-3">
        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @guest
                <div class="nav-item dropdown position-relative">
                    <a id="navbarDropdown" class="icon d-flex align-items-center justify-content-center nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <span class="icon__icon d-inline-flex align-items-center justify-content-center">
                            <i class="icon__i czi-user"></i>
                        </span>
                        <span class="icon__box d-none d-inline-block">
                            <span class="icon__text1 d-block">Мои</span>
                            <span class="icon__text2 d-block">Аккаунт</span>
                        </span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right position-absolute" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('login') }}">{{ __('Вход') }}</a>
                        @if (Route::has('register'))
                            <a class="dropdown-item" href="{{ route('register') }}">{{ __('Регистрация') }}</a>
                        @endif
                    </div>
                </div>
            @else
                <li class="nav-item dropdown position-relative">
                    <a id="navbarDropdown" class="icon d-flex align-items-center justify-content-center nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="icon__icon d-inline-flex align-items-center justify-content-center">
                            <i class="icon__i czi-user"></i>
                        </span>
                        <span class="icon__box d-none d-inline-block">
                            <span class="icon__text1 d-block">Привет!</span>
                            <span class="icon__text2 d-block">{{ Auth::user()->name }}</span>
                        </span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right position-absolute my-0 py-0" aria-labelledby="navbarDropdown">
                        <x-drop-office/>
                    </div>
                </li>
                @endguest
        </ul>
    </div>
    <div class="header__basket px-0 d-none">
        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown position-relative">
                <a id="navbarDropdown" class="icon d-flex align-items-center justify-content-center nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    <span class="icon__icon d-inline-flex align-items-center justify-content-center">
                        <i class="icon__i czi-cart"></i>
                    </span>
                    <span class="icon__box d-none d-sm-inline-block">
                        <span class="icon__text1 d-block">Корзина</span>
                        <span class="icon__text2 icon__price d-block">10 000 руб.</span>
                    </span>
                </a>

                <div class="dropdown-menu dropdown-menu-right position-absolute" aria-labelledby="navbarDropdown">
                    Корзина пуста
                </div>
            </li>
        </ul>
    </div>
</div>