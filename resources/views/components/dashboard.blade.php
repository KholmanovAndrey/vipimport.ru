<div class="page-title-overlap bg-dark pt-4">
    <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
            <nav>
                <ol class="breadcrumb breadcrumb-light mt-n1">
                    <li class="breadcrumb-item d-flex mt-1"><a class="nav-link-style" href="{{ route('home') }}">Главная</a></li>
                    @foreach($breadcrumbs as $crumb)
                        <li class="breadcrumb-item d-flex mt-1">
                            @if($crumb['route'])
                                <a class="nav-link-style" href="{{ $crumb['route'] }}">{{ $crumb['name'] }}</a>
                            @else
                                {{ $crumb['name'] }}
                            @endif
                        </li>
                    @endforeach
                </ol>
            </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
            <h1 class="h3 text-light mb-0">{{ $title }}</h1>
        </div>
    </div>
</div>