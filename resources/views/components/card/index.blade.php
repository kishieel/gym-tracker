@props(['disabled' => false])

<div {{ $attributes }} class="card bg-dark mb-4 bg-opacity-75 @if($disabled) text-secondary @else text-light @endif">
    <div class="card-body pb-2">
        @isset($title)
            <h5 class="card-title">
                {{ $title ?? '' }}
                @if($disabled)
                    <span class="ms-1 badge rounded-pill bg-danger">
                        deleted
                    </span>
                @endif
            </h5>
        @endisset
        @isset($title)<h6 class="card-subtitle mb-2 text-muted">{{ $subtitle ?? '' }}</h6>@endisset
        {{ $slot }}
    </div>
</div>
