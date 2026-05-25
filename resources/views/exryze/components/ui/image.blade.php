@props([
    'image' => null,
    'url' => null,
    'class' => '',
])

<img
    loading="lazy"

    src="{{ 
        $url ?? (
            Storage::disk($image->disk ?? 'public')->exists($image->path ?? 'placeholder.svg') 
                ? (Storage::disk($image->disk ?? 'public')->url($image->path ?? 'placeholder.svg')) 
                : asset('placeholder.svg')
            ) 
        }}"

    alt="{{ $image->alt ?? $image->path ?? 'placeholder' }}"

    @class([
        "w-full h-fit object-cover",
        $class
    ])

    {{ $attributes }}
/>