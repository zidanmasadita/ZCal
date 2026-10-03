<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-[32px] font-extrabold tracking-tight leading-tight">Halo, <span class="text-green-600">Zidan!</span></h1>
                <p class="text-gray-500 text-sm mt-1">Jaga pola makan dan keuangan<br>demi hari yang lebih baik!</p>
            </div>
            <a href="{{ route('notifications.index') }}" class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm relative transition-colors hover:bg-gray-50">
                <i data-lucide="bell" class="w-6 h-6 text-gray-600"></i>
                @if(Auth::user()->unreadNotifications->count() > 0)
                    <span class="absolute top-3 right-3 w-2.5 h-2.5 bg-red-500 border-2 border-white rounded-full"></span>
                @endif
            </a>
        </div>
    </x-slot>

    <!-- Background Elements -->
    <img src="/images/icon/icon-daun.png" class="absolute top-10 -left-4 w-12 opacity-50 -rotate-45 -z-10" alt="">
    <img src="/images/icon/icon-daun.png" class="absolute top-24 right-20 w-8 opacity-60 rotate-45 -z-10" alt="">
    <div class="absolute -top-20 -left-20 w-64 h-64 bg-green-100 rounded-full mix-blend-multiply filter blur-3xl opacity-70 -z-10"></div>
    <div class="absolute top-10 right-0 w-72 h-72 bg-yellow-100 rounded-full mix-blend-multiply filter blur-3xl opacity-70 -z-10"></div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Kalori Card -->
        <div class="card overflow-hidden relative" style="background: linear-gradient(180deg, #f0fdf4 0%, #fff 100%);">
            <h3 class="card-title">
                <img src="/images/icon/icon-api.png" class="w-6 h-6 object-contain" alt="">
                Kalori Hari Ini
            </h3>
            
            <div class="flex items-center justify-between mt-0 mb-4 px-2">
                <div class="w-40 h-40 relative z-10 flex-shrink-0 -ml-4 mt-2">
                    <img src="/images/illustration/mascot-apel-ceria.png" class="w-full h-full object-contain drop-shadow-xl scale-110 origin-bottom" alt="Kalori">
                </div>

                <div class="relative w-32 h-32 flex-shrink-0">
                    <svg class="w-full h-full -rotate-90 drop-shadow-sm" viewBox="0 0 100 100">
                        <circle class="progress-ring-track" cx="50" cy="50" r="40" />
                        <circle class="progress-ring-fill" cx="50" cy="50" r="40" stroke-dasharray="251.2" stroke-dashoffset="{{ 251.2 - (251.2 * min($caloriesToday / max(Auth::user()->daily_calories, 1), 1)) }}" />
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center px-2">
                        @php
                            $calStr = number_format($caloriesToday, 0, ',', '.');
                            $calLen = strlen($calStr);
                            $textSize = $calLen > 7 ? 'text-lg' : ($calLen > 5 ? 'text-2xl' : 'text-[28px]');
                        @endphp
                        <span class="{{ $textSize }} font-black text-gray-900 leading-none text-center w-full truncate">{{ $calStr }}</span>
                        <span class="text-[10px] text-gray-500 mt-1 text-center w-full truncate">/ {{ number_format(Auth::user()->daily_calories, 0, ',', '.') }} kkal</span>
                    </div>
                </div>
            </div>

            <div class="flex justify-between gap-2 mt-4">
                <div class="flex-1 bg-white rounded-[16px] p-2 sm:p-2.5 flex flex-col items-center justify-center text-center gap-1 shadow-sm border border-gray-50">
                    <img src="/images/icon/icon-daging.png" class="w-7 h-7 sm:w-8 sm:h-8 object-contain" alt="Protein">
                    <div>
                        <div class="text-[9px] sm:text-[10px] text-gray-500 font-bold">Protein</div>
                        <div class="text-xs sm:text-sm font-black">{{ $proteinToday ?? 0 }}g</div>
                    </div>
                </div>
                <div class="flex-1 bg-white rounded-[16px] p-2 sm:p-2.5 flex flex-col items-center justify-center text-center gap-1 shadow-sm border border-gray-50">
                    <img src="/images/icon/icon-nasi.png" class="w-7 h-7 sm:w-8 sm:h-8 object-contain" alt="Karbo">
                    <div>
                        <div class="text-[9px] sm:text-[10px] text-gray-500 font-bold">Karbo</div>
                        <div class="text-xs sm:text-sm font-black">{{ $carbsToday ?? 0 }}g</div>
                    </div>
                </div>
                <div class="flex-1 bg-white rounded-[16px] p-2 sm:p-2.5 flex flex-col items-center justify-center text-center gap-1 shadow-sm border border-gray-50">
                    <img src="/images/icon/icon-buah.png" class="w-7 h-7 sm:w-8 sm:h-8 object-contain" alt="Lemak">
                    <div>
                        <div class="text-[9px] sm:text-[10px] text-gray-500 font-bold">Lemak</div>
                        <div class="text-xs sm:text-sm font-black">{{ $fatToday ?? 0 }}g</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Keuangan Card -->
        <div class="card overflow-hidden relative flex flex-col h-full">
            <h3 class="card-title relative z-20">
                <img src="/images/icon/icon-dompet.png" class="w-6 h-6 object-contain" alt="">
                Sisa Saldo
            </h3>
            
            <div class="flex justify-between items-center relative z-20 mt-1">
                <div class="text-[26px] sm:text-[28px] font-black tracking-tighter w-[65%] sm:w-auto leading-tight">Rp {{ number_format($totalBalance, 0, ',', '.') }}</div>
            </div>

            <img src="/images/illustration/mascot-dompet.png" class="absolute -right-4 -top-2 w-[110px] sm:w-[140px] sm:-right-6 object-contain opacity-100 drop-shadow-2xl z-10" alt="Wallet">

            <div class="mt-8 relative z-20">
                <div class="flex justify-between text-[11px] mb-2">
                    <span class="text-gray-500 font-medium">Anggaran Bulanan</span>
                    <span class="font-bold text-gray-800">Rp {{ number_format($expenseThisMonth, 0, ',', '.') }} <span class="text-gray-400">/ Rp {{ number_format(Auth::user()->budget, 0, ',', '.') }}</span></span>
                </div>
                <div class="budget-bar-track bg-gray-100 h-2">
                    @php $percentage = Auth::user()->budget > 0 ? min(($expenseThisMonth / Auth::user()->budget) * 100, 100) : 0; @endphp
                    <div class="budget-bar-fill bg-blue-600" style="width: {{ $percentage }}%"></div>
                </div>
            </div>

            <div class="flex gap-2 sm:gap-3 mt-auto pt-6 relative z-10">
                <div class="flex-1 rounded-[16px] sm:rounded-[20px] p-2.5 sm:p-3 flex flex-col sm:flex-row sm:items-center gap-1.5 sm:gap-3 relative overflow-hidden shadow-sm" style="background-image: url('/images/assets/bg-hijau.png'); background-size: cover; background-position: right center;">
                    <img src="/images/icon/icon-uang-masuk.png" class="w-6 h-6 sm:w-8 sm:h-8 relative z-10" alt="In">
                    <div class="relative z-10">
                        <div class="text-[10px] text-green-800 font-bold mb-0.5">Pemasukan</div>
                        <div class="font-black text-green-700 text-sm tracking-tighter">Rp {{ number_format($incomeThisMonth, 0, ',', '.') }}</div>
                    </div>
                </div>
                <div class="flex-1 rounded-[16px] sm:rounded-[20px] p-2.5 sm:p-3 flex flex-col sm:flex-row sm:items-center gap-1.5 sm:gap-3 relative overflow-hidden shadow-sm" style="background-image: url('/images/assets/bg-pink.png'); background-size: cover; background-position: right center;">
                    <img src="/images/icon/icon-uang-pengeluaran.png" class="w-6 h-6 sm:w-8 sm:h-8 relative z-10" alt="Out">
                    <div class="relative z-10">
                        <div class="text-[10px] text-pink-800 font-bold mb-0.5">Pengeluaran</div>
                        <div class="font-black text-pink-700 text-sm tracking-tighter">Rp {{ number_format($expenseThisMonth, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Aktivitas Terakhir -->
    <div class="flex justify-between items-end mb-4 px-1">
        <h3 class="text-lg font-bold flex items-center gap-2">
            <img src="/images/icon/icon-clipboard.png" class="w-6 h-6 object-contain" alt="">
            Aktivitas Terakhir
        </h3>
        <a href="{{ route('keuangan.index') }}" class="text-green-600 text-xs font-bold hover:underline">Lihat Semua <i data-lucide="chevron-right" class="w-3 h-3 inline"></i></a>
    </div>
    
    <div class="space-y-3">
        @forelse($recentActivities as $activity)
            @if($activity->activity_type === 'transaction')
                <div class="tx-item !border-0 shadow-sm overflow-hidden" style="background-image: url('/images/assets/bg-uang.png'); background-size: cover; background-position: right center;">
                    <div class="tx-icon bg-orange-50 border border-orange-100/50 relative z-10">
                        <img src="/images/icon/{{ $activity->category->icon ?? 'icon-minuman.png' }}" class="w-8 h-8 object-contain" alt="">
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-bold text-gray-900 text-sm truncate">{{ $activity->note ?: $activity->category->name }}</div>
                        <div class="text-xs text-gray-500 font-bold mt-0.5">{{ \Carbon\Carbon::parse($activity->date)->format('d M') }} • {{ $activity->wallet->name }}</div>
                    </div>
                    <div class="text-right relative z-10">
                        <div class="{{ $activity->type === 'expense' ? 'tx-amount-expense text-pink-700' : 'tx-amount-income text-green-700' }} bg-white/60 backdrop-blur-md px-2.5 py-1 rounded-xl border border-white/50 shadow-sm inline-block font-bold">
                            {{ $activity->type === 'expense' ? '-' : '+' }} Rp {{ number_format($activity->amount, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            @else
                <div class="tx-item !border-0 shadow-sm overflow-hidden" style="background-image: url('/images/assets/bg-daun.png'); background-size: cover; background-position: right center;">
                    <div class="tx-icon bg-green-50 border border-green-100/50 relative z-10">
                        <img src="/images/icon/icon-makanan.png" class="w-8 h-8 object-contain" alt="">
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-bold text-gray-900 text-sm truncate">{{ $activity->name }}</div>
                        <div class="text-xs text-gray-500 font-bold mt-0.5">{{ $activity->meal_time }}</div>
                    </div>
                    <div class="text-right relative z-10">
                        <div class="font-bold text-sm text-gray-900 bg-white/60 backdrop-blur-md px-2.5 py-1 rounded-xl border border-white/50 shadow-sm inline-block">{{ $activity->calories }} kkal</div>
                    </div>
                </div>
            @endif
        @empty
            <div class="flex flex-col items-center justify-center py-10 opacity-80">
                <img src="/images/assets/empty-state.png" class="w-32 h-32 object-contain mb-3" alt="Kosong">
                <div class="text-gray-500 font-bold text-sm">Belum ada aktivitas.</div>
            </div>
        @endforelse
    </div>
</x-app-layout>
