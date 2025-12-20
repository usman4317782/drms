@props([
    'context' => 'primary',
    'pill' => true,
])

<span {{ $attributes->merge([
    'class' => 'badge ' . ($pill ? 'rounded-pill ' : '') . 'bg-' . $context,
]) }}>
    {{ $slot }}
</span>
