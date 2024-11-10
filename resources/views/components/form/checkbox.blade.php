@props(['name', 'label' => '', 'checked' => false, 'value' => '1'])

<div class="form-check">
    <input class="form-check-input" id="{{ $name }}" name="{{ $name }}" type="checkbox"
           value="{{ $value }}" {{ old($name, $checked) ? 'checked' : '' }}>
    <label class="form-check-label" for="{{ $name }}">{{ $label }}</label>
    @error($name)
        <span class="invalid-feedback" style="display: inline-block">{{ $message }}</span>
    @enderror
</div>
