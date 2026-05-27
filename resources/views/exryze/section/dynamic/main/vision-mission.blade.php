<section id="{{ $data['id'] ?? 'vision-mission' }}" class="py-12 md:py-16">
    <div class="container mx-auto px-4 max-w-6xl">
        <div class="flex flex-col items-center gap-3 mb-8">
            <div class="flex items-center gap-3">
                <!-- small balinese motif -->
                <svg class="w-8 h-8 text-primary" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden>
                    <path d="M12 2C13.1046 2 14 2.89543 14 4C14 5.10457 13.1046 6 12 6C10.8954 6 10 5.10457 10 4C10 2.89543 10.8954 2 12 2Z" fill="currentColor" opacity="0.95"/>
                    <path d="M6 8C8 9.5 10 11 12 13C14 11 16 9.5 18 8C16.5 10.5 13.5 13 12 14C10 13 7.5 10.5 6 8Z" fill="currentColor" opacity="0.8"/>
                </svg>
                <h2 class="text-3xl md:text-4xl font-bold text-primary">{{ $data['title'] ?? 'Visi & Misi' }}</h2>
            </div>
            @if(!empty($data['subtitle']))
                <p class="text-muted-foreground text-center max-w-2xl">{{ $data['subtitle'] }}</p>
            @endif
        </div>

        @php
            $hasVisionsKey = array_key_exists('visions', $data);
            $visions = $data['visions'] ?? [];
            if (!is_array($visions)) {
                $visions = [];
            }

            $visions = array_values(array_filter(array_map(function ($vision) {
                if (is_array($vision)) {
                    $vision = data_get($vision, 'text');
                } elseif (is_object($vision)) {
                    $vision = data_get((array) $vision, 'text');
                }

                if (is_null($vision)) {
                    return null;
                }

                if (is_scalar($vision)) {
                    return trim((string) $vision);
                }

                return null;
            }, $visions), fn ($vision) => !empty($vision)));

            // Only use legacy fallback text when the visions key does not
            // exist yet (old data shape). If user intentionally clears all
            // visions in Filament, keep it empty.
            if (!$hasVisionsKey && empty($visions)) {
                $visions = [
                    $data['vision_text'] ?? 'Menjadi pusat kebudayaan Bali yang berorientasi pada pelestarian tradisi dan pelayanan masyarakat modern.',
                ];
            }

            $missions = $data['missions'] ?? [
                $data['missions_0'] ?? 'Melestarikan tradisi adat dan seni budaya lokal.',
                $data['missions_1'] ?? 'Meningkatkan partisipasi masyarakat dalam kegiatan kebudayaan.',
                $data['missions_2'] ?? 'Membangun fasilitas yang ramah budaya dan lingkungan.',
            ];

            if (!is_array($missions)) {
                $missions = [];
            }

            $missions = array_values(array_filter(array_map(function ($mission) {
                if (is_array($mission)) {
                    $mission = data_get($mission, 'text');
                } elseif (is_object($mission)) {
                    $mission = data_get((array) $mission, 'text');
                }

                if (is_null($mission)) {
                    return null;
                }

                if (is_scalar($mission)) {
                    return trim((string) $mission);
                }

                return null;
            }, $missions), fn ($mission) => !empty($mission)));
        @endphp

        <div class="grid md:grid-cols-2 gap-6 items-stretch">
            <div class="rounded-3xl p-6 md:p-8 bg-background shadow-md border border-border">
                <div class="flex items-center gap-3 mb-4">
                    <span class="inline-flex items-center rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-primary">Visi</span>
                    <span class="h-px flex-1 bg-border"></span>
                </div>
                <h3 class="text-2xl font-semibold text-primary">
                    {{ $data['vision_title'] ?? 'Visi' }}
                </h3>

                <div class="mt-4 space-y-3">
                    @foreach($visions as $vision)
                        <div class="rounded-2xl border border-border/60 bg-background/70 p-4">
                            <p class="text-sm md:text-base leading-7 text-muted-foreground">{{ $vision }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 rounded-2xl border border-border/70 bg-primary/5 p-4">
                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M12 2C13 5 16 7 19 8C16 9 13 11 12 14C11 11 8 9 5 8C8 7 11 5 12 2Z" fill="currentColor"/>
                                <path d="M12 10C13 12 15 14 18 15C15 16 13 18 12 21C11 18 9 16 6 15C9 14 11 12 12 10Z" fill="currentColor" opacity="0.7"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-primary">Makna Visi</div>
                            <p class="mt-1 text-sm text-muted-foreground">Bagian ini menunjukkan arah besar dan cita-cita utama yang ingin dicapai.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl p-6 md:p-8 bg-background shadow-md border border-border">
                <div class="flex items-center gap-3 mb-4">
                    <span class="inline-flex items-center rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-primary">Misi</span>
                    <span class="h-px flex-1 bg-border"></span>
                </div>

                <h3 class="text-2xl font-semibold text-primary">
                    {{ $data['mission_title'] ?? 'Langkah Kerja Utama' }}
                </h3>

                <div class="mt-5 space-y-3">
                    @foreach($missions as $mission)
                        @if(!empty($mission))
                            <div class="rounded-2xl border border-border/70 bg-white/5 p-4">
                                <div class="flex items-start gap-4">
                                    <div class="flex-none w-11 h-11 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold">
                                        {{ $loop->iteration }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-xs font-semibold uppercase tracking-[0.2em] text-primary">Misi {{ $loop->iteration }}</div>
                                        <p class="mt-2 text-sm md:text-base leading-7 text-muted-foreground">{{ $mission }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="mt-6 rounded-2xl overflow-hidden border border-border bg-primary/5 p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M12 3L3 9h2v7h4v-4h6v4h4V9h2L12 3z" fill="currentColor"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-primary">Khas Bali</h4>
                            <p class="text-sm text-muted-foreground">Ornamen dan warna dibuat tetap lembut, tapi masing-masing bagian kini punya identitas yang jelas.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
