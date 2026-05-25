<section class="py-12 md:py-16">
    <div class='container mx-auto px-4 max-w-6xl'>
        <div class="flex flex-col gap-2 items-center mb-4">
            <x-exryze::ui.badge class='px-4!'>
                Hierarki Pemerintahan
            </x-exryze::ui.badge>

            <h2 class="text-3xl md:text-4xl font-bold drop-shadow-xl">
                Bagan Organisasi
            </h2>

            <p class="text-muted-foreground text-center leading-relaxed max-w-2xl mx-auto">
                Susunan tata kerja aparatur pemerintah PURA JAGATNATHA KARANGASEM guna mewujudkan alur pelayanan publik yang terstruktur, cepat, dan optimal.
            </p>
        </div>

        <div class="relative bg-white p-4 md:p-8 rounded-3xl shadow-lg border border-gray-100 flex justify-center items-center overflow-hidden group">
            
            <img 
                src="{{ Storage::url('static/other/struktur-organisasi.webp') }}" 
                alt="Bagan Struktur Organisasi PURA JAGATNATHA KARANGASEM" 
                class="w-full h-auto max-w-5xl object-contain rounded-xl transition-transform duration-500 group-hover:scale-105 cursor-zoom-in drop-shadow-sm"
                onclick="window.open(this.src, '_blank')"
                title="Klik untuk melihat ukuran penuh"
            >
            
            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none rounded-3xl">
                <span class="bg-white text-[#3b4279] px-6 py-3 rounded-full font-bold shadow-lg flex items-center gap-2 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                    <i class="fa-solid fa-magnifying-glass-plus"></i> Klik untuk Perbesar
                </span>
            </div>
        </div>
        
        <p class="text-center text-sm text-gray-500 mt-5 italic">
            *Klik pada gambar untuk membuka bagan dalam ukuran penuh.
        </p>
    </div>
</section>