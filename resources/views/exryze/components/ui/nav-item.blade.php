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
            'px-4 py-2 rounded-lg text-sm font-medium transition-colors block',
            'bg-primary text-primary-foreground' => $isActive,
            'text-muted-foreground hover:text-foreground hover:bg-primary/10' => !$isActive,
        ])
    >{{ $label }}</a>
</li>
