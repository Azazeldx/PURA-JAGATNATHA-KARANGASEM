@props(['meta'])

<link rel="shortcut icon" href="{{
    Storage::disk('public')->exists($meta['favicon'] ?? 'placeholder.svg') 
        ? (Storage::disk('public')->url($meta['favicon'] ?? 'placeholder.svg')) 
        : asset('placeholder.svg')
}}">

<title>{{ $meta['title'] }}</title>

<meta name="description" content="{{ $meta['description'] }}">
<meta name="keywords" content="{{ implode(', ', $meta['keywords']) }}">

<link rel="canonical" href="{{ $meta['canonical'] }}">

{{-- Robots --}}
<meta name="robots" content="{{ 
    ($meta['robots']['index'] ? 'index' : 'noindex') . ',' .
    ($meta['robots']['follow'] ? 'follow' : 'nofollow') 
}}">

{{-- Open Graph --}}
<meta property="og:title" content="{{ $meta['og']['title'] }}">
<meta property="og:description" content="{{ $meta['og']['description'] }}">
<meta property="og:type" content="{{ $meta['og']['type'] }}">
<meta property="og:url" content="{{ $meta['canonical'] }}">
<meta property="og:image" content="{{ 
    Storage::disk('public')->exists($meta['og']['image'] ?? 'placeholder.svg') 
        ? (Storage::disk('public')->url($meta['og']['image'] ?? 'placeholder.svg')) 
        : asset('placeholder.svg')
}}">

{{-- Twitter --}}
<meta name="twitter:card" content="{{ $meta['twitter']['card'] }}">
<meta name="twitter:title" content="{{ $meta['twitter']['title'] }}">
<meta name="twitter:description" content="{{ $meta['twitter']['description'] }}">
<meta name="twitter:image" content="{{
    Storage::disk('public')->exists($meta['og']['image'] ?? 'placeholder.svg') 
        ? (Storage::disk('public')->url($meta['og']['image'] ?? 'placeholder.svg')) 
        : asset('placeholder.svg')
}}">