@props(['title', 'description' => null, 'icon' => null])

<div class="app-content-header mb-4">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h3 class="m-0 text-dark fw-bold">
                    @if ($icon)
                        <i class="{{ $icon }} me-2 text-primary"></i>
                    @endif
                    {{ $title }}
                </h3>
                @if ($description)
                    <p class="text-muted small mb-0">{{ $description }}</p>
                @endif
            </div>
            @if (isset($actions))
                <div class="col-sm-6 text-end">
                    {{ $actions }}
                </div>
            @endif
        </div>
    </div>
</div>
