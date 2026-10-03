<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>Halaman Tidak Ditemukan - ZCal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="antialiased bg-gray-50 flex flex-col items-center justify-center min-h-screen p-6 relative overflow-hidden" style="background: linear-gradient(180deg, #f0fdf4 0%, #fff 100%);">
    
    <!-- Decorative background elements -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10 opacity-40">
        <div class="absolute -top-20 -left-10 w-72 h-72 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl"></div>
        <div class="absolute top-60 -right-20 w-80 h-80 bg-green-100 rounded-full mix-blend-multiply filter blur-3xl"></div>
    </div>

    <!-- Leaves -->
    <img src="/images/icon/icon-daun.png" class="absolute top-20 left-8 w-10 opacity-60 -rotate-45 drop-shadow-sm" alt="">
    <img src="/images/icon/icon-daun.png" class="absolute top-40 right-10 w-8 opacity-50 rotate-12 drop-shadow-sm" alt="">
    <img src="/images/icon/icon-daun.png" class="absolute bottom-40 left-12 w-6 opacity-40 -rotate-90 drop-shadow-sm" alt="">

    <!-- Mascot & 404 Graphic -->
    <div class="relative mb-8 text-center mt-4">
        <!-- Using the sad apple mascot as a substitute for the lost apple -->
        <img src="/images/illustration/mascot-apel-sedih.png" class="w-64 h-64 object-contain mx-auto drop-shadow-2xl relative z-10" alt="404">
        
        <!-- 404 Wooden sign lookalike -->
        <div class="absolute -right-2 top-1/2 -translate-y-6 bg-[#b2825c] text-[#4a2e15] font-black text-[28px] px-6 py-2 rounded-xl rotate-12 shadow-lg border-b-4 border-[#8b6140] z-0" style="font-family: monospace;">
            404
            <div class="absolute w-2 h-16 bg-[#b2825c] border-r-4 border-[#8b6140] -bottom-14 left-1/2 -translate-x-1/2 -z-10"></div>
        </div>
    </div>

    <!-- Text -->
    <div class="text-center max-w-sm mb-10 z-10">
        <h1 class="text-[32px] font-extrabold text-[#1e293b] mb-4 leading-tight tracking-tight">Halaman Tidak<br>Ditemukan</h1>
        <p class="text-gray-500 text-[15px] font-medium leading-relaxed px-4">
            Ups! Halaman yang kamu cari tidak ada atau sudah dipindahkan.
        </p>
    </div>

    <!-- Buttons -->
    <div class="w-full max-w-[320px] space-y-3 z-10">
        <a href="{{ route('dashboard') }}" class="w-full flex items-center justify-center gap-2.5 bg-[#22c55e] hover:bg-[#16a34a] text-white py-3.5 px-6 rounded-[20px] font-bold text-[15px] transition-all shadow-[0_8px_16px_rgba(34,197,94,0.25)] hover:shadow-[0_4px_12px_rgba(34,197,94,0.4)]">
            <i data-lucide="home" class="w-5 h-5"></i>
            Kembali ke Beranda
        </a>
        <button onclick="window.history.back()" class="w-full flex items-center justify-center gap-2.5 bg-white text-[#475569] py-3.5 px-6 rounded-[20px] font-bold text-[15px] transition-all shadow-sm border border-gray-200 hover:bg-gray-50 active:scale-95">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
            Kembali
        </button>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
