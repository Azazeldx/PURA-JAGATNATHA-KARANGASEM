<section class="py-12 md:py-16">
    {{-- <a href="/berita" class="inline-flex items-center gap-1 text-sm text-muted-foreground hover:text-primary mb-6">
        Kembali
    </a> --}}

    <article class="container mx-auto px-4 max-w-4xl">
        <x-exryze::ui.card-tags :tags="$post->tags"/>
    
        <h1 class="font-heading text-2xl md:text-3xl font-bold leading-tight mb-4">
            {{ $post->title }}
        </h1>
    
        <div class="flex flex-wrap items-center gap-4 text-sm text-muted-foreground mb-6">
            <span class="inline-flex items-center gap-1.5">
            <x-exryze::ui.avatar :user="$post->author"/>
            {{ $post->author->name }}
            </span>
            <span class="inline-flex items-center gap-1.5">
            <i class="fa-regular fa-calendar"></i>
            {{ \Carbon\Carbon::parse($post->published_at)->translatedFormat('j F Y') }}
            </span>
        </div>
    
        <x-exryze::ui.image :image="$post->cover" class='aspect-video rounded-2xl mb-6'/>
    
        <div class="prose max-w-none">
            {{ \Filament\Forms\Components\RichEditor\RichContentRenderer::make($post->content) }}
        </div>
    </article>
</section>