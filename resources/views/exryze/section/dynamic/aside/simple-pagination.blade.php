<aside class="relative lg:col-span-1">
    <div class="sticky top-24 rounded-2xl p-4 shadow-xl">

        <h2 class="font-heading text-lg font-bold mb-4">
            {{ $data['title'] }}
        </h2>

        <div class="space-y-4 grid grid-cols-1">
            @if ($data['posts']->isEmpty())
                <p class="col-span-full text-sm text-center">Hasil tidak ditemukan</p>
            @else
                @foreach ($data['posts'] as $post)
                    <x-dynamic-component 
                        :component="$post->type->card_schema['aside']['view_path'] ?? 'exryze::card.fallback'"
                        :post="$post"
                    />
                @endforeach
            @endif
        </div>

        {{-- {{ dd($data) }} --}}
        @if ($data['posts']->hasPages())
            <div class="mt-4">
                {{ $data['posts']->links() }}
            </div>
        @endif
    </div>
</aside>