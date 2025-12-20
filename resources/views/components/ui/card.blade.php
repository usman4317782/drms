@props([
    'title' => null,
    'footer' => null,
    'type' => 'primary',
    'outline' => true,
    'shadow' => true,
])

<div
    {{ $attributes->merge([
        'class' => 'card ' . ($outline ? 'card-outline ' : '') . 'card-' . $type . ' ' . ($shadow ? 'shadow-sm' : ''),
    ]) }}>
    @if ($title || isset($header))
        <div class="card-header">
            @if ($title)
                <h3 class="card-title">{{ $title }}</h3>
            @endif
            {{ $header ?? '' }}
        </div>
    @endif

    <div class="card-body">
        {{ $slot }}
    </div>

    @if ($footer)
        <div class="card-footer">
            {{ $footer }}
        </div>
    @endif
</div>
