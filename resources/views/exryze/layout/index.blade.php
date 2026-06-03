<!DOCTYPE html>
{{-- <html lang="id"> --}}

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <x-exryze::head.metadata :meta="$meta"/>

    {{-- CDN --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    {{-- <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" /> --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    {{-- Styles --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased text-gray-900 wrap-break-word">
    @php
        $isAsideOne = !(isset($regions['aside_left']) == isset($regions['aside_right']));
        $isAsideBoth = (isset($regions['aside_left']) && isset($regions['aside_right']));
    @endphp

    @foreach ($schema as $region => $enable)
        @if (!$enable)
            @continue
        @endif

        @switch($region)
            @case('main')
                <main @class([
                    'container mx-auto px-4 max-w-6xl [&>section]:lg:col-span-2' => !is_null($post), // Only for post page, need to improvement
                    'grid grid-cols-1 lg:grid-cols-3 gap-10' => $isAsideOne,
                    'grid grid-cols-1 lg:grid-cols-4 gap-10' => $isAsideBoth,
                ])>
                    @if (isset($regions['aside_left']))
                        @php
                            $data = data_get($content, 'aside_left');
                        @endphp

                        @includeIf('exryze.section.' . data_get($regions['aside_left']->section_schema, 'view_path'))
                    @endif
                    
                    @if (!is_null($post))
                        <x-exryze::layout.post-detail :post="$post"/>
                    @endif

                    @if (isset($regions['main']))
                        @foreach ($regions['main'] as $section => $config)
                            @php
                                $data = data_get($content, 'main.' . $section);
                            @endphp

                            @includeIf('exryze.section.' . data_get($config, 'view_path'))
                        @endforeach
                    @endif

                    @if (isset($regions['aside_right']))
                        @php
                            $data = data_get($content, 'aside_right');
                        @endphp

                        @includeIf('exryze.section.' . data_get($regions['aside_right']->section_schema, 'view_path'))
                    @endif
                </main>
                @break
        
            @default
                @if ($region == 'aside')
                    @break
                @endif

                @if (isset($regions[$region]))
                    @php
                        $data = data_get($content, $region);
                    @endphp

                    @includeIf('exryze.section.' . data_get($regions[$region]->section_schema, 'view_path'))
                @endif
                @break
                
        @endswitch
    @endforeach

    <script src="https://kit.fontawesome.com/f87eaab4e6.js" crossorigin="anonymous"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script> --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            AOS.init({
                once: true
            });
        });
    </script>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'id',
                includedLanguages: 'ar,zh-CN,zh-TW,en,fr,hi,id,ja,ko',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
            }, 'google_translate_element');
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <style>
        .VIpgJd-ZVi9od-ORHb-OEVmcd,
        .goog-te-banner-frame {
            display: none !important;
        }

        body {
            top: 0px !important;
        }

        /* Override Tailwind's base img reset which breaks Google Translate layout */
        #google_translate_element img {
            display: inline !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        /* Style the widget to fit nicely into the navigation bar */
        .goog-te-gadget-simple {
            background-color: #ffffff !important;
            border: 1px solid #d1d5db !important;
            border-radius: 9999px !important;
            padding: 6px 16px !important;
            display: inline-flex !important;
            align-items: center !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
        }

        .goog-te-menu-value {
            display: inline-flex !important;
            align-items: center !important;
            color: #374151 !important;
            text-decoration: none !important;
            font-size: 14px !important;
            font-family: inherit !important;
            gap: 6px !important;
        }

        /* Remove the ugly vertical bar separator */
        .goog-te-menu-value span[style*="border-left"] {
            display: none !important;
        }
        
        .goog-te-menu-value span[aria-hidden="true"] {
            font-size: 10px !important;
            color: #9ca3af !important;
        }
    </style>
</body>

</html>
