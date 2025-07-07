<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
    <title>{{ $title ?? 'Bootcamp Laravel' }}</title>

    <!-- Fonts (optional, masih dipertahankan) -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">

    <!-- Extra CSS -->
    @stack('styles')
</head>
<body>
    {{-- Aside Navigation --}}
    <x-aside></x-aside>

    {{-- Page Content --}}
    <main class="custom-main">
        <div class="p-5">
            {{-- Page Heading --}}
            @isset($header)
                <header class="bg-white shadow-sm py-3 mb-4 border-bottom">
                    {!! $header !!}
                </header>
            @endisset

            {{-- MESSAGE --}}
            @foreach (['success', 'errors', 'warning', 'info'] as $msg)
                @if(session($msg))
                    <div class="alert alert-{{ $msg == 'errors' ? 'danger' : $msg }} alert-dismissible fade show" role="alert">
                        {{ session($msg) }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            @endforeach

            {{-- Slot Content --}}
            {{ $slot }}
        </div>
    </main>

    <!-- Bootstrap JS Bundle -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    
    <!-- Extra JS -->
    @stack('scripts')
</body>
</html>
