@props([
    'title' => '',
    'label' => '',
    'icon' => '',
    'url' => '#',
])

<li class="flex gap-4 p-4 relative overflow-hidden rounded-2xl shadow-lg transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl group">
    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
        <i class="fa-solid fa-{{ $icon }} fa-xl"></i>
    </div>
    
    <div>
        <p class="text-sm font-medium text-muted-foreground">
            {{ $title }}
        </p>

        <a 
            href="{{ $url }}" 
            class="text-sm font-semibold text-foreground hover:text-primary transition-colors"
        >
            {{ $label }}
        </a>
    </div>
</li>
