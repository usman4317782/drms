@php
    $context = match ($camp->status) {
        'active' => 'success',
        'full' => 'warning',
        'closed' => 'danger',
        default => 'secondary',
    };
@endphp

<x-ui.badge :context="$context">
    {{ ucfirst($camp->status) }}
</x-ui.badge>
