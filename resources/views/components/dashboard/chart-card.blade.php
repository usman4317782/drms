@props(['title', 'chart', 'id' => null, 'width' => 'col-lg-6'])

<div {{ $attributes->merge(['class' => $width]) }}>
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header border-0 bg-transparent">
            <h3 class="card-title fw-bold text-dark">{{ $title }}</h3>
        </div>
        <div class="card-body">
            <div id="{{ $id ?? 'chart-' . uniqid() }}">
                {!! $chart->container() !!}
            </div>
        </div>
    </div>
</div>

@push('scripts')
    {!! $chart->script() !!}
@endpush
