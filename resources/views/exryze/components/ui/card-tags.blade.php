@props([
    'tags' => [],
])

<div class="flex flex-wrap gap-2 mb-3">
    @foreach ($tags as $tag)
        {{-- <x-filament::badge>
            {{ $tag->title }}
        </x-filament::badge> --}}
        <x-exryze::ui.badge>
            {{ $tag->title }}
        </x-exryze::ui.badge>
    @endforeach
</div>