<ul class="{{ $css }}">
    <li class="{{ $css }}__list">
        <a href="{{ url('/') }}" class="{{ $css }}__link">
            <i class="fas fa-home mr-2"></i>Главная</a>
    </li>
</ul>
@if(Auth::user()->hasRole('superAdmin'))
    <ul class="{{ $css }}">
        <li class="{{ $css }}__list">
            <a class="{{ $css }}__link bg-light text-dark">СуперАдмин</a>
        </li>
        <li class="{{ $css }}__list">
            <a href="{{ route('user.index') }}" class="{{ $css }}__link d-flex justify-content-between">
                Пользователи
                @if($clients_new)
                    <span class="bg-danger text-light px-1 rounded-top rounded-bottom">{{ $clients_new }}</span>
                @endif
            </a>
        </li>
        {{--<li class="{{ $css }}__list">--}}
        {{--<a href="{{ route('statistic') }}" class="{{ $css }}__link d-flex justify-content-between">Статистика</a>--}}
        {{--</li>--}}
        <li class="{{ $css }}__list">
            <a href="{{ route('address.index') }}" class="{{ $css }}__link d-flex justify-content-between">
                <i class="fas fa-map-marker-alt mr-2"></i>Адреса клиентов
            </a>
        </li>
        <li class="{{ $css }}__list">
            <a href="{{ route('order.index') }}" class="{{ $css }}__link d-flex justify-content-between">
                Заказы клиентов
                @if($orders_new)
                    <span class="bg-danger text-light px-1 rounded-top rounded-bottom">{{ $orders_new }}</span>
                @endif
            </a>
        </li>
        <li class="{{ $css }}__list">
            <a href="{{ route('parcel.index') }}" class="{{ $css }}__link d-flex justify-content-between">
                Посылки клиентов
                @if($parcels_new)
                    <span class="bg-danger text-light px-1 rounded-top rounded-bottom">{{ $parcels_new }}</span>
                @endif
            </a>
        </li>
        <li class="{{ $css }}__list">
            <a href="{{ route('support.index') }}" class="{{ $css }}__link d-flex justify-content-between">
                Моя поддержка
                @if($messages_new_for_manager)
                    <span class="bg-danger text-light px-1 rounded-top rounded-bottom">{{ $messages_new_for_manager }}</span>
                @endif
            </a>
        </li>
    </ul>
@endif
@if(Auth::user()->hasRole('admin'))
    <ul class="{{ $css }}">
        <li class="{{ $css }}__list">
            <a class="{{ $css }}__link bg-light text-dark">Админ</a>
        </li>
        <li class="{{ $css }}__list"><a href="{{ route('status.index') }}" class="{{ $css }}__link d-flex justify-content-between">Статусы</a></li>
        <li class="{{ $css }}__list"><a href="{{ route('country.index') }}" class="{{ $css }}__link d-flex justify-content-between">Страны</a></li>
    </ul>
@endif
@if(Auth::user()->hasRole('manager'))
    <ul class="{{ $css }}">
        <li class="{{ $css }}__list">
            <a class="{{ $css }}__link bg-light text-dark">Менеджер</a>
        </li>
        <li class="{{ $css }}__list">
            <a href="{{ route('order.new') }}" class="{{ $css }}__link d-flex justify-content-between">
                Новые заказы
                @if($orders_new)
                    <span class="bg-danger text-light px-1 rounded-top rounded-bottom">{{ $orders_new }}</span>
                @endif
            </a>
        </li>
        <li class="{{ $css }}__list"><a href="{{ route('order.my') }}" class="{{ $css }}__link d-flex justify-content-between">Мой заказы</a></li>
        <li class="{{ $css }}__list">
            <a href="{{ route('parcel.new') }}" class="{{ $css }}__link d-flex justify-content-between">
                Новые посылки
                @if($parcels_new)
                    <span class="bg-danger text-light px-1 rounded-top rounded-bottom">{{ $parcels_new }}</span>
                @endif
            </a>
        </li>
        <li class="{{ $css }}__list"><a href="{{ route('parcel.my') }}" class="{{ $css }}__link d-flex justify-content-between">Мой посылки</a></li>
        <li class="{{ $css }}__list">
            <a href="{{ route('support.new') }}" class="{{ $css }}__link d-flex justify-content-between">
                Запросы в поддрежку
            </a>
        </li>
        <li class="{{ $css }}__list">
            <a href="{{ route('support.my') }}" class="{{ $css }}__link d-flex justify-content-between">
                Моя поддержка
                @if($messages_new_for_manager)
                    <span class="bg-danger text-light px-1 rounded-top rounded-bottom">{{ $messages_new_for_manager }}</span>
                @endif
            </a>
        </li>
    </ul>
@endif
@if(Auth::user()->hasRole('client'))
    <ul class="{{ $css }}">
        <li class="{{ $css }}__list">
            <a href="{{ route('address.my') }}" class="{{ $css }}__link">
                <i class="fas fa-map-marker-alt mr-2"></i>Адреса доставки
            </a>
        </li>
        <li class="{{ $css }}__list">
            <a href="{{ route('order.create') }}" class="{{ $css }}__link">
                <i class="fas fa-plus-square mr-2"></i>Новый заказ
            </a>
        </li>
        <li class="{{ $css }}__list">
            <a href="{{ route('order.my') }}" class="{{ $css }}__link d-flex">
                <i class="fas fa-shopping-cart mr-2"></i>Мой заказы
            </a>
        </li>
        <li class="{{ $css }}__list">
            <a href="{{ route('parcel.create') }}" class="{{ $css }}__link">
                <i class="fas fa-plus-square mr-2"></i>Новая посылка
            </a>
        </li>
        <li class="{{ $css }}__list">
            <a href="{{ route('parcel.my') }}" class="{{ $css }}__link">
                <i class="fas fa-shopping-basket mr-2"></i>Мой посылки
            </a>
        </li>
        <li class="{{ $css }}__list">
            <a href="{{ route('support.my') }}" class="{{ $css }}__link d-flex justify-content-between">
                <span><i class="fas fa-question-circle mr-2"></i>Поддержка</span>
                @if($messages_new_for_client)
                    <span class="bg-danger text-light px-1 rounded-top rounded-bottom">{{ $messages_new_for_client }}</span>
                @endif
            </a>
        </li>
    </ul>
@endif