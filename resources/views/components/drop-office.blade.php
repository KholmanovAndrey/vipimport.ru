<nav>
    <ul class="list-unstyled mb-0">
        <li class="mb-0">
            <a href="{{ route(\Illuminate\Support\Facades\Auth::user()->roles[0]->name . '.index') }}" class="nav-link-style d-flex align-items-center px-4 py-3">
                <i class="czi-home align-middle opacity-60 mr-2"></i>Кабинет</a>
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
        <li class="border-top mb-0">
            <a class="nav-link-style d-block px-4 py-3" href="{{ route('logout') }}"
               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="czi-sign-out align-middle opacity-60 mr-2"></i>{{ __('Выйти') }}
            </a>
        </li>
    </ul>
</nav>
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>