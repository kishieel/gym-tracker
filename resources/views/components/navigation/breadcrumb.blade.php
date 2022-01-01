<li class="breadcrumb-item" aria-current="page">
    @isset($url)
        <a href="{{ $url  }}">{{ $slot }}</a>
    @else
        {{ $slot }}
    @endif
</li>
