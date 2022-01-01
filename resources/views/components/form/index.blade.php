<form method="{{ strtolower($method) == 'get' ? 'get' : 'post' }}" action="{{ $action }}" {{ $attributes }}>
    @method($method)
    @csrf
    {{ $slot }}
</form>
