<section id="{{ $data['id'] }}" class="py-12 md:py-16">
    <div class="container mx-auto px-4 max-w-6xl grid md:grid-cols-2 gap-8 items-center">
        <div class="flex flex-col gap-4">
            <x-exryze::ui.badge class='px-4!'>
                {{ $data['tagline'] }}
            </x-exryze::ui.badge>

            <h2 class="text-3xl md:text-4xl font-bold drop-shadow-xl">
                {{ $data['title'] }}
            </h2>

            <p class="text-muted-foreground leading-relaxed">
                {{ $data['description'] }}
            </p>

            <div>
                <h4 class="text-md md:text-lg font-semibold">
                    {{ $data['name'] }}
                </h4>

                <p class="text-xs text-muted-foreground">
                    {{ $data['position'] }}
                </p>
            </div>
        </div>

        <div class="flex justify-center">
            <x-exryze::ui.image :image="$data['profile']" class='w-64! h-80! rounded-2xl'/>
        </div>
    </div>
</section>