<x-blank-layout>
    <div x-data="{ openModal: false, deleteUrl: '', walletName: '' }">
    <x-header-back title="Kelola Dompet" backUrl="{{ route('keuangan.index') }}" />

    <div class="px-5 pb-6 pt-6">
        @if(session('success'))
            <div class="bg-green-50 text-green-700 p-3 rounded-xl mb-4 text-sm font-bold border border-green-100 flex items-center gap-2">
                <i data-lucide="check-circle" class="w-4 h-4"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 text-red-700 p-3 rounded-xl mb-4 text-sm font-bold border border-red-100 flex items-center gap-2">
                <i data-lucide="alert-circle" class="w-4 h-4"></i> {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 space-y-4">
            <h3 class="font-extrabold text-gray-800 text-sm uppercase tracking-wider mb-2">Daftar Dompet</h3>
            
            @foreach($wallets as $wallet)
                <div class="flex items-center justify-between p-3 rounded-2xl border border-gray-100 bg-gray-50/50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-black">
                            {{ substr($wallet->name, 0, 1) }}
                        </div>
                        <div>
                            <div class="font-bold text-gray-800">{{ $wallet->name }}</div>
                            <div class="text-xs font-bold text-gray-500">Rp {{ number_format($wallet->balance, 0, ',', '.') }}</div>
                        </div>
                    </div>
                    
                    <button type="button" @click="deleteUrl = '{{ route('wallets.destroy', $wallet->id) }}'; walletName = '{{ $wallet->name }}'; openModal = true" class="w-8 h-8 flex items-center justify-center text-red-400 hover:text-red-600 hover:bg-red-50 rounded-full transition-colors">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                </div>
            @endforeach

            <a href="{{ route('wallets.create') }}" class="w-full py-3 bg-blue-50 text-blue-600 hover:bg-blue-100 font-bold rounded-2xl transition-all flex items-center justify-center gap-2 mt-4 border border-blue-100">
                <i data-lucide="plus" class="w-4 h-4"></i> Tambah Dompet Baru
            </a>
        </div>
    </div>

    <!-- Modal Hapus -->
    <template x-teleport="body">
        <div x-show="openModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/40 backdrop-blur-sm"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            style="display: none;">
            
            <div x-show="openModal" class="bg-white w-full max-w-sm rounded-[32px] p-6 shadow-2xl relative"
                @click.outside="openModal = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-4">
                
                <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mb-4 mx-auto">
                    <svg class="w-8 h-8 text-red-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                </div>
                
                <h3 class="text-xl font-black text-center text-gray-900 mb-2">Hapus Dompet?</h3>
                <p class="text-[13px] text-center text-gray-500 font-medium mb-6 leading-relaxed">Kamu yakin ingin menghapus dompet <span class="font-bold text-gray-800" x-text="walletName"></span>?<br>Dompet yang sudah ada transaksinya tidak akan bisa dihapus.</p>
                
                <div class="flex gap-3">
                    <button type="button" @click="openModal = false" class="flex-1 py-3.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-2xl transition-colors">
                        Batal
                    </button>
                    <form :action="deleteUrl" method="POST" class="flex-1" onsubmit="const b=this.querySelector('button'); b.disabled=true; b.innerHTML='Menghapus...';">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full py-3.5 bg-red-500 hover:bg-red-600 text-white font-bold rounded-2xl shadow-lg shadow-red-500/30 transition-colors">
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </template>
    </div>
</x-blank-layout>
