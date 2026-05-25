<nav id="navigation" class="sticky top-0 z-50 py-4 bg-background transition-all">
    <div class="container mx-auto px-4 max-w-6xl flex flex-row items-center justify-between">
        
        <!-- Logo Section -->
        <a 
            href="/"
            class='flex items-center gap-2'
        >
            <x-exryze::ui.brand-logo/>

            <div class="hidden sm:block">
                <x-exryze::ui.brand-name/>
                <x-exryze::ui.brand-description/>
            </div>
        </a>

        <!-- Navigation items -->
        <ul 
            id="nav-items" 
            style="transition: all 150ms cubic-bezier(0.4, 0, 0.2, 1), max-height 1000ms cubic-bezier(0.4, 0, 0.2, 1), padding 1000ms cubic-bezier(0.4, 0, 0.2, 1);"
            class="absolute top-full left-0 right-0 max-h-0 px-4 flex flex-col items-end gap-1 bg-background border-b-2 overflow-y-auto no-scrollbar 
            md:relative md:top-0 md:w-fit md:max-h-fit md:p-0 md:flex-row md:items-center md:justify-center md:border-b-0
            md:overflow-visible">

            @if ($features->get('global.navigation.homepage') && $settings->get('navigation.home.show'))
                <x-exryze::ui.nav-item 
                    label="{{ $settings->get('navigation.home.label') }}"
                    slug="{{ $settings->get('navigation.home.page.slug') }}"/>
            @endif

            @foreach ($settings->get('navigation.nav_items') as $navItem)
                @if ($navItem['type'] == 'page')
                    <x-exryze::ui.nav-item
                        label="{{ $navItem['label'] }}"
                        slug="{{ $navItem['page']['slug'] }}"/>
                @else
                    <x-exryze::ui.nav-item 
                        label="{{ $navItem['label'] }}"
                        url="{{ $navItem['url'] }}"/>
                @endif
            @endforeach
        </ul>

        <!-- Search Form -->
            <a id="nav-menu" class="rounded-md cursor-pointer md:hidden">
                <i class="fa-solid fa-bars"></i>
            </a>
    </div>
</nav>

<script>
    // window.addEventListener('scroll', function() {
    //     const navigation = document.getElementById('navigation');
    //     const navItems = document.getElementById('nav-items');
    //     if (window.scrollY > 50) {
    //         navigation.classList.add('!bg-primary-500');
    //         navigation.classList.add('!text-white');
    //         navItems.classList.add('!bg-primary-500');
    //     } else {
    //         navigation.classList.remove('!bg-primary-500');
    //         navigation.classList.remove('!text-white');
    //         navItems.classList.remove('!bg-primary-500');
    //     }
    // });

    const navMenu = document.getElementById('nav-menu');
    navMenu.addEventListener('click', function() {
        const navItems = document.getElementById('nav-items');
        navItems.classList.toggle('py-0');
        navItems.classList.toggle('max-h-0');
        navItems.classList.toggle('py-4');
        navItems.classList.toggle('!max-h-[500px]');
    });
</script>
