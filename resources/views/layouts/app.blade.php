<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- PWA Meta Tags -->
        <link rel="manifest" href="/manifest.json?v=2">
        <meta name="theme-color" content="#1c1c1e">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

        <title>{{ config('app.name', 'ZCal') }}</title>

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Icons (Lucide) -->
        <script src="https://unpkg.com/lucide@latest"></script>
        <link rel="icon" href="{{ asset('images/icon/icon-uang-masuk.png') }}?v=2" type="image/png">
        <link rel="apple-touch-icon" href="{{ asset('images/icon/icon-uang-masuk.png') }}?v=2">
        <meta name="apple-mobile-web-app-title" content="ZCal">
    </head>
    <body class="antialiased bg-gray-50 overflow-hidden h-[100dvh] w-full fixed inset-0 touch-none overscroll-none">
        <!-- Desktop Sidebar -->
        <aside class="sidebar hidden lg:flex">
            <div class="sidebar-logo">
                <img src="{{ asset('images/icon/icon-uang-masuk.png') }}" class="w-8 h-8 object-contain drop-shadow-sm" alt="Logo">
                <span class="font-bold text-lg">ZCal</span>
            </div>
            
            <nav class="sidebar-nav">
                <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <img src="{{ asset('images/navbar-icon/ic-nav-home.png') }}" class="w-6 h-6 object-contain" alt="Beranda">
                    Beranda
                </a>
                <a href="{{ route('keuangan.index') }}" class="sidebar-link {{ request()->routeIs('keuangan.*') ? 'active-finance' : '' }}">
                    <img src="{{ asset('images/navbar-icon/ic-nav-dompet.png') }}" class="w-6 h-6 object-contain" alt="Keuangan">
                    Keuangan
                </a>
                <a href="{{ route('kalori.index') }}" class="sidebar-link {{ request()->routeIs('kalori.*') ? 'active-nutrition' : '' }}">
                    <img src="{{ asset('images/navbar-icon/ic-nav-kalori.png') }}" class="w-6 h-6 object-contain" alt="Kalori">
                    Kalori
                </a>
                <a href="{{ route('profile.edit') }}" class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <img src="{{ asset('images/navbar-icon/ic-nav-lainnya.png') }}" class="w-6 h-6 object-contain" alt="Lainnya">
                    Lainnya
                </a>
            </nav>

            <button onclick="openAddModal()" class="sidebar-add-btn">
                <i data-lucide="plus" class="w-5 h-5"></i>
                Catat Baru
            </button>

            <div class="sidebar-user">
                <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-sm font-medium">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</p>
                </div>
            </div>
        </aside>

        <!-- Mobile Bottom Bar -->
        <nav class="bottom-bar">
            <a href="{{ route('dashboard') }}" class="bottom-bar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <img src="{{ asset('images/navbar-icon/ic-nav-home.png') }}" class="w-7 h-7 object-contain mb-1" alt="Beranda">
                <span>Beranda</span>
            </a>
            <a href="{{ route('keuangan.index') }}" class="bottom-bar-item {{ request()->routeIs('keuangan.*') ? 'text-blue-600' : '' }}">
                <img src="{{ asset('images/navbar-icon/ic-nav-dompet.png') }}" class="w-7 h-7 object-contain mb-1" alt="Keuangan">
                <span>Keuangan</span>
            </a>
            
            <button onclick="openAddModal()" class="relative -top-5 flex flex-col items-center">
                <div class="bottom-bar-fab">
                    <i data-lucide="plus" class="w-6 h-6"></i>
                </div>
            </button>

            <a href="{{ route('kalori.index') }}" class="bottom-bar-item {{ request()->routeIs('kalori.*') ? 'text-green-600' : '' }}">
                <img src="{{ asset('images/navbar-icon/ic-nav-kalori.png') }}" class="w-7 h-7 object-contain mb-1" alt="Kalori">
                <span>Kalori</span>
            </a>
            <a href="{{ route('profile.edit') }}" class="bottom-bar-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <img src="{{ asset('images/navbar-icon/ic-nav-lainnya.png') }}" class="w-7 h-7 object-contain mb-1" alt="Lainnya">
                <span>Lainnya</span>
            </a>
        </nav>

        <!-- Main Content Area -->
        <main class="main-content pb-24 lg:pb-0 h-full overflow-hidden flex flex-col">
            @isset($header)
                <header class="page-header">
                    <h1 class="text-xl font-bold">{{ $header }}</h1>
                </header>
            @endisset

            <div class="page-body flex-1 overflow-y-auto overflow-x-hidden touch-pan-y [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
                {{ $slot }}
            </div>
        </main>

        <!-- Add Modal / Bottom Sheet Placeholder -->
        <div id="addModal" class="fixed inset-0 bg-black/50 z-50 hidden items-end sm:items-center justify-center transition-opacity">
            <div class="bg-white w-full sm:w-[400px] rounded-t-3xl sm:rounded-2xl p-6 pb-8 transform transition-transform translate-y-full sm:translate-y-0" id="addModalContent">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-bold">Catat Baru</h2>
                    <button onclick="closeAddModal()" class="text-gray-400 hover:text-gray-600">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <a href="{{ route('transactions.create') }}" class="flex flex-col items-center gap-3 p-4 rounded-2xl border-2 border-blue-100 bg-blue-50 hover:bg-blue-100 transition-colors">
                        <div class="w-12 h-12 rounded-full bg-blue-500 text-white flex items-center justify-center">
                            <i data-lucide="arrow-down-up" class="w-6 h-6"></i>
                        </div>
                        <span class="font-medium text-sm text-blue-900">Transaksi</span>
                    </a>
                    
                    <a href="{{ route('food-entries.create') }}" class="flex flex-col items-center gap-3 p-4 rounded-2xl border-2 border-green-100 bg-green-50 hover:bg-green-100 transition-colors">
                        <div class="w-12 h-12 rounded-full bg-green-500 text-white flex items-center justify-center">
                            <i data-lucide="utensils" class="w-6 h-6"></i>
                        </div>
                        <span class="font-medium text-sm text-green-900">Makanan</span>
                    </a>
                </div>
            </div>
        </div>
        
        @stack('modals')

        <script>
            lucide.createIcons();

            function openAddModal() {
                const modal = document.getElementById('addModal');
                const content = document.getElementById('addModalContent');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.classList.add('overflow-hidden');
                // Small delay to allow display:flex to apply before animating transform
                setTimeout(() => {
                    content.classList.remove('translate-y-full');
                }, 10);
            }

            function closeAddModal() {
                const modal = document.getElementById('addModal');
                const content = document.getElementById('addModalContent');
                content.classList.add('translate-y-full');
                document.body.classList.remove('overflow-hidden');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }, 300); // Wait for transition
            }
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
