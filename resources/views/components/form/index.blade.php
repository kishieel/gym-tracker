@props([
    'method' => 'get',
    'action' => '',
])

<form method="{{ strtolower($method) == 'get' ? 'get' : 'post' }}" action="{{ $action }}" {{ $attributes }}>
    @if(strtolower($method) !== 'get')
        @method($method)
        @csrf
    @endif
    {{ $slot }}
</form>
