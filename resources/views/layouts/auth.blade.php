<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
    <title>{{ $title ?? 'Bootcamp Laravel' }}</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">

    <!-- Extra CSS -->
    @stack('styles')
</head>
<body class="bg-light d-flex justify-content-center align-items-center min-vh-100 overflow-hidden">
    <main class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        {{-- Logo --}}
                        <div class="text-center mb-4">
                            <x-application-logo></x-application-logo>
                        </div>

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
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS Bundle -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    
    <!-- Extra JS -->
    @stack('scripts')
</body>
</html>
