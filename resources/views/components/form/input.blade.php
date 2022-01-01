<div class="form-floating mb-3">
    <input id="{{ $name }}" type="{{ $type ?? 'text' }}" name="{{ $name }}"
           value="{{ $value ?? '' }}"
           class="form-control text-light bg-dark @error($name) is-invalid @enderror"
           placeholder="{{ $placeholder ?? $label }}"/>
    <label for="{{ $name }}">{{ $label }}</label>
    @error($name)
    <div class="d-block invalid-feedback">{{ $message }}</div>
    @enderror
</div>
