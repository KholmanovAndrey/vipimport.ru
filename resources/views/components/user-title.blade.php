<div class="d-flex justify-content-between align-items-center pt-lg-2 pb-4 pb-lg-5 mb-lg-3">
    <h6 class="font-size-base text-light mb-0">Привет, {{ Auth::user()->name }}</h6>
    <a class="btn btn-primary btn-sm d-none d-lg-inline-block" href="{{ route('logout') }}"
       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
        <i class="czi-sign-out mr-2"></i>Выйти</a>
</div>