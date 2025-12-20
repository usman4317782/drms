@php
    $roleColors = [
        'supporter' => 'success',
        'donor' => 'primary',
        'volunteer' => 'info',
    ];
@endphp

@foreach ($user->activeRoles as $role)
    @php
        $context = $roleColors[$role->slug] ?? 'secondary';
    @endphp
    <x-ui.badge :context="$context" class="me-1 mb-1">
        {{ $role->name }}
    </x-ui.badge>
@endforeach
