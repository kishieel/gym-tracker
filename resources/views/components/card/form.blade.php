<form method="{{ strtolower($method) == 'get' ? 'get' : 'post' }}" action="{{ $action }}" {{ $attributes }}>
    @method($method)
    @csrf
    <div class="mt-4 mb-5">
        {{ $inputs ?? '' }}
    </div>
    <div class="text-end">
        {{ $buttons ?? '' }}
    </div>
</form>
