@props([
    'class' => '',
])

<p 
    @class([
        'text-xs text-muted-foreground leading-tight',
        $class
    ])
>
    {{ $settings->get('site.description') ?? 'ExCMS - Content Management System' }}
</p>