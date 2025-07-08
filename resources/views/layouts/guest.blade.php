<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
        <title>{{ $title ?? 'Bootcamp Laravel' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">

        <!-- Extra CSS -->
        @stack('styles')
    </head>
    <body class="font-sans text-gray-900 antialiased d-flex flex-column min-vh-100">
        <x-navbar-home></x-navbar-home>

        <main class="flex-grow-1">
            <section class="p-5">
                {{ $slot }}
            </section>
        </main>

        <x-footer-home></x-footer-home>
        
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    
        <!-- Extra JS -->
        @stack('scripts')
    </body>
</html>
