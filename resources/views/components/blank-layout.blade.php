<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="manifest" href="/manifest.json?v=2">
        <meta name="theme-color" content="#1c1c1e">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

        <title>{{ config('app.name', 'ZCal') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <script src="https://unpkg.com/lucide@latest"></script>
        <link rel="icon" href="{{ asset('images/icon/icon-uang-masuk.png') }}?v=2" type="image/png">
        <link rel="apple-touch-icon" href="{{ asset('images/icon/icon-uang-masuk.png') }}?v=2">
        <meta name="apple-mobile-web-app-title" content="ZCal">
    </head>
    <body class="antialiased bg-gray-50 overflow-hidden h-[100dvh] w-full fixed inset-0 touch-none overscroll-none">
        
        <!-- Main Content Area -->
        <main class="h-full w-full overflow-hidden flex flex-col relative">
            {{ $slot }}
        </main>

        <script>
            lucide.createIcons();
        </script>
        <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', () => {
                    navigator.serviceWorker.register('/sw.js').then(registration => {
                        console.log('ServiceWorker registration successful with scope: ', registration.scope);
                    }).catch(error => {
                        console.log('ServiceWorker registration failed: ', error);
                    });
                });
            }
        </script>
    </body>
</html>
