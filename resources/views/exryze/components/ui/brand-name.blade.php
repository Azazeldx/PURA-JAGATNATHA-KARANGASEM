@props([
    'class' => '',
])

<h1
    @class([
        'font-heading font-bold text-sm leading-tight',
        $class
    ])
>
    {{ $settings->get('site.name') ?? 'ExRyze' }}
</h1>