@props([
    'post' => []
])
{{-- {{ dd($post) }} --}}
<div class="relative flex flex-col overflow-hidden col-span-1 rounded-2xl shadow-lg transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl group">

    <a 
        href="{{ Route::has('exryze.post.detail') ? 
            route('exryze.post.detail', [
                'type' => $post->type->slug, 
                'slug' => $post->slug]) 
            : '#'}}" 
        class="absolute inset-0 z-10"
    >
    </a>

    <x-exryze::ui.image :image="$post->cover" class='aspect-square'/>

    <div class="flex flex-col grow p-4">
        <x-exryze::ui.card-tags :tags="$post->tags"/>
        
        <x-exryze::ui.card-title>
            {{ $post->title }}
        </x-exryze::ui.card-title>

        <x-exryze::ui.card-description>
            {{ $post->description }}
        </x-exryze::ui.card-description>

        <p class="font-heading font-bold text-primary text-lg">
            {{ $post->card_content['section']['rentang_harga'] ?? null }}
        </p>

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