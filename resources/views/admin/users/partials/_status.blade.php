@php
    $statusColors = [
        'active' => 'success',
        'inactive' => 'secondary',
        'banned' => 'danger',
    ];
    $context = $statusColors[$user->status] ?? 'dark';
@endphp

<x-ui.badge :context="$context" :pill="false">
    {{ ucfirst($user->status) }}
</x-ui.badge>
