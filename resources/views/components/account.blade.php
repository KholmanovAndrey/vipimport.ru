@guest
    <a href="{{ route('login') }}" class="user__link mx-2">
        <i class="fas fa-sign-in-alt mr-1"></i><span class="d-none d-lg-inline">Войти</span></a>
    @if (Route::has('register'))
        <a href="{{ route('register') }}" class="user__link">
            <i class="fas fa-user-plus mr-1"></i><span class="d-none d-lg-inline">Регистрация</span></a>
    @endif
@endguest
@auth
    @if(Auth::user()->hasRole('client'))
        <a href="#" class="user__link mx-2">
            <i class="fas fa-money-bill-wave mr-1"></i><span class="d-none d-lg-inline">Баланс: {{ $balance }}</span></a>
    @endif
    @if(!$profile = \App\Profile::query()->where('user_id', '=', Auth::user()->id)->first())
        <a href="{{ route('profile.create') }}" class="user__link mx-2">
            <i class="fas fa-user-cog mr-1"></i><span class="d-none d-lg-inline">{{ Auth::user()->name }}</span></a>
    @else
        <a href="{{ route('profile.show', $profile) }}" class="user__link mx-2">
            <i class="fas fa-user-cog mr-1"></i><span class="d-none d-lg-inline">{{ Auth::user()->name }}</span></a>
    @endif
    <a href="{{ route('logout') }}"
       onclick="event.preventDefault();document.getElementById('logout-form').submit();"
       class="user__link">
        <i class="fas fa-sign-out-alt mr-1"></i><span class="d-none d-lg-inline">Выйти</span></a>
@endauth