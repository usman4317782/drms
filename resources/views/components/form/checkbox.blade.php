@props([
    'label' => null,
    'name' => null,
    'checked' => false,
    'value' => '1',
    'required' => false,
    'helperText' => null,
])

<div class="mb-3">
    <div class="form-check">
        <input type="checkbox" name="{{ $name }}" id="{{ $name }}" value="{{ $value }}"
            {{ old(str_replace(['[', ']'], ['.', ''], $name), $checked) ? 'checked' : '' }}
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => 'form-check-input ' . ($name && $errors->has($name) ? 'is-invalid' : '')]) }}>

        @if ($label)
            <label class="form-check-label {{ $required ? 'required' : '' }}" for="{{ $name }}">
                {{ $label }}
            </label>
        @endif

        @error($name)
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror
    </div>

    @if ($helperText)
        <div class="form-text mt-1">
            {{ $helperText }}
        </div>
    @endif
</div>
