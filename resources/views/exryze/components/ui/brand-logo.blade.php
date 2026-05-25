{{-- @if ($features->get('global.navigation.homepage'))
    <a href={{ route('exryze.page.dynamic', $settings->get('navigation.home.page.slug')) }}>
        <img class="w-12 lg:w-16! h-auto" src="{{ Storage::url($settings->get('site.logo')) }}" alt="{{ $settings->get('site.name') }}">
    </a>
@else
    <img class="w-12 lg:w-16! h-auto" src="{{ Storage::url($settings->get('site.logo')) }}" alt="{{ $settings->get('site.name') }}">
@endif --}}

@props([
    'class' => '',
])

<div 
    @class([
        "flex w-9 items-center justify-center",
        'hidden' => is_null($settings->get('site.logo')),
        $class
    ])
>
    <x-exryze::ui.image 
        url="{{
            Storage::disk('public')->exists($settings->get('site.logo') ?? '') 
                ? (Storage::disk('public')->url($settings->get('site.logo') ?? '')) 
                : '/placeholder.svg'
            }}"
        class="aspect-square"
    />
</div>