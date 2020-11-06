<div class="cz-sidebar-static rounded-lg box-shadow-lg px-0 pb-0 mb-5 mb-lg-0">
    <div class="px-4 pt-4 mb-4">
        <div class="media align-items-center">
            <div class="img-thumbnail rounded-circle position-relative">
                <img alt="{{ Auth::user()->name }}" src="https://secure.gravatar.com/avatar/2fb4970879b372ca73ec4796ac0aa342?s=90&amp;d=mm&amp;r=g" srcset="https://secure.gravatar.com/avatar/2fb4970879b372ca73ec4796ac0aa342?s=180&amp;d=mm&amp;r=g 2x" class="avatar avatar-40 photo rounded-circle" height="40" width="40" gurl="https://secure.gravatar.com/avatar/2fb4970879b372ca73ec4796ac0aa342?s=90&amp;d=mm&amp;r=g" loading="lazy">						</div>
            <div class="media-body pl-3">
                <h3 class="font-size-base mb-0">{{ Auth::user()->name }}</h3>
                {{--<span class="text-accent font-size-sm">{{ Auth::user()->email }}</span>--}}
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

            @if(Auth::user()->hasRole('superAdmin'))
                <div class="alert alert-danger mb-0 mt-2" role="alert">
                    СуперАдминистратор
                </div>
                <li class="border-top mb-0">
                    <a href="{{ route('superAdmin.user-view') }}" class="nav-link-style d-flex align-items-center px-4 py-3">
                        <i class="czi-user align-middle opacity-60 mr-2"></i>Пользователи
                    </a>
                </li>
                <li class="border-top mb-0">
                    <a href="{{ route('superAdmin.statistic') }}" class="nav-link-style d-flex align-items-center px-4 py-3">
                        <i class="czi-user align-middle opacity-60 mr-2"></i>Статистика
                    </a>
                </li>
            @endif

            @if(Auth::user()->hasRole('admin'))
                <div class="alert alert-danger mb-0 mt-2" role="alert">
                    Администратор
                </div>
                <li class="border-top mb-0">
                    <a href="{{ route('category.index') }}" class="nav-link-style d-flex align-items-center px-4 py-3">
                        <i class="czi-bag align-middle opacity-60 mr-2"></i>Категории
                    </a>
                </li>
                <li class="border-top mb-0">
                    <a href="{{ route('article.index') }}" class="nav-link-style d-flex align-items-center px-4 py-3">
                        <i class="czi-bag align-middle opacity-60 mr-2"></i>Статьи
                    </a>
                </li>
                <li class="border-top mb-0">
                    <a href="{{ route('contact.index') }}" class="nav-link-style d-flex align-items-center px-4 py-3">
                        <i class="czi-bag align-middle opacity-60 mr-2"></i>Контакты
                    </a>
                </li>
                <li class="border-top mb-0">
                    <a href="{{ route('country.index') }}" class="nav-link-style d-flex align-items-center px-4 py-3">
                        <i class="czi-bag align-middle opacity-60 mr-2"></i>Страны
                    </a>
                </li>
            @endif

            @if(Auth::user()->hasRole('manager'))
                <div class="alert alert-danger mb-0 mt-2" role="alert">
                    Менеджер
                </div>
                <li class="border-top mb-0">
                    <a href="{{ route('manager.order-new') }}" class="nav-link-style d-flex align-items-center px-4 py-3">
                        <i class="czi-bag align-middle opacity-60 mr-2"></i>Новые заказы
                        {{--<span class="font-size-sm text-muted ml-auto">0</span>--}}
                    </a>
                </li>
                <li class="border-top mb-0">
                    <a href="{{ route('manager.order-my') }}" class="nav-link-style d-flex align-items-center px-4 py-3">
                        <i class="czi-bag align-middle opacity-60 mr-2"></i>Мои заказы
                        {{--<span class="font-size-sm text-muted ml-auto">0</span>--}}
                    </a>
                </li>
                <li class="border-top mb-0">
                    <a href="{{ route('manager.parcel-new') }}" class="nav-link-style d-flex align-items-center px-4 py-3">
                        <i class="czi-basket align-middle opacity-60 mr-2"></i>Посылки в работу
                        {{--<span class="font-size-sm text-muted ml-auto">0</span>--}}
                    </a>
                </li>
                <li class="border-top mb-0">
                    <a href="{{ route('manager.parcel-my') }}" class="nav-link-style d-flex align-items-center px-4 py-3">
                        <i class="czi-basket align-middle opacity-60 mr-2"></i>Мои посылки
                        {{--<span class="font-size-sm text-muted ml-auto">0</span>--}}
                    </a>
                </li>
                <li class="border-top mb-0">
                    <a href="{{ route('manager.support-new') }}" class="nav-link-style d-flex align-items-center px-4 py-3">
                        <i class="czi-support align-middle opacity-60 mr-2"></i>Запросы в поддрежку
                    </a>
                </li>
                <li class="border-top mb-0">
                    <a href="{{ route('manager.support-my') }}" class="nav-link-style d-flex align-items-center px-4 py-3">
                        <i class="czi-support align-middle opacity-60 mr-2"></i>Моя поддержка
                    </a>
                </li>
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

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>