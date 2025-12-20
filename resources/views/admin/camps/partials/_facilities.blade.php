@if ($camp->facilities)
    @php
        $facilityLabels = config('camp.facilities', []);
    @endphp
    @foreach ($camp->facilities as $key => $value)
        @if ($value)
            @php
                $label = $facilityLabels[$key] ?? ucwords(str_replace('_', ' ', $key));
            @endphp
            <x-ui.badge context="info" class="mb-1">
                {{ $label }}
            </x-ui.badge>
        @endif
    @endforeach
@else
    <span class="text-muted small">No facilities</span>
@endif
