@props(['title', 'value', 'icon', 'color' => 'primary', 'link' => '#', 'linkText' => 'More info'])

<div {{ $attributes->merge(['class' => 'col-lg-3 col-6']) }}>
    <div class="small-box text-bg-{{ $color }}">
        <div class="inner">
            <h3>{{ $value }}</h3>
            <p>{{ $title }}</p>
        </div>
        <div class="icon">
            <i class="bi bi-{{ $icon }}"></i>
        </div>
        @if ($link !== '#')
            <a href="{{ $link }}" class="small-box-footer link-{{ $color === 'warning' ? 'dark' : 'light' }}">
                {{ $linkText }} <i class="bi bi-arrow-right-circle-fill"></i>
            </a>
        @else
            <div class="small-box-footer py-2"></div>
        @endif
    </div>
</div>
