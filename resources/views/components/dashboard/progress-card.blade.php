@props(['title', 'percentage', 'color' => 'primary', 'icon' => 'activity'])

<div {{ $attributes->merge(['class' => 'col-lg-3 col-md-6 mb-4']) }}>
    <div class="card border-0 shadow-sm h-100 overflow-hidden" style="border-radius: 12px;">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="icon-box bg-{{ $color }} bg-opacity-10 text-{{ $color }} p-2 rounded-3">
                    <i class="bi bi-{{ $icon }} fs-4"></i>
                </div>
                <span class="fw-bold text-{{ $color }}">{{ $percentage }}%</span>
            </div>
            <h6 class="text-muted fw-bold small text-uppercase mb-2" style="letter-spacing: 0.5px;">{{ $title }}
            </h6>
            <div class="progress" style="height: 6px; border-radius: 10px; background-color: rgba(0,0,0,0.05);">
                <div class="progress-bar bg-{{ $color }} rounded-pill" role="progressbar"
                    style="width: {{ $percentage }}%; transition: width 1s ease-in-out;"
                    aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                </div>
            </div>
        </div>
    </div>
</div>
