<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-extrabold tracking-tight text-gray-800">Kalori</h1>
    </x-slot>

    <!-- Background Elements -->
    <img src="/images/icon/icon-daun.png" class="fixed top-12 left-20 w-10 opacity-50 -rotate-12 -z-10" alt="">
    <img src="/images/icon/icon-daun.png" class="fixed top-32 right-10 w-8 opacity-60 rotate-45 -z-10" alt="">
    <div class="fixed top-0 left-0 w-full h-64 bg-green-50 mix-blend-multiply filter blur-3xl opacity-60 -z-10"></div>

    @php 
        $percentage = min(($caloriesToday / max(Auth::user()->daily_calories, 1)) * 100, 100); 
        $bgClass = 'bg-[#EF4444] shadow-[0_15px_30px_-10px_rgba(239,68,68,0.4)]'; // Merah
        $mascotImg = '/images/illustration/mascot-apel-sedih.png';
        if ($percentage > 25 && $percentage <= 75) {
            $bgClass = 'bg-[#3B82F6] shadow-[0_15px_30px_-10px_rgba(59,130,246,0.4)]'; // Biru
            $mascotImg = '/images/illustration/mascot-apel-datar.png';
        } elseif ($percentage > 75) {
            $bgClass = 'bg-[#30C566] shadow-[0_15px_30px_-10px_rgba(48,197,102,0.4)]'; // Hijau
            $mascotImg = '/images/illustration/mascot-apel-ceria.png';
        }
    @endphp
    <!-- Top Card: Kalori -->
    <div class="{{ $bgClass }} rounded-[32px] pt-6 px-5 pb-5 relative mb-6 overflow-hidden transition-all duration-500">
        
        <!-- Decoration -->
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/20 rounded-full blur-2xl z-0"></div>
        <img src="/images/icon/icon-daun.png" class="absolute top-4 left-6 w-8 opacity-40 rotate-45 z-0" alt="">
        <div class="absolute top-16 left-32 text-yellow-300 text-2xl font-bold opacity-80 z-0">✨</div>
        <div class="absolute top-32 left-8 text-yellow-300 text-xl font-bold opacity-60 z-0">✨</div>

        <!-- Top Section -->
        <div class="flex justify-end relative z-30 mb-8 mt-2">
            <div class="flex flex-col items-end w-[65%] sm:w-[60%]">
                <h3 class="text-green-50 text-[11px] font-bold uppercase tracking-wider mb-1">Konsumsi Hari Ini</h3>
                
                <div class="flex items-baseline gap-1 mb-2">
                    <span class="text-[36px] font-black tracking-tighter leading-none text-white drop-shadow-sm">{{ $caloriesToday }}</span>
                    <span class="text-[12px] font-bold text-green-100">/ {{ Auth::user()->daily_calories }} kkal</span>
                </div>
                
                <!-- Horizontal Progress Bar -->
                <div class="w-full h-4 bg-black/10 rounded-full overflow-hidden p-0.5 mt-1 shadow-inner backdrop-blur-md">
                    <div class="h-full bg-white rounded-full shadow-[0_0_10px_rgba(255,255,255,0.5)] relative overflow-hidden" style="width:{{ $percentage }}%">
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/50 to-transparent w-full h-full animate-[shimmer_2s_infinite]"></div>
                    </div>
                </div>
                
                <div class="w-full flex justify-between mt-2">
                    <span class="text-[10px] text-green-100 font-bold flex items-center gap-1"><i data-lucide="flame" class="w-3 h-3"></i> Terbakar {{ number_format($percentage, 0) }}%</span>
                    <span class="text-[10px] text-white font-bold bg-white/20 px-2 py-0.5 rounded border border-white/10">Sisa {{ max(Auth::user()->daily_calories - $caloriesToday, 0) }}</span>
                </div>
            </div>
        </div>

        <!-- Macros White Card -->
        <div class="bg-white/95 backdrop-blur-md rounded-[24px] p-4 px-5 flex justify-between relative z-10 shadow-lg border border-white/50">
            <div class="flex flex-col items-center flex-1 z-10 relative">
                <img src="/images/icon/icon-daging.png" class="w-7 h-7 object-contain mb-1" alt="Protein">
                <span class="text-gray-500 text-[9px] font-bold">Protein</span>
                <span class="font-bold text-[12px] text-gray-800">{{ $proteinToday ?? 0 }} <span class="text-gray-400 font-medium text-[9px]">/ {{ Auth::user()->target_protein }}g</span></span>
                <div class="w-10 h-1.5 bg-gray-100 rounded-full mt-1 overflow-hidden"><div class="h-full bg-red-400 rounded-full" style="width:{{ min(($proteinToday / max(Auth::user()->target_protein, 1)) * 100, 100) }}%"></div></div>
            </div>
            
            <div class="w-px bg-gray-100 mx-1"></div>
            
            <div class="flex flex-col items-center flex-1 z-10 relative">
                <img src="/images/icon/icon-nasi.png" class="w-7 h-7 object-contain mb-1" alt="Karbo">
                <span class="text-gray-500 text-[9px] font-bold">Karbo</span>
                <span class="font-bold text-[12px] text-gray-800">{{ $carbsToday ?? 0 }} <span class="text-gray-400 font-medium text-[9px]">/ {{ Auth::user()->target_carbs }}g</span></span>
                <div class="w-10 h-1.5 bg-gray-100 rounded-full mt-1 overflow-hidden"><div class="h-full bg-yellow-400 rounded-full" style="width:{{ min(($carbsToday / max(Auth::user()->target_carbs, 1)) * 100, 100) }}%"></div></div>
            </div>
            
            <div class="w-px bg-gray-100 mx-1"></div>
            
            <div class="flex flex-col items-center flex-1 z-10 relative">
                <img src="/images/icon/icon-buah.png" class="w-7 h-7 object-contain mb-1" alt="Lemak">
                <span class="text-gray-500 text-[9px] font-bold">Lemak</span>
                <span class="font-bold text-[12px] text-gray-800">{{ $fatToday ?? 0 }} <span class="text-gray-400 font-medium text-[9px]">/ {{ Auth::user()->target_fat }}g</span></span>
                <div class="w-10 h-1.5 bg-gray-100 rounded-full mt-1 overflow-hidden"><div class="h-full bg-blue-400 rounded-full" style="width:{{ min(($fatToday / max(Auth::user()->target_fat, 1)) * 100, 100) }}%"></div></div>
            </div>
        </div>

        <!-- Mascot -->
        <img src="{{ $mascotImg }}" class="absolute -left-4 sm:-left-2 top-2 sm:top-0 w-[140px] sm:w-[190px] object-contain z-20 drop-shadow-[0_10px_15px_rgba(0,0,0,0.3)] transition-all duration-500" alt="Apple Mascot">
    </div>

    <!-- Spacer / No Notif -->
    <!-- Riwayat Makanan -->
    <h3 class="text-[17px] font-extrabold mb-4 px-1 text-gray-800">Hari Ini</h3>
    
    <div class="space-y-4 pb-4">
        @forelse($foodsToday as $food)
            <div>
                <div class="text-[11px] font-bold text-gray-400 mb-2 px-2 uppercase tracking-wide">{{ $food->meal_time }}</div>
                <div class="tx-item !mb-0 !border-0 shadow-sm overflow-hidden" style="background-image: url('/images/assets/bg-daun.png'); background-size: cover; background-position: right center;">
                    <div class="tx-icon bg-green-50 border border-green-100/50 relative z-10">
                        <img src="/images/icon/icon-makanan.png" class="w-8 h-8 object-contain" alt="">
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-bold text-gray-900 text-[14px] truncate">{{ $food->name }}</div>
                        <div class="text-[11px] text-gray-500 font-bold mt-0.5">{{ $food->portion }}</div>
                    </div>
                    <div class="text-right relative z-10">
                        <div class="font-bold text-[15px] text-gray-900 bg-white/60 backdrop-blur-md px-2.5 py-1 rounded-xl border border-white/50 shadow-sm inline-block">{{ $food->calories }} kkal</div>
                    </div>
                </div>
            </div>
        @empty
            <div class="flex flex-col items-center justify-center py-10 opacity-80">
                <img src="/images/assets/empty-state.png" class="w-32 h-32 object-contain mb-3" alt="Kosong">
                <div class="text-gray-500 font-bold text-sm">Belum ada kalori tercatat hari ini.</div>
            </div>
        @endforelse
    </div>
</x-app-layout>
