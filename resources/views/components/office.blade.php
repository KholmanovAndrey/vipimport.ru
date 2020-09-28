<h5 class="dropdown-item">Кабинет</h5>
@if(!$profile = \App\Profile::query()->where('user_id', '=', Auth::user()->id)->first())
    <a class="dropdown-item" href="{{ route('profile.create') }}">{{ __('Личные данные') }}</a>
@else
    <a class="dropdown-item" href="{{ route('profile.show', $profile) }}">{{ __('Личные данные') }}</a>
@endif

@if(Auth::user()->hasRole('superAdmin'))
    <h5 class="dropdown-item">{{ __('СуперАдмин') }}</h5>
@endif

@if(Auth::user()->hasRole('admin'))
    <h5 class="dropdown-item">{{ __('Администратор') }}</h5>
    <a class="dropdown-item" href="{{ route('category.index') }}">{{ __('Категории') }}</a>
    <a class="dropdown-item" href="{{ route('article.index') }}">{{ __('Статьи') }}</a>
    <a class="dropdown-item" href="{{ route('contact.index') }}">{{ __('Контакты') }}</a>
    <a class="dropdown-item" href="{{ route('country.index') }}">{{ __('Страны') }}</a>
@endif

@if(Auth::user()->hasRole('manager'))
    <h5 class="dropdown-item">{{ __('Менеджер') }}</h5>
    <a class="dropdown-item" href="{{ route('manager.index') }}">{{ __('Кабинет') }}</a>
    <a class="dropdown-item" href="{{ route('manager.order-new') }}">{{ __('Новые заказы') }}</a>
    <a class="dropdown-item" href="{{ route('manager.order-my') }}">{{ __('Мои заказы') }}</a>
    <a class="dropdown-item" href="{{ route('manager.parcel-new') }}">{{ __('Посылки в работу') }}</a>
    <a class="dropdown-item" href="{{ route('manager.parcel-my') }}">{{ __('Мои посылки') }}</a>
@endif

@if(Auth::user()->hasRole('client'))
    <h5 class="dropdown-item">{{ __('Клиент') }}</h5>
    <a class="dropdown-item" href="{{ route('address.index') }}">{{ __('Адреса доставки') }}</a>
    <a class="dropdown-item" href="{{ route('order.index') }}">{{ __('Заказы') }}</a>
    <a class="dropdown-item" href="{{ route('parcel.index') }}">{{ __('Посылки') }}</a>
@endif

<a class="dropdown-item" href="{{ route('logout') }}"
   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
    {{ __('Выйти') }}
</a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>