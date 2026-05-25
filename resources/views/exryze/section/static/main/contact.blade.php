<section class="py-12 md:py-16">
    <div class="container mx-auto px-4 max-w-4xl">
        <h2 class="font-heading text-3xl md:text-4xl font-bold text-foreground mb-2">
        Hubungi Kami
        </h2>

        <p class="text-muted-foreground mb-10">
        Silakan hubungi kami melalui informasi di bawah atau kunjungi kantor kelurahan secara langsung.
        </p>

        <ul class="grid gap-4 sm:grid-cols-2 mb-12!">
            @if ($settings->get('contacts.email'))
                <x-exryze::card.contact 
                    title="Email"
                    label="{{ $settings->get('contacts.email') }}"
                    url="mailto:{{ $settings->get('contacts.email') }}"
                    icon="envelope"/>
            @endif
            @if ($settings->get('contacts.phone'))
                <x-exryze::card.contact 
                    title="Telepon"
                    label="{{ $settings->get('contacts.phone') }}"
                    url="tel:{{ $settings->get('contacts.phone') }}"
                    icon="phone"/>
            @endif
            @if ($settings->get('location.address'))
                <x-exryze::card.contact
                    title="Alamat"
                    label="{{ $settings->get('location.address') }}"
                    url="{{ $settings->get('location.url') }}"
                    icon="location-dot"/>
            @endif
        </ul>

        <div class="rounded-2xl shadow-2xl overflow-hidden">
            <iframe 
                src="https://maps.google.com/maps?q={{ $settings->get('location.coordinate.lat') }},{{ $settings->get('location.coordinate.lng') }}&output=embed"
                width="100%"
                height="350"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
            >
            </iframe>
        </div>
    </div>
</section>