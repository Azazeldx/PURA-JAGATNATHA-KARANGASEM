@props([
    'post' => []
])

<div class="group flex gap-3">
    <x-exryze::ui.image 
        :image="$post->cover"
        class='w-20! aspect-square shrink-0 rounded-lg'
    />
    <div class="min-w-0">
        <x-exryze::ui.card-title>
            {{ $post->title }}
        </x-exryze::ui.card-title>

        <h4 class="mb-1 font-semibold text-foreground line-clamp-1">
            {{ $post->card_content['aside']['harga'] }}
        </h4>
        
        <x-exryze::ui.card-description>
            {{ $post->description }}
        </x-exryze::ui.card-description>
    </div>
</div>