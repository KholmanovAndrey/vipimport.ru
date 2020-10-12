<div class="cz-sidebar-static rounded-lg box-shadow-lg px-0 pb-0 mb-5 mb-lg-0">
    <div class="px-4 pt-4 mb-4">
        <div class="media align-items-center">
            <div class="img-thumbnail rounded-circle position-relative" style="width: 6.375rem;">
                <img alt="{{ Auth::user()->name }}" src="https://secure.gravatar.com/avatar/2fb4970879b372ca73ec4796ac0aa342?s=90&amp;d=mm&amp;r=g" srcset="https://secure.gravatar.com/avatar/2fb4970879b372ca73ec4796ac0aa342?s=180&amp;d=mm&amp;r=g 2x" class="avatar avatar-90 photo rounded-circle" height="90" width="90" gurl="https://secure.gravatar.com/avatar/2fb4970879b372ca73ec4796ac0aa342?s=90&amp;d=mm&amp;r=g" loading="lazy">						</div>
            <div class="media-body pl-3">
                <h3 class="font-size-base mb-0">{{ Auth::user()->name }}</h3>
                <span class="text-accent font-size-sm">{{ Auth::user()->email }}</span>
            </div>
        </div>
    </div>

    <nav>
        <ul class="list-unstyled mb-0">
            <li class="is-active border-top mb-0">
                <a href="{{ route(\Illuminate\Support\Facades\Auth::user()->roles[0]->name . '.index') }}" class="nav-link-style d-flex align-items-center px-4 py-3">
                    <i class="czi-home align-middle opacity-60 mr-2"></i>Главная</a>
            </li>
            <li class="border-top mb-0">
                @if(!$profile = \App\Profile::query()->where('user_id', '=', Auth::user()->id)->first())
                    <a href="{{ route('profile.create') }}" class="nav-link-style d-flex align-items-center px-4 py-3">
                        <i class="czi-user align-middle opacity-60 mr-2"></i>Профиль</a>
                @else
                    <a href="{{ route('profile.show', $profile) }}" class="nav-link-style d-flex align-items-center px-4 py-3">
                        <i class="czi-user align-middle opacity-60 mr-2"></i>Профиль</a>
                @endif
            </li>

            @if(Auth::user()->hasRole('manager'))
                <h5 class="dropdown-item">{{ __('Менеджер') }}</h5>
                <a class="dropdown-item" href="{{ route('manager.index') }}">{{ __('Кабинет') }}</a>
                <a class="dropdown-item" href="{{ route('manager.order-new') }}">{{ __('Новые заказы') }}</a>
                <a class="dropdown-item" href="{{ route('manager.order-my') }}">{{ __('Мои заказы') }}</a>
                <a class="dropdown-item" href="{{ route('manager.parcel-new') }}">{{ __('Посылки в работу') }}</a>
                <a class="dropdown-item" href="{{ route('manager.parcel-my') }}">{{ __('Мои посылки') }}</a>
                <a class="dropdown-item" href="{{ route('manager.support-new') }}">{{ __('Запросы в поддрежку') }}</a>
                <a class="dropdown-item" href="{{ route('manager.support-my') }}">{{ __('Моя поддержка') }}</a>
            @endif

            @if(Auth::user()->hasRole('client'))
                <li class="border-top mb-0">
                    <a href="{{ route('address.index') }}" class="nav-link-style d-flex align-items-center px-4 py-3">
                        <i class="czi-location align-middle opacity-60 mr-2"></i>Адреса доставки</a>
                </li>
                <li class="border-top mb-0">
                    <a href="{{ route('order.index') }}" class="nav-link-style d-flex align-items-center px-4 py-3">
                        <i class="czi-bag align-middle opacity-60 mr-2"></i>Заказы
                        {{--<span class="font-size-sm text-muted ml-auto">0</span>--}}
                    </a>
                </li>
                <li class="border-top mb-0">
                    <a href="{{ route('parcel.index') }}" class="nav-link-style d-flex align-items-center px-4 py-3">
                        <i class="czi-basket align-middle opacity-60 mr-2"></i>Посылки
                        {{--<span class="font-size-sm text-muted ml-auto">0</span>--}}
                    </a>
                </li>
                <li class="border-top mb-0">
                    <a href="{{ route('client.support-all') }}" class="nav-link-style d-flex align-items-center px-4 py-3">
                        <i class="czi-support align-middle opacity-60 mr-2"></i>Поддержка
                    </a>
                </li>
            @endif

            <li class="border-top mb-0">
                <a class="nav-link-style d-block px-4 py-3" href="{{ route('logout') }}"
                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="czi-sign-out align-middle opacity-60 mr-2"></i>{{ __('Выйти') }}
                </a>
            </li>
        </ul>
    </nav>

</div>

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
    <a class="dropdown-item" href="{{ route('manager.support-new') }}">{{ __('Запросы в поддрежку') }}</a>
    <a class="dropdown-item" href="{{ route('manager.support-my') }}">{{ __('Моя поддержка') }}</a>
@endif

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>