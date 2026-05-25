@props([
    'label' => '',
    'icon' => '',
    'url' => '#',
])

<li 
    @class([
        'w-fit transition-all duration-300 hover:scale-[1.1] text-muted-foreground hover:text-foreground'
    ])
>
    <a href="{{ $url }}"
        target="_blank"
        rel="noopener noreferrer"
        title="{{ $label }}"
    >
        <i class="fa-brands fa-{{ $icon }} fa-xl"></i>
    </a>
</li>
