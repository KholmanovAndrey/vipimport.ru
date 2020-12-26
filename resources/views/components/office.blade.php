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
        <div class="accordion" id="accordionExample">
            @if(Auth::user()->hasRole('manager'))
                <div class="is-active border-top py-2">
                    @if($clients_new)
                        <a href="#" class="nav-link-style d-flex flex-wrap align-items-center px-4 mb-2">
                            <span class="new ml-2 badge bg-danger rounded-pill">Новые клиенты - {{ $clients_new }}</span>
                        </a>
                    @endif
                    @if($orders_new)
                        <a href="{{ route('manager.order.new') }}" class="nav-link-style d-flex flex-wrap align-items-center px-4 mb-2">
                            <span class="new ml-2 badge bg-danger rounded-pill">Новые заказы - {{ $orders_new }}</span>
                        </a>
                    @endif
                    @if($parcels_new)
                        <a href="{{ route('manager.parcel.new') }}" class="nav-link-style d-flex flex-wrap align-items-center px-4 mb-2">
                            <span class="new ml-2 badge bg-danger rounded-pill">Новые посылки - {{ $parcels_new }}</span>
                        </a>
                    @endif
                    @if($supports_new)
                        <a href="#" class="nav-link-style d-flex flex-wrap align-items-center px-4">
                            <span class="new ml-2 badge bg-danger rounded-pill">Новые запросы - {{ $supports_new }}</span>
                        </a>
                    @endif
                </div>
            @endif
            <div class="is-active border-top mb-0">
                <a href="{{ route(\Illuminate\Support\Facades\Auth::user()->roles[0]->name . '.index') }}" class="nav-link-style d-flex align-items-center px-4 py-3">
                    <i class="czi-home align-middle opacity-60 mr-2"></i>Главная</a>
            </div>
            <div class="border-top mb-0">
                @if(!$profile = \App\Profile::query()->where('user_id', '=', Auth::user()->id)->first())
                    <a href="{{ route('profile.create') }}" class="nav-link-style d-flex align-items-center px-4 py-3">
                        <i class="czi-user align-middle opacity-60 mr-2"></i>Профиль</a>
                @else
                    <a href="{{ route('profile.show', $profile) }}" class="nav-link-style d-flex align-items-center px-4 py-3">
                        <i class="czi-user align-middle opacity-60 mr-2"></i>Профиль</a>
                @endif
            </div>
            @if(Auth::user()->hasRole('superAdmin'))
                <div>
                    <div id="heading1" class="btn alert alert-danger d-block text-left mb-0" data-target="#collapse1" data-toggle="collapse" aria-expanded="true" aria-controls="collapseOne">
                        СуперАдминистратор
                    </div>
                    <div id="collapse1" class="collapse mt-0 pt-0" aria-labelledby="heading1" data-parent="#accordionExample">
                        <ul class="list-unstyled mb-0">
                            <li class="border-top mb-0">
                                <a href="{{ route('superAdmin.user.index') }}" class="nav-link-style d-flex align-items-center px-4 py-3">
                                    <i class="czi-user align-middle opacity-60 mr-2"></i>Пользователи
                                </a>
                            </li>
                            <li class="border-top mb-0">
                                <a href="{{ route('superAdmin.statistic') }}" class="nav-link-style d-flex align-items-center px-4 py-3">
                                    <i class="czi-list align-middle opacity-60 mr-2"></i>Статистика
                                </a>
                            </li>
                            <li class="border-top mb-0">
                                <a href="{{ route('superAdmin.address.index') }}" class="nav-link-style d-flex align-items-center px-4 py-3">
                                    <i class="czi-location align-middle opacity-60 mr-2"></i>Адреса клиентов
                                </a>
                            </li>
                            <li class="border-top mb-0">
                                <a href="{{ route('superAdmin.order.index') }}" class="nav-link-style d-flex align-items-center px-4 py-3">
                                    <i class="czi-bag align-middle opacity-60 mr-2"></i>Заказы клиентов
                                    <span class="new ml-2 badge bg-danger rounded-pill">{{ $orders_new }}</span>
                                </a>
                            </li>
                            <li class="border-top mb-0">
                                <a href="{{ route('superAdmin.parcel.index') }}" class="nav-link-style d-flex align-items-center px-4 py-3">
                                    <i class="czi-basket align-middle opacity-60 mr-2"></i>Посылки клиентов
                                    <span class="new ml-2 badge bg-danger rounded-pill">{{ $parcels_new }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            @endif
            @if(Auth::user()->hasRole('admin'))
                <div>
                    <div id="heading2" class="btn alert alert-danger d-block text-left mb-0" data-target="#collapse2" data-toggle="collapse" aria-expanded="true" aria-controls="collapseOne">
                        Администратор
                    </div>
                    <div id="collapse2" class="collapse mt-0 pt-0" aria-labelledby="heading2" data-parent="#accordionExample">
                        <ul class="list-unstyled mb-0">
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
                        </ul>
                    </div>
                </div>
            @endif
            @if(Auth::user()->hasRole('manager'))
                <div>
                    <div id="heading3" class="btn alert alert-danger d-block text-left mb-0" data-target="#collapse3" data-toggle="collapse" aria-expanded="true" aria-controls="collapseOne">
                        Менеджер
                    </div>
                    <div id="collapse3" class="collapse mt-0 pt-0" aria-labelledby="heading3" data-parent="#accordionExample">
                        <div class="border-top mb-0">
                            <a href="{{ route('manager.statistic') }}" class="nav-link-style d-flex align-items-center px-4 py-3">
                                <i class="czi-list align-middle opacity-60 mr-2"></i>Статистика
                            </a>
                        </div>
                        <div class="accordion" id="accordionExample2">
                            <div>
                                <div id="heading4" class="btn border-top nav-link-style d-flex align-items-center px-4 py-3" data-target="#collapse4" data-toggle="collapse" aria-expanded="true" aria-controls="collapse4">
                                    <i class="czi-bag align-middle opacity-60 mr-2"></i>Заказы
                                    <span class="new ml-2 badge bg-danger rounded-pill">{{ $orders_new }}</span>
                                </div>
                                <div id="collapse4" class="collapse mt-0 pt-0" aria-labelledby="heading4" data-parent="#accordionExample2">
                                    <ul class="list-unstyled mb-0">
                                        <li class="border-top mb-0">
                                            <a href="{{ route('manager.order.new') }}" class="nav-link-style d-flex align-items-center pr-4 pl-5 py-3">
                                                Новые заказы
                                                {{--<span class="font-size-sm text-muted ml-auto">0</span>--}}
                                            </a>
                                        </li>
                                        <li class="border-top mb-0">
                                            <a href="{{ route('manager.order.my') }}" class="nav-link-style d-flex align-items-center pr-4 pl-5 py-3">
                                                Мои заказы
                                                {{--<span class="font-size-sm text-muted ml-auto">0</span>--}}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div>
                                <div id="heading5" class="btn border-top nav-link-style d-flex align-items-center px-4 py-3" data-target="#collapse5" data-toggle="collapse" aria-expanded="true" aria-controls="collapse5">
                                    <i class="czi-basket align-middle opacity-60 mr-2"></i>Посылки
                                    <span class="new ml-2 badge bg-danger rounded-pill">{{ $parcels_new }}</span>
                                </div>
                                <div id="collapse5" class="collapse mt-0 pt-0" aria-labelledby="heading5" data-parent="#accordionExample2">
                                    <ul class="list-unstyled mb-0">
                                        <li class="border-top mb-0">
                                            <a href="{{ route('manager.parcel.new') }}" class="nav-link-style d-flex align-items-center pr-4 pl-5 py-3">
                                                Посылки в работу
                                                {{--<span class="font-size-sm text-muted ml-auto">0</span>--}}
                                            </a>
                                        </li>
                                        <li class="border-top mb-0">
                                            <a href="{{ route('manager.parcel.my') }}" class="nav-link-style d-flex align-items-center pr-4 pl-5 py-3">
                                                Мои посылки
                                                {{--<span class="font-size-sm text-muted ml-auto">0</span>--}}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div>
                                <div id="heading6" class="btn border-top nav-link-style d-flex align-items-center px-4 py-3" data-target="#collapse6" data-toggle="collapse" aria-expanded="true" aria-controls="collapse6">
                                    <i class="czi-support align-middle opacity-60 mr-2"></i>Поддержка
                                    <span class="new ml-2 badge bg-danger rounded-pill">{{ $supports_new }}</span>
                                </div>
                                <div id="collapse6" class="collapse mt-0 pt-0" aria-labelledby="heading6" data-parent="#accordionExample2">
                                    <ul class="list-unstyled mb-0">
                                        <li class="border-top mb-0">
                                            <a href="{{ route('manager.support-new') }}" class="nav-link-style d-flex align-items-center pr-4 pl-5 py-3">
                                                Запросы в поддрежку
                                            </a>
                                        </li>
                                        <li class="border-top mb-0">
                                            <a href="{{ route('manager.support-my') }}" class="nav-link-style d-flex align-items-center pr-4 pl-5 py-3">
                                                Моя поддержка
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if(Auth::user()->hasRole('client'))
                <div>
                    <div id="heading1" class="btn alert alert-danger d-block text-left mb-0" data-target="#collapse1" data-toggle="collapse" aria-expanded="true" aria-controls="collapseOne">
                        Клиент
                    </div>
                    <div id="collapse1" class="collapse show mt-0 pt-0" aria-labelledby="heading1" data-parent="#accordionExample2">
                        <ul class="list-unstyled mb-0">
                            <li class="border-top mb-0">
                                <a href="{{ route('address.index') }}" class="nav-link-style d-flex align-items-center px-4 py-3">
                                    <i class="czi-location align-middle opacity-60 mr-2"></i>Адреса доставки</a>
                            </li>
                            <li class="border-top mb-0">
                                <a href="{{ route('order.index') }}" class="nav-link-style d-flex align-items-center px-4 py-3">
                                    <i class="czi-bag align-middle opacity-60 mr-2"></i>Заказы
                                    <span class="font-size-sm text-muted ml-auto">{{ $client_orders_all }}</span>
                                </a>
                            </li>
                            <li class="border-top mb-0">
                                <a href="{{ route('parcel.index') }}" class="nav-link-style d-flex align-items-center px-4 py-3">
                                    <i class="czi-basket align-middle opacity-60 mr-2"></i>Посылки
                                    <span class="font-size-sm text-muted ml-auto">{{ $client_parcels_all }}</span>
                                </a>
                            </li>
                            <li class="border-top mb-0">
                                <a href="{{ route('client.support-all') }}" class="nav-link-style d-flex align-items-center px-4 py-3">
                                    <i class="czi-support align-middle opacity-60 mr-2"></i>Поддержка
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            @endif
            <div class="border-top mb-0">
                <a class="nav-link-style d-block px-4 py-3" href="{{ route('logout') }}"
                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="czi-sign-out align-middle opacity-60 mr-2"></i>{{ __('Выйти') }}
                </a>
            </div>
        </div>
    </nav>

</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>