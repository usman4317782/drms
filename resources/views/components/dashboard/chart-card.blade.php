@props(['title', 'chart', 'id' => null, 'width' => 'col-lg-6'])

<div {{ $attributes->merge(['class' => $width]) }}>
    <div class="card mb-4 shadow-sm border-0 h-100 overflow-hidden" style="border-radius: 12px;">
        <div class="card-header border-0 bg-white py-3">
            <h5 class="card-title fw-bold text-dark mb-0">{{ $title }}</h5>
        </div>
        <div class="card-body px-2 pb-2">
            <div id="{{ $id ?? 'chart-' . uniqid() }}" class="modern-chart-container">
                {!! $chart->container() !!}
            </div>
        </div>
    </div>
</div>

@push('scripts')
    {!! $chart->script() !!}
@endpush
