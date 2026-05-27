<style>
    .hero-section {
        min-height: 85vh;
    }

    .logo {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #FFD700 0%, #FFA500 50%, #4169E1 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: white;
        font-size: 28px;
    }

    .nav-link {
        position: relative;
        transition: color 0.3s ease;
    }

    .nav-link:hover {
        color: #4169E1;
    }

    .nav-link.active {
        color: #4169E1;
    }

    .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: #4169E1;
    }

    @media (max-width: 768px) {
        .hero-section {
            min-height: 70vh;
        }
    }
</style>


<!-- Hero Section -->
<section id="home" class="hero-section flex items-center justify-start"
    style="background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('{{ Storage::url('assets/puraJagatnatha.webp') }}'); background-size: cover; background-position: center;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-4 py-20">
        <div class="max-w-2xl">
            <h2 class="mb-4 text-4xl font-semibold tracking-wider text-white md:text-5xl lg:text-6xl">
                VIRTUAL TOUR 360
            </h2>
            <h3 class="mb-6 text-2xl font-semibold text-white md:text-3xl lg:text-4xl">
                PURA JAGATNATHA KARANGASEM
            </h3>
            <a href="https://realitasvirtual.purajagatnathakarangasem.com/" target="_blank"
                class="inline-flex items-center justify-center gap-3 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm tracking-widest uppercase py-4 px-4 rounded-full transition-all duration-300 transform hover:-translate-y-1 hover:shadow-2xl hover:shadow-blue-600/40 shadow-xl">
                <i class="fas fa-vr-cardboard text-xl"></i>
                <span>MULAI TOUR SEKARANG</span>
            </a>
        </div>
    </div>
</section>


<script>
    // Toggle Mobile Menu
    function toggleMobileMenu() {
        const menu = document.getElementById('mobileMenu');
        menu.classList.toggle('hidden');
    }

    // Smooth scroll untuk navigation
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                // Only toggle menu if it exists
                const mobileMenu = document.getElementById('mobileMenu');
                if (mobileMenu) {
                    mobileMenu.classList.add('hidden');
                }
            }
        });
    });

    // Smooth scroll on page load
    window.addEventListener('load', function () {
        console.log('Website Fasilitas 360° Pura Jagatnatha Karangasem siap digunakan');
    });
</script>n>