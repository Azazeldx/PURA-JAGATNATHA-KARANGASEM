<div class="relative w-full h-[40vh] min-h-75 md:h-[50vh] lg:h-[60vh] overflow-hidden">
    
    {{-- Gambar Background --}}
    <img 
        src="{{ Storage::url($data['background']) ?? '/placeholder.svg' }}" 
        class="absolute inset-0 object-cover w-full h-full object-center z-0 scale-105 transform hover:scale-100 transition-transform duration-[10s] ease-in-out" 
        alt="Kantor PURA JAGATNATHA KARANGASEM"
    >
    {{-- <x-curator-curation 
        :media="$data['background']" 
    />     --}}
    {{-- Overlay Gelap (Shadow) Hitam --}}
    <div class="absolute inset-0 bg-black/65 z-10"></div>

    {{-- Ornamen Tambahan --}}
    <div class="absolute inset-0 z-10 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0IiBoZWlnaHQ9IjQiPgo8cmVjdCB3aWR0aD0iNCIgaGVpZ2h0PSI0IiBmaWxsPSIjZmZmIiBmaWxsLW9wYWNpdHk9IjAuMDUiLz4KPC9zdmc+')] opacity-20"></div>

    {{-- Konten Teks Tengah --}}
    <div class="absolute inset-0 z-20 flex flex-col items-center justify-center px-6 text-center text-white">
        
        {{-- Tagline --}}
        <div 
            class="mb-4 inline-block px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-sm font-semibold tracking-widest uppercase text-gray-200"
            data-aos="fade-down" data-aos-duration="800"
        >
            {{ $data['tagline'] }}
        </div>

        {{-- Judul Utama --}}
        <h1 
            class="mb-4 text-5xl font-extrabold md:text-6xl lg:text-7xl drop-shadow-2xl tracking-tight" 
            data-aos="zoom-in" data-aos-duration="1000"
        >
            {{ $data['title'] }}
        </h1>
        
        {{-- Garis Pemisah --}}
        <div 
            class="w-24 h-1.5 bg-white/40 mb-6 rounded-full"
            data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200"
        ></div>

        {{-- Deskripsi Pendek --}}
        <p 
            class="max-w-2xl text-lg font-normal md:text-xl lg:text-2xl drop-shadow-lg text-gray-100" 
            data-aos="fade-up" data-aos-duration="1200" data-aos-delay="400"
        >
            {{ $data['paragraph'] }}
        </p>
    </div>
</div>