<section class="py-12 md:py-16">
    <div class="container mx-auto px-4 max-w-6xl">
        <h1 class="font-heading text-3xl md:text-4xl font-bold text-foreground mb-2">
        {{ $data['title'] ?? 'Title' }}
        </h1>

        <p class="text-muted-foreground mb-10">
        {{ $data['description'] ?? 'Description' }}
        </p>

        <div class="grid grid-cols-2 mb-4 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-4">
            @if ($data['posts']->isEmpty())
                <p class="col-span-full text-lg text-center">Hasil tidak ditemukan</p>
            @else
                @foreach ($data['posts'] as $post)
                    <x-dynamic-component 
                        :component="$post->type->card_schema['section']['view_path']"
                        :post="$post"
                    />
                @endforeach
            @endif
        </div>
    </div>
</section>