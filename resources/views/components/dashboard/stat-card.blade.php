@props(['title', 'value', 'icon', 'color' => 'primary', 'link' => '#', 'linkText' => 'More info'])

<div {{ $attributes->merge(['class' => 'col-lg-3 col-6']) }}>
    <div class="card border-0 shadow-sm overflow-hidden h-100 modernized-stat-card bg-{{ $color }} text-white" style="border-radius: 12px; transition: transform 0.2s;">
        <div class="card-body p-3 position-relative d-flex align-items-center">
            <div class="flex-grow-1">
                <h6 class="text-uppercase fw-bold opacity-75 mb-1 small" style="letter-spacing: 0.5px;">{{ $title }}</h6>
                <h3 class="fw-bold mb-0">{{ $value }}</h3>
            </div>
            <div class="ms-3 opacity-25">
                <i class="bi bi-{{ $icon }}" style="font-size: 2.5rem;"></i>
            </div>
        </div>
        @if ($link !== '#')
            <a href="{{ $link }}" class="card-footer bg-black bg-opacity-10 border-0 text-center text-white py-2 small fw-bold text-decoration-none hover-opacity-100">
                {{ $linkText }} <i class="bi bi-chevron-right ms-1 small"></i>
            </a>
        @else
            <div class="card-footer bg-transparent border-0 py-1"></div>
        @endif
    </div>
</div>

<style>
    .modernized-stat-card:hover {
        transform: translateY(-5px);
        filter: brightness(1.05);
    }
    .hover-opacity-100:hover {
        background-color: rgba(0,0,0,0.2) !important;
    }
</style>
