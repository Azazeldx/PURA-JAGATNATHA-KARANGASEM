@props([
    'href' => '#',
    'target' => '_parent'
])

<a 
    href="{{ $href }}"
    target="{{ $target }}"
    rel="noopener noreferrer"
    class="text-sm font-semibold text-primary group-hover:underline relative z-20"
>
    {{ $slot }}
</a>