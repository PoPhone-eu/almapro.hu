<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @hasSection('title')
        <title>@yield('title') - {{ config('app.name') }}</title>
    @else
        <title>{{ config('app.name') }}</title>
    @endif
    <meta http-equiv=”refresh” content="{{ config('session.lifetime') * 60 }}">
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ url(asset('favicon.ico')) }}">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link href='https://cdn.jsdelivr.net/npm/source-sans-pro@3.6.0/source-sans-pro.min.css' rel='stylesheet'
        type='text/css'>
    <link href="https://fonts.cdnfonts.com/css/sue-ellen-francisco" rel="stylesheet">
    <link rel="stylesheet" href="/slider/splide-4.1.3/dist/css/splide.min.css">
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="/css/main.css?rnd=4" />
    <link rel="stylesheet" href="/css/social.css?rnd=2" />
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link href="/lightbox2/css/lightbox.css" rel="stylesheet" />
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-7BTKX83RRP"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-7BTKX83RRP');
    </script>
</head>

<body class="text-black">
    @include('layouts.main.mainlayout')
    <script>
        function notifySaved() {
            alert("Adatok mentve!!");
        }
    </script>
    <script src="/dist/js/app.js"></script>
    @livewireScripts
    @livewireScriptConfig
    <script src="https://unpkg.com/@nextapps-be/livewire-sortablejs@0.3.0/dist/livewire-sortable.js"></script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="/lightbox2/js/lightbox-plus-jquery.js"></script>
    <script src="/slider/splide-4.1.3/dist/js/splide.min.js"></script>

    <script>
        document.addEventListener('livewire:navigated', () => {
            var elms = document.getElementsByClassName('splide');
            if (elms) {
                for (var i = 0; i < elms.length; i++) {
                    console.log('splidebanner: ' + elms[i]);
                    new Splide(elms[i], {
                        type: 'loop',
                        perPage: 1,
                        arrows: false,
                        direction: 'ltr',
                        autoWidth: false,
                        perMove: 1,
                        pagination: false,
                        autoplay: true,
                        interval: 3000,
                        gap: '10px',
                        dragMinThreshold: {
                            mouse: 0,
                            touch: 10,
                        },
                    }).mount();
                }
            }

            get_slider = document.getElementById('productsplide');
            if (get_slider) {
                var productsplide = new Splide('#productsplide', {
                    type: 'slide',
                    direction: 'ttb',
                    perPage: 4,
                    perMove: 1,
                    height: '400px',
                    pagination: false,
                    autoplay: false,
                    gap: '10px',
                    dragMinThreshold: {
                        mouse: 0,
                        touch: 10,
                    },
                });
                productsplide.mount();
            }

        });
    </script>
</body>
{{-- <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script> --}}

</html>
