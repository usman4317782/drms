@props([
    'label' => null,
    'name' => null,
    'type' => 'text',
    'value' => null,
    'required' => false,
    'placeholder' => null,
    'helperText' => null,
])

<div class="mb-3">
    @if ($label)
        <label for="{{ $name }}" class="form-label {{ $required ? 'required' : '' }}">
            {{ $label }}
        </label>
    @endif

    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}"
        value="{{ $name ? old($name, $value) : $value }}" placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'form-control ' . ($name && $errors->has($name) ? 'is-invalid' : '')]) }}>

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

<style>
    .required:after {
        content: " *";
        color: #dc3545;
        font-weight: bold;
    }
</style>
