@props([
    'label' => '',
    'slug' => '/',
    'url' => null,
])

@php
    $label = htmlspecialchars_decode($label);
    $isActive = request()->route('slug') == $slug;
@endphp

<li class="w-fit">
    <a href="{{ $url ?? route('exryze.page.dynamic', $slug) }}"
        target="{{ $url != null ? '_blank' : '_parent' }}"
        rel="noopener noreferrer"
        title="{{ $label }}"
        @class([
            'rounded-lg text-sm font-medium block',
            'text-foreground' => $isActive,
            'text-muted-foreground hover:text-foreground' => !$isActive,
        ])
    >{{ $label }}</a>
</li>
