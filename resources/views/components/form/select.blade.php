<div class="form-floating mb-3">
    <select id="{{ $name }}" name="{{ $name }}"
            class="form-control text-light bg-dark @error($name) is-invalid @enderror">
        {{ $slot }}
    </select>
    <label for="{{ $name }}">{{ $label }}</label>
    @error($name)
    <div class="d-block invalid-feedback">{{ $message }}</div>
    @enderror
</div>
