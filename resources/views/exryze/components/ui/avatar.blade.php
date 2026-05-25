@props([
    'user' => [],
    'class' => '',
])

<x-exryze::ui.image 
    :url="$user->getFilamentAvatarUrl() ?? 'https://ui-avatars.com/api/?name=' . $user->name"
    @class([
        'aspect-square w-8! h-8! rounded-full',
        $class
    ])
/>