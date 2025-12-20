@props([
    'label' => null,
    'name' => null,
    'options' => [],
    'selected' => null,
    'required' => false,
    'placeholder' => 'Select an option',
    'searchable' => true,
])

<div class="mb-3">
    @if ($label)
        <label for="{{ $name }}" class="form-label {{ $required ? 'required' : '' }}">
            {{ $label }}
        </label>
    @endif

    <select name="{{ $name }}" id="{{ $name }}" {{ $required ? 'required' : '' }}
        data-placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'form-select ' . ($searchable ? 'select2 ' : '') . ($errors->has($name) ? 'is-invalid' : '')]) }}>
        @if ($placeholder)
            <option value="" disabled {{ is_null(old($name, $selected)) ? 'selected' : '' }}>{{ $placeholder }}
            </option>
        @endif

        @foreach ($options as $value => $label)
            <option value="{{ $value }}"
                {{ (string) ($name ? old($name, $selected) : $selected) === (string) $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach

        {{ $slot }}
    </select>

    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
