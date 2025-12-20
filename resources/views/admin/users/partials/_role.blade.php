@php
    $roleColors = [
        'admin' => 'danger',
        'camp_manager' => 'info',
        'field_staff' => 'warning',
        'supporter' => 'success',
    ];
    $context = $roleColors[$user->role] ?? 'secondary';
    $label = ucwords(str_replace('_', ' ', $user->role));
@endphp

<x-ui.badge :context="$context">
    {{ $label }}
</x-ui.badge>
