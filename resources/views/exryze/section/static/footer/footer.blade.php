<footer class="py-8 md:py-12 bg-background" data-aos="fade-up">
    <div class="container mx-auto px-4 max-w-6xl grid grid-cols-1 gap-8 md:grid-cols-3 lg:grid-cols-4">

        <!-- Logo Section -->
        <div class="md:col-span-3 lg:col-span-1">
            <a href="{{ $features->get('global.navigation.homepage') ?? false
                ? route('exryze.page.dynamic', $settings->get('navigation.home.page.slug'))
                : '/' }}"
                class='flex flex-col gap-4 h-fit md:items-center md:text-center'>
                <x-exryze::ui.brand-logo class='w-20!' />

                <div class="">
                    <x-exryze::ui.brand-name class='text-4xl!' />
                    <x-exryze::ui.brand-description class='text-sm!' />
                </div>
            </a>
        </div>

        <!-- Discover Section -->
        <div class="">
            <h3 class="text-xl md:text-2xl font-bold mb-4">Navigasi</h3>
            <ul class="flex flex-col space-y-2">
                @if ($features->get('global.navigation.homepage') && $settings->get('navigation.home.show'))
                    <x-exryze::ui.footer-nav-item label="{{ $settings->get('navigation.home.label') }}"
                        slug="{{ $settings->get('navigation.home.page.slug') }}" />
                @endif

                @foreach ($settings->get('navigation.nav_items') as $navItem)
                    @if ($navItem['type'] == 'page')
                        <x-exryze::ui.footer-nav-item label="{{ $navItem['label'] }}"
                            slug="{{ $navItem['page']['slug'] }}" />
                    @else
                        <x-exryze::ui.footer-nav-item label="{{ $navItem['label'] }}" url="{{ $navItem['url'] }}" />
                    @endif
                @endforeach
            </ul>
        </div>

        <div class="flex flex-col gap-4">
            <!-- For Businesses Section -->
            <div class="">
                <h3 class="text-xl md:text-2xl font-bold mb-4">Kontak</h3>
                <ul class="flex flex-col space-y-2">
                    @if ($settings->get('contacts.email'))
                        <x-exryze::ui.footer-nav-item label="{{ $settings->get('contacts.email') }}"
                            url="mailto:{{ $settings->get('contacts.email') }}" />
                    @endif
                    @if ($settings->get('contacts.phone'))
                        <x-exryze::ui.footer-nav-item label="{{ $settings->get('contacts.phone') }}"
                            url="tel:{{ $settings->get('contacts.phone') }}" />
                    @endif
                    @if ($settings->get('location.address'))
                        <x-exryze::ui.footer-nav-item label="{{ $settings->get('location.address') }}"
                            url="{{ $settings->get('location.url') }}" />
                    @endif
                </ul>
            </div>

            <!-- Available On Section -->
            <div class="">
                <h3 class="text-xl md:text-2xl font-bold mb-4">Social Media</h3>
                <ul class="flex gap-3">
                    @foreach ($settings->get('social_network') as $icon => $data)
                        @if ($data['url'])
                            <x-exryze::ui.social-network title="{{ $data['label'] }}" url="{{ $data['url'] }}"
                                icon="{{ $icon }}" />
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="flex flex-col h-fit md:items-center md:text-center">
            <h3 class="text-xl md:text-2xl font-bold mb-2">Kerjasama</h3>
            <p class="text-sm text-muted-foreground leading-tight mb-4">
                Bekerja sama dengan,
            </p>
            <div class="flex gap-4 mb-4">
                <x-exryze::ui.image :url="asset('politeknik-negeri-bali.png')" class="aspect-square w-16!" />
                <x-exryze::ui.image :url="asset('jurusan-teknologi-informasi.png')" class="aspect-square w-16!" />
            </div>
            <h4 class="text-sm md:text-md font-bold mb-2">
                Jurusan Teknologi Informasi <br />
                Politeknik Negeri Bali
            </h4>
        </div>

        <!-- Footer Bottom Section -->
        <div
            class="col-span-full flex flex-col items-start justify-center pt-4 border-t border-gray-300 md:items-center">
            <p class="text-sm text-gray-600">Copyright © {{ date('Y') }} - {{ $settings->get('site.name') }}</p>
        </div>
    </div>
</footer>
