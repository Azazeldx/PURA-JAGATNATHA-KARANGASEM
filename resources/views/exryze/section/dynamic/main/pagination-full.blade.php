<section class="py-12 md:py-16">
    <div class="container mx-auto px-4 max-w-6xl">
        @php
            $configuredSkPdfUrl = $data['sk_pdf_url']
                ?? $data['download_pdf_url']
                ?? null;

            $uploadedSkPdfPath = $data['download_pdf_file'] ?? null;
            if (is_array($uploadedSkPdfPath)) {
                $uploadedSkPdfPath = $uploadedSkPdfPath[0] ?? null;
            }
            $uploadedSkPdfUrl = (!empty($uploadedSkPdfPath) && \Illuminate\Support\Facades\Storage::disk('public')->exists($uploadedSkPdfPath))
                ? asset('storage/' . ltrim($uploadedSkPdfPath, '/'))
                : null;

            $defaultSkPdfPath = 'static/other/sk-pengurus.pdf';
            $fallbackSkPdfUrl = \Illuminate\Support\Facades\Storage::disk('public')->exists($defaultSkPdfPath)
                ? asset('storage/' . $defaultSkPdfPath)
                : null;

            $publicSkPdfPath = 'sk-pengurus.pdf';
            $publicSkPdfUrl = file_exists(public_path($publicSkPdfPath))
                ? asset($publicSkPdfPath)
                : null;

            $skPdfUrl = $configuredSkPdfUrl ?: ($uploadedSkPdfUrl ?: ($fallbackSkPdfUrl ?: $publicSkPdfUrl));
            $sectionTitle = strtolower((string) ($data['title'] ?? ''));
            $showOrganizationSkAction = !empty($skPdfUrl)
                || str_contains($sectionTitle, 'organisasi')
                || str_contains($sectionTitle, 'pengurus');
        @endphp

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

        {{-- {{ dd($data) }} --}}
        @if ($data['posts']->hasPages())
            <div class="">
                {{ $data['posts']->links() }}
            </div>
        @endif

        @if ($showOrganizationSkAction)
            <div class="mt-6 flex justify-center">
                @if ($skPdfUrl)
                    <a
                        href="{{ $skPdfUrl }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 rounded-lg bg-primary px-5 py-3 text-sm font-semibold text-primary-foreground transition hover:opacity-90"
                    >
                        <i class="fa-solid fa-file-pdf"></i>
                        Download PDF SK Pengurus
                    </a>
                @else
                    <button
                        type="button"
                        disabled
                        class="inline-flex cursor-not-allowed items-center gap-2 rounded-lg bg-gray-300 px-5 py-3 text-sm font-semibold text-gray-700"
                    >
                        <i class="fa-solid fa-file-pdf"></i>
                        Download PDF SK Pengurus
                    </button>
                @endif
            </div>
        @endif
    </div>
</section>