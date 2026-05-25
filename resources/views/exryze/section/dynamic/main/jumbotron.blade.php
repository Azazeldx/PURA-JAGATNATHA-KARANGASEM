<section id="{{ $data['id'] }}" class="relative py-12 md:py-16 w-full min-h-75 h-[40vh] md:h-[50vh] lg:h-[60vh] overflow-hidden">
    
    {{-- Gambar Background --}}
    <x-exryze::ui.image :image="$data['background']" class='absolute inset-0 object-cover w-full h-full object-center z-0 scale-105 transform hover:scale-100 transition-transform duration-[10s] ease-in-out'/>

    {{-- Overlay Gelap (Shadow) Hitam --}}
    <div class="absolute inset-0 bg-black/50 z-10"></div>

    {{-- Konten Teks Tengah --}}
    <div class="container mx-auto px-4 max-w-6xl absolute inset-0 z-20 flex gap-4 flex-col items-center justify-center text-center">
        
        {{-- Tagline --}}
        <x-exryze::ui.badge 
            class='px-4! text-sm! shadow-sm! bg-muted/10! text-muted! border-muted/20!' 
            data-aos="fade-down" data-aos-duration="800"
        >
            {{ $data['tagline'] }}
        </x-exryze::ui.badge>

        {{-- Judul Utama --}}
        <h1 
            class="text-5xl md:text-6xl font-extrabold text-primary-foreground drop-shadow-2xl" 
            data-aos="zoom-in" data-aos-duration="1000"
        >
            {{ $data['title'] }}
        </h1>
        
        {{-- Garis Pemisah --}}
        <div 
            class="w-24 h-1.5 bg-muted/50 rounded-full"
            data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200"
        ></div>

        {{-- Deskripsi Pendek --}}
        <p 
            class="text-lg md:text-xl text-muted leading-relaxed" 
            data-aos="fade-up" data-aos-duration="1200" data-aos-delay="400"
        >
            {{ $data['paragraph'] }}
        </p>
    </div>
</section>