@props([
    'post' => []
])

<div class="relative overflow-hidden col-span-1 rounded-2xl shadow-lg transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl group">

    <a 
        href="{{ Route::has('exryze.post.detail') ? 
            route('exryze.post.detail', [
                'type' => $post->type->slug, 
                'slug' => $post->slug]) 
            : '#'}}"
        class="absolute inset-0 z-10"
    >
    </a>

    <x-exryze::ui.image :image="$post->cover" class='aspect-video'/>

    <div class="p-4 flex flex-col h-fit">
        <x-exryze::ui.card-tags :tags="$post->tags"/>

        <x-exryze::ui.card-title>
            {{ $post->title }}
        </x-exryze::ui.card-title>
        
        <x-exryze::ui.card-timestamp :time="$post->published_at"/>

        <x-exryze::ui.card-description>
            {{ $post->description }}
        </x-exryze::ui.card-description>

        <x-exryze::ui.card-cta-link
            href="{{ Route::has('exryze.post.detail') ? 
            route('exryze.post.detail', [
                'type' => $post->type->slug, 
                'slug' => $post->slug]) 
            : '#'}}"
        >
            Selengkapnya →
        </x-exryze::ui.card-cta-link>
    </div>

</div>