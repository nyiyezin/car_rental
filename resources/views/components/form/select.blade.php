@props(['name', 'label' => null])

<div class="form-floating">
    <select class="form-select" id="{{ $name }}" name="{{ $name }}" {{ $attributes }}
        {{ $errors->has($name) ? 'is-invalid' : '' }}">
        {{ $slot }}
    </select>
    @if ($label)
        <label class="form-label" for="{{ $name }}">{{ $label }}</label>
    @endif
    @error($name)
        <span class="invalid-feedback" style="display: inline-block">{{ $message }}</span>
    @enderror
</div>
