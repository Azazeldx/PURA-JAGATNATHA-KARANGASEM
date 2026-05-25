@props([
    'class' => '',
])

<span 
    @class([
        'w-fit px-2 py-1 text-xs shadow-xs font-bold uppercase tracking-wider bg-primary/10 text-primary border border-primary/20 rounded-full',
        $class
    ])
    {{ $attributes }}
>
    {{ $slot }}
</span>