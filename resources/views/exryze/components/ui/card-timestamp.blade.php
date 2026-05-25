@props([
    'time' => ''
])

<span class="text-xs text-muted-foreground mb-2">
    {{ \Carbon\Carbon::parse($time)->diffForHumans() }}
</span>