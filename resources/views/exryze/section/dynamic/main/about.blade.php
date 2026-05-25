<section id="{{ $data['id'] }}" class="py-12 md:py-16">
    <div class='container mx-auto px-4 max-w-6xl'>
        <div class="flex flex-col gap-2 items-center mb-4">
            <x-exryze::ui.badge class='px-4!'>
                {{ $data['badge'] }}
            </x-exryze::ui.badge>

            <h2 class="text-3xl md:text-4xl font-bold drop-shadow-xl">
                {{ $data['title'] }}
            </h2>

            <p class="text-muted-foreground text-center leading-relaxed max-w-2xl mx-auto">
                {{ $data['description'] }}
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 items-center mb-10">
            <div class="rounded-2xl overflow-hidden shadow-sm">
                <x-exryze::ui.image :image="$data['profile']" class='h-72!'/>
            </div>

            <div class='flex flex-col gap-4'>
                <h3 class="text-xl md:text-2xl font-bold drop-shadow-lg">
                    {{ $data['sub-heading'] }}
                </h3>

                <p class="text-muted-foreground leading-relaxed mb-3 text-sm">
                    {{ $data['sub-description'] }}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <div class="border-0 shadow-md rounded-2xl bg-background">
                <div class="p-5 text-center">
                    <p class="font-heading text-2xl font-bold text-primary">{{ $data['area'] }}</p>
                    <p class="text-xs text-muted-foreground mt-1">Luas Wilayah</p>
                </div>
            </div>
            <div class="border-0 shadow-md rounded-2xl bg-background">
                <div class="p-5 text-center">
                    <p class="font-heading text-2xl font-bold text-primary">{{ $data['population'] }}</p>
                    <p class="text-xs text-muted-foreground mt-1">Jumlah Penduduk</p>
                </div>
            </div>
            <div class="border-0 shadow-md rounded-2xl bg-background">
                <div class="p-5 text-center">
                    <p class="font-heading text-2xl font-bold text-primary">{{ $data['neighborhood'] }}</p>
                    <p class="text-xs text-muted-foreground mt-1">Lingkungan / RT</p>
                </div>
            </div>
            <div class="border-0 shadow-md rounded-2xl bg-background">
                <div class="p-5 text-center">
                    <p class="font-heading text-2xl font-bold text-primary">{{ $data['family'] }}</p>
                    <p class="text-xs text-muted-foreground mt-1">Kepala Keluarga</p>
                </div>
            </div>
        </div>
    </div>
</section>