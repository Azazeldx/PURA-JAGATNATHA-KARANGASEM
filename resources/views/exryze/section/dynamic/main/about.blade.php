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
                @php
                    $embedSrc = null;
                    if (!empty($data['profile_video'])) {
                        $url = $data['profile_video'];
                        if (preg_match('/youtu\.be\/([^\?&\/]+)/', $url, $m)) {
                            $id = $m[1];
                            $embedSrc = 'https://www.youtube.com/embed/' . $id;
                        } elseif (preg_match('/v=([^\?&\/]+)/', $url, $m)) {
                            $id = $m[1];
                            $embedSrc = 'https://www.youtube.com/embed/' . $id;
                        } elseif (preg_match('/embed\/([^\?&\/]+)/', $url, $m)) {
                            $id = $m[1];
                            $embedSrc = 'https://www.youtube.com/embed/' . $id;
                        } else {
                            $embedSrc = $url;
                        }
                    }
                @endphp

                @if ($embedSrc)
                    <div class="w-full h-72!">
                        <iframe
                            class="w-full h-full"
                            src="{{ $embedSrc }}"
                            title="YouTube video player"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen
                            loading="lazy"
                        ></iframe>
                    </div>
                @elseif(!empty($data['profile']))
                    <x-exryze::ui.image :image="$data['profile']" class='h-72!'/>
                @endif
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
                    <p class="text-xs text-muted-foreground mt-1">Berdiri Sejak</p>
                </div>
            </div>
            <div class="border-0 shadow-md rounded-2xl bg-background">
                <div class="p-5 text-center">
                    <p class="font-heading text-2xl font-bold text-primary">{{ $data['population'] }}</p>
                    <p class="text-xs text-muted-foreground mt-1">Rata-rata Pemedek</p>
                </div>
            </div>
            <div class="border-0 shadow-md rounded-2xl bg-background">
                <div class="p-5 text-center">
                    <p class="font-heading text-2xl font-bold text-primary">{{ $data['neighborhood'] }}</p>
                    <p class="text-xs text-muted-foreground mt-1">Jumlah Pemangku</p>
                </div>
            </div>
            <div class="border-0 shadow-md rounded-2xl bg-background">
                <div class="p-5 text-center">
                    <p class="font-heading text-2xl font-bold text-primary">{{ $data['family'] }}</p>
                    <p class="text-xs text-muted-foreground mt-1">Jadwal Piodalan</p>
                </div>
            </div>
        </div>
    </div>
</section>