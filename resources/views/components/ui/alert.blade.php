@props([
    'type' => 'info',
    'message' => null,
    'dismissible' => true,
])

<div {{ $attributes->merge(['class' => "alert alert-{$type} " . ($dismissible ? 'alert-dismissible fade show' : '') . ' shadow-sm border-0']) }}
    role="alert">
    <div class="d-flex align-items-center">
        @php
            $icon = match ($type) {
                'success' => 'bi-check-circle-fill',
                'danger' => 'bi-exclamation-octagon-fill',
                'warning' => 'bi-exclamation-triangle-fill',
                default => 'bi-info-circle-fill',
            };
        @endphp
        <i class="bi {{ $icon }} fs-5 me-2"></i>
        <div>
            {{ $message ?? $slot }}
        </div>
    </div>
    @if ($dismissible)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
</div>
