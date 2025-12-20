@props([
    'label' => null,
    'name' => null,
    'value' => null,
    'required' => false,
    'rows' => 3,
    'placeholder' => null,
    'helperText' => null,
    'disabled' => false,
])

<div class="mb-3">
    @if ($label)
        <label for="{{ $name }}" class="form-label {{ $required ? 'required' : '' }}">
            {{ $label }}
        </label>
    @endif

    <textarea name="{{ $name }}" id="{{ $name }}" rows="{{ $rows }}" placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }} {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->merge(['class' => 'form-control ' . ($name && $errors->has($name) ? 'is-invalid' : '')]) }}>{{ $name ? old($name, $value) : $value }}</textarea>

    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror

    @if ($helperText)
        <div class="form-text mt-1">
            {{ $helperText }}
        </div>
    @endif
</div>
