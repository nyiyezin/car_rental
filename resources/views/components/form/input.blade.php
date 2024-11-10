@props(['name', 'label' => '', 'value' => ''])

<div class="form-floating mb-3">
    <input class="form-control {{ $errors->has($name) ? 'is-invalid' : '' }}" id="{{ $name }}"
        name="{{ $name }}" value="{{ old($name, $value) }}" {{ $attributes }} />
    <label for="{{ $name }}">{{ $label }}</label>
    @error($name)
        <span class="invalid-feedback" style="display: inline-block">{{ $message }}</span>
    @enderror
</div>
