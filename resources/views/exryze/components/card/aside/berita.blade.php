@props([
    'post' => []
])

<div class="relative group flex gap-3">

    <a 
        href="{{ Route::has('exryze.post.detail') ? 
            route('exryze.post.detail', [
                'type' => $post->type->slug, 
                'slug' => $post->slug]) 
            : '#'}}"
        class="absolute inset-0 z-10"
    >
    </a>

    <x-exryze::ui.image 
        :image="$post->cover"
        class='w-25! aspect-video shrink-0 rounded-lg'
    />

    <div class="min-w-0">
        <x-exryze::ui.card-title>
            {{ $post->title }}
        </x-exryze::ui.card-title>
        
        <x-exryze::ui.card-timestamp :time="$post->published_at"/>
    </div>
</div>