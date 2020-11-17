<div>
    @foreach($contacts as $item)
        <a class="topbar__link mr-4" href="tel:{{ trim($item->phone) }}">{{ $item->title }}<i class="topbar__icon czi-support mx-2"></i>{{ $item->phone }}</a>
    @endforeach
</div>