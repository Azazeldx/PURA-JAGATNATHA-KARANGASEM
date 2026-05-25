@props([
    'post' => []
])

<div 
    x-data="{ open: false, img: '' }"
    class="relative col-span-1 group"
>
    <div class="relative overflow-hidden rounded-2xl shadow-lg transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl">
        <x-exryze::ui.image 
            :image="$post->cover" 
            class="aspect-video cursor-pointer"
            @click="img = $el.src; open = true"
        />
    </div>

    <!-- Modal -->
    <div 
        x-show="open" 
        x-transition
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/80"
        @click="open = false"
    >
        <img 
            :src="img" 
            class="max-w-[90vw] max-h-[90vh] rounded-lg shadow-2xl"
        />
    </div>
</div>