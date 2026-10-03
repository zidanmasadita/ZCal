<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-extrabold tracking-tight text-gray-800">Keuangan</h1>
    </x-slot>

    <!-- Background Elements -->
    <img src="/images/icon/icon-daun.png" class="fixed top-10 right-4 w-10 opacity-50 rotate-12 -z-10" alt="">
    <img src="/images/icon/icon-daun.png" class="fixed bottom-20 left-4 w-8 opacity-60 -rotate-45 -z-10" alt="">
    <div class="fixed top-0 left-0 w-full h-64 bg-blue-50 mix-blend-multiply filter blur-3xl opacity-60 -z-10"></div>

    <!-- Top Card: Total Saldo -->
    <div class="card bg-gradient-to-br from-blue-400 to-blue-600 text-white border-0 mb-6 relative overflow-hidden shadow-[0_10px_30px_-10px_rgba(37,99,235,0.5)] !p-6 rounded-[28px]">
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/20 rounded-full blur-2xl"></div>
        
        <div class="relative z-20 w-[70%] mb-4">
            <h3 class="text-blue-100 text-[13px] font-medium mb-1">{{ $displayTitle }}</h3>
            <div class="text-[32px] font-black tracking-tight mb-2">Rp {{ number_format($displayBalance, 0, ',', '.') }}</div>
        </div>
        
        <img src="/images/illustration/mascot-dompet.png" class="absolute -right-4 top-2 w-[160px] object-contain opacity-100 drop-shadow-2xl z-10" alt="Wallet">

        <div class="flex gap-3 w-full relative z-20">
            <div class="flex-1 bg-white/20 backdrop-blur-md rounded-[20px] p-3 flex flex-col justify-center border border-white/30 shadow-sm">
                <div class="text-blue-50 text-[11px] mb-1 flex items-center gap-1 font-bold">
                    <img src="/images/icon/icon-uang-masuk.png" class="w-4 h-4 object-contain" alt=""> Pemasukan
                </div>
                <div class="font-black text-[15px] text-white tracking-tight">Rp {{ number_format($incomeThisMonth, 0, ',', '.') }}</div>
            </div>
            <div class="flex-1 bg-white/10 backdrop-blur-md rounded-[20px] p-3 flex flex-col justify-center border border-white/20 shadow-sm">
                <div class="text-blue-50 text-[11px] mb-1 flex items-center gap-1 font-bold">
                    <img src="/images/icon/icon-uang-pengeluaran.png" class="w-4 h-4 object-contain" alt=""> Pengeluaran
                </div>
                <div class="font-black text-[15px] text-white tracking-tight">Rp {{ number_format($expenseThisMonth, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <!-- Dompet & Kategori Chips -->
    <div class="flex gap-3 overflow-x-auto pb-4 mb-4 no-scrollbar px-1">
        <a href="{{ route('keuangan.index', ['wallet_id' => 'all']) }}" class="chip flex-shrink-0 {{ $activeWalletId === 'all' ? 'chip-finance' : 'chip-neutral' }}">
            <img src="/images/icon/icon-dompet.png" class="w-5 h-5 -ml-1" alt=""> Semua Dompet
        </a>
        @foreach($wallets as $wallet)
            <a href="{{ route('keuangan.index', ['wallet_id' => $wallet->id]) }}" class="chip flex-shrink-0 text-sm {{ $activeWalletId == $wallet->id ? 'chip-finance' : 'chip-neutral' }}">{{ $wallet->name }}</a>
        @endforeach
        <a href="{{ route('wallets.index') }}" class="chip flex-shrink-0 text-sm chip-neutral !border-dashed !border-gray-300 hover:!border-gray-400">
            <i data-lucide="settings-2" class="w-4 h-4"></i> Kelola
        </a>
    </div>

    <!-- Riwayat Transaksi -->
    <div class="flex justify-between items-center mb-4 px-1">
        <h3 class="text-lg font-bold">Riwayat Transaksi</h3>
        <button onclick="document.getElementById('filterModal').classList.remove('hidden')" class="bg-white border border-gray-200 text-gray-700 py-1.5 px-3 rounded-[14px] shadow-sm hover:bg-gray-50 flex items-center gap-2 text-sm font-bold transition-all">
            <i data-lucide="filter" class="w-4 h-4"></i> Filter
        </button>
    </div>
    
    <div class="space-y-3 pb-6">
        @forelse($recentTransactions as $tx)
            <div class="tx-item !border-0 shadow-sm overflow-hidden" style="background-image: url('/images/assets/bg-uang.png'); background-size: cover; background-position: right center;">
                <div class="tx-icon {{ $tx->type === 'income' ? 'bg-blue-50 border-blue-100/50' : 'bg-orange-50 border-orange-100/50' }} relative z-10">
                    <img src="/images/icon/{{ $tx->category->icon ?? 'icon-uang-masuk.png' }}" class="w-8 h-8 object-contain" alt="">
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-bold text-gray-900 text-sm truncate">{{ $tx->note ?: $tx->category->name }}</div>
                    <div class="text-xs text-gray-600 font-bold mt-0.5">{{ \Carbon\Carbon::parse($tx->date)->format('d M') }} • {{ $tx->wallet->name }}</div>
                </div>
                <div class="text-right relative z-10">
                    <div class="{{ $tx->type === 'expense' ? 'tx-amount-expense text-pink-700' : 'tx-amount-income text-green-700' }} bg-white/60 backdrop-blur-md px-2.5 py-1 rounded-xl border border-white/50 shadow-sm inline-block font-bold">
                        {{ $tx->type === 'expense' ? '-' : '+' }} Rp {{ number_format($tx->amount, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        @empty
            <div class="flex flex-col items-center justify-center py-10 opacity-80">
                <img src="/images/assets/empty-state.png" class="w-32 h-32 object-contain mb-3" alt="Kosong">
                <div class="text-gray-500 font-bold text-sm">Belum ada transaksi bulan ini.</div>
            </div>
        @endforelse
    </div>
    @push('modals')
    <!-- Bottom Sheet Filter -->
    <div id="filterModal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm z-[200] hidden flex flex-col justify-end">
        <div class="flex-1 w-full" onclick="document.getElementById('filterModal').classList.add('hidden')"></div>
        <div class="bg-white w-full rounded-t-[32px] p-6 pb-10 relative shadow-2xl" style="animation: slideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;">
            <div class="w-12 h-1.5 bg-gray-200 rounded-full mx-auto mb-6"></div>
            
            <h2 class="text-xl font-extrabold mb-6 text-gray-900">Filter Transaksi</h2>
            <form action="{{ route('keuangan.index') }}" method="GET" class="space-y-6">
                <input type="hidden" name="wallet_id" value="{{ request('wallet_id', 'all') }}">
                
                <!-- Toggle Jenis Transaksi -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-3">Jenis Transaksi</label>
                    <div class="flex gap-2">
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="type" value="all" class="peer hidden" {{ request('type', 'all') == 'all' ? 'checked' : '' }}>
                            <div class="text-center py-3 px-2 rounded-[20px] border-2 border-gray-100 bg-gray-50 text-gray-500 font-bold text-sm peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-600 transition-all shadow-sm">Semua</div>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="type" value="income" class="peer hidden" {{ request('type') == 'income' ? 'checked' : '' }}>
                            <div class="text-center py-3 px-2 rounded-[20px] border-2 border-gray-100 bg-gray-50 text-gray-500 font-bold text-sm peer-checked:border-green-500 peer-checked:bg-green-50 peer-checked:text-green-600 transition-all shadow-sm">Pemasukan</div>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="type" value="expense" class="peer hidden" {{ request('type') == 'expense' ? 'checked' : '' }}>
                            <div class="text-center py-3 px-2 rounded-[20px] border-2 border-gray-100 bg-gray-50 text-gray-500 font-bold text-sm peer-checked:border-pink-500 peer-checked:bg-pink-50 peer-checked:text-pink-600 transition-all shadow-sm">Pengeluaran</div>
                        </label>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ request('start_date', $startDate->format('Y-m-d')) }}" class="w-full rounded-[20px] border-gray-200 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 text-sm font-bold py-3.5 px-4 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Sampai</label>
                        <input type="date" name="end_date" value="{{ request('end_date', $endDate->format('Y-m-d')) }}" class="w-full rounded-[20px] border-gray-200 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 text-sm font-bold py-3.5 px-4 shadow-sm">
                    </div>
                </div>

                <button type="submit" class="w-full bg-[#2563eb] text-white font-extrabold py-4 rounded-[20px] shadow-[0_8px_16px_rgba(37,99,235,0.25)] hover:bg-[#1d4ed8] transition-all mt-8 text-[15px]">
                    Terapkan Filter
                </button>
            </form>
        </div>
    </div>
    <style>
        @keyframes slideUp {
            from { transform: translateY(100%); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
    @endpush
</x-app-layout>
