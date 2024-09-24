<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    {{--  <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    @hasSection('title')
        <title>@yield('title') - {{ config('app.name') }}</title>
    @else
        <title>{{ config('app.name') }}</title>
    @endif

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ url(asset('favicon.ico')) }}">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <script src="https://kit.fontawesome.com/dfb526c52f.js" crossorigin="anonymous"></script>

    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="/dist/css/app.css" />
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        .error {
            color: red;
            font-weight: 700;
        }

        .ql-container {
            height: 350px !important;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="py-5 md:py-0">
    @yield('maincontent')
    <script src="/dist/js/app.js"></script>
    @livewireScripts
    @livewireScriptConfig
    <script src="https://unpkg.com/@nextapps-be/livewire-sortablejs@0.3.0/dist/livewire-sortable.js"></script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
</body>
{{-- <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script> --}}

</html>
