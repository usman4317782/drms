@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => '',
    'icon' => null,
    'loading' => false,
])

<button
    {{ $attributes->merge([
        'type' => $type,
        'class' => 'btn btn-' . $variant . ($size ? ' btn-' . $size : '') . ($loading ? ' disabled' : ''),
    ]) }}>
    @if ($loading)
        <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
    @elseif ($icon)
        <i class="{{ $icon }} me-1"></i>
    @endif

    {{ $slot }}
</button>
