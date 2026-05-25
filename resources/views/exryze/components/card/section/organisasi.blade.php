@props([
    'post' => []
])

<div class="relative overflow-hidden col-span-1 rounded-2xl shadow-lg transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl group">
    <div class="flex flex-col items-center text-center p-6">
        <x-exryze::ui.image :image="$post->cover" class='w-24! h-24! rounded-full mb-4 ring-4 ring-primary/50'/>

        <x-exryze::ui.card-title>
            {{ $post->title }}
        </x-exryze::ui.card-title>

        <x-exryze::ui.card-description>
            {{ $post->description }}
        </x-exryze::ui.card-description>
    </div>
</div>