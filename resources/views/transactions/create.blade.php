<x-blank-layout>
    <div class="min-h-[100dvh] w-full bg-cover bg-center bg-no-repeat relative flex flex-col" style="background-image: url('/images/assets/bg-uang.png');">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-gradient-to-b from-blue-50/90 via-blue-50/50 to-blue-50 pointer-events-none"></div>
    <x-header-back title="Catat Transaksi" backUrl="{{ route('dashboard') }}" />

    <div class="px-5 pb-8 pt-2 relative flex-1 flex flex-col overflow-y-auto">
        <!-- Floating Decorator -->
        <div class="absolute top-10 left-0 w-32 h-32 bg-blue-200 rounded-full blur-3xl opacity-40 -ml-10 pointer-events-none z-0"></div>
        <div class="absolute bottom-20 right-0 w-40 h-40 bg-pink-200 rounded-full blur-3xl opacity-40 -mr-10 pointer-events-none z-0"></div>

        <form action="{{ route('transactions.store') }}" method="POST" class="bg-white rounded-[32px] p-6 shadow-xl shadow-gray-200/50 space-y-5 relative z-10 border border-gray-100/80" onsubmit="const b=this.querySelector('button[type=submit]'); if(b){b.disabled=true; b.innerHTML='Memproses...';}">
            @csrf
            
            <div>
                <label class="block text-[13px] font-extrabold text-gray-500 mb-2 uppercase tracking-wider">Jenis Transaksi</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="cursor-pointer group">
                        <input type="radio" name="type" value="expense" class="peer sr-only" checked>
                        <div class="p-3.5 rounded-[20px] border-2 border-gray-100 bg-gray-50 text-center font-bold text-gray-400 peer-checked:border-pink-500 peer-checked:bg-pink-50 peer-checked:text-pink-600 transition-all group-active:scale-95 shadow-sm">
                            Pengeluaran
                        </div>
                    </label>
                    <label class="cursor-pointer group">
                        <input type="radio" name="type" value="income" class="peer sr-only">
                        <div class="p-3.5 rounded-[20px] border-2 border-gray-100 bg-gray-50 text-center font-bold text-gray-400 peer-checked:border-green-500 peer-checked:bg-green-50 peer-checked:text-green-600 transition-all group-active:scale-95 shadow-sm">
                            Pemasukan
                        </div>
                    </label>
                </div>
            </div>

            <div class="bg-blue-50/50 p-4 rounded-[24px] border border-blue-100/50">
                <label class="block text-[13px] font-extrabold text-blue-800 mb-2 uppercase tracking-wider">Jumlah Uang</label>
                <div class="relative flex items-center">
                    <span class="absolute left-4 font-black text-blue-900 text-xl">Rp</span>
                    <input type="text" inputmode="numeric" id="amount" name="amount" required class="w-full bg-white border-0 rounded-[16px] px-4 py-4 pl-14 font-black text-2xl text-blue-900 shadow-sm focus:ring-4 focus:ring-blue-500/20 placeholder-blue-200 transition-shadow" placeholder="0">
                </div>
            </div>

            <div>
                <label class="block text-[13px] font-extrabold text-gray-500 mb-2 uppercase tracking-wider">Kategori</label>
                <div class="flex overflow-x-auto gap-2 pb-2 [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]" id="categoryContainer">
                    @foreach($categories as $index => $category)
                        <label class="category-label cursor-pointer flex-shrink-0 group" data-type="{{ $category->type }}">
                            <input type="radio" name="category_id" value="{{ $category->id }}" class="peer sr-only" required>
                            <div class="px-4 py-2.5 rounded-full border-2 border-gray-100 bg-gray-50 text-sm font-bold text-gray-500 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 transition-all shadow-sm active:scale-95">
                                {{ $category->name }}
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="block text-[13px] font-extrabold text-gray-500 mb-2 uppercase tracking-wider">Dompet</label>
                <div class="flex overflow-x-auto gap-2 pb-2 [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
                    @foreach($wallets as $index => $wallet)
                        <label class="cursor-pointer flex-shrink-0 group">
                            <input type="radio" name="wallet_id" value="{{ $wallet->id }}" class="peer sr-only" {{ $index === 0 ? 'checked' : '' }} required>
                            <div class="px-4 py-2.5 rounded-full border-2 border-gray-100 bg-gray-50 text-sm font-bold text-gray-500 peer-checked:border-indigo-500 peer-checked:bg-indigo-50 peer-checked:text-indigo-700 transition-all shadow-sm active:scale-95">
                                {{ $wallet->name }}
                            </div>
                        </label>
                    @endforeach
                    <a href="{{ route('wallets.create') }}" class="px-4 py-2.5 rounded-full border-2 border-dashed border-gray-300 bg-transparent text-sm font-bold text-gray-400 hover:text-gray-600 hover:border-gray-400 transition-all shadow-sm flex-shrink-0 flex items-center gap-1 active:scale-95">
                        <i data-lucide="plus" class="w-4 h-4"></i> Baru
                    </a>
                </div>
            </div>

            <div>
                <label class="block text-[13px] font-extrabold text-gray-500 mb-2 uppercase tracking-wider">Tanggal & Waktu</label>
                <input type="datetime-local" name="date" value="{{ now()->format('Y-m-d\TH:i') }}" required class="w-full bg-gray-50 border-0 rounded-[16px] px-4 py-3.5 font-bold text-gray-700 shadow-sm focus:ring-4 focus:ring-blue-500/20">
            </div>

            <div>
                <label class="block text-[13px] font-extrabold text-gray-500 mb-2 uppercase tracking-wider">Catatan</label>
                <input type="text" name="note" placeholder="Tulis sesuatu yang manis..." class="w-full bg-gray-50 border-0 rounded-[16px] px-4 py-3.5 font-bold text-gray-700 shadow-sm focus:ring-4 focus:ring-blue-500/20 placeholder-gray-300">
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white font-black rounded-[20px] py-4 mt-2 shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:-translate-y-0.5 active:translate-y-0 active:scale-95 transition-all text-lg">
                Yey, Simpan! 💸
            </button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeRadios = document.querySelectorAll('input[name="type"]');
            const categoryLabels = document.querySelectorAll('.category-label');

            function updateCategories() {
                const selectedType = document.querySelector('input[name="type"]:checked').value;
                let firstVisibleFound = false;

                categoryLabels.forEach(label => {
                    const categoryType = label.getAttribute('data-type');
                    if (categoryType === selectedType) {
                        label.style.display = 'flex';
                        if (!firstVisibleFound) {
                            label.querySelector('input').checked = true;
                            firstVisibleFound = true;
                        }
                    } else {
                        label.style.display = 'none';
                        label.querySelector('input').checked = false;
                    }
                });
            }

            typeRadios.forEach(radio => {
                radio.addEventListener('change', updateCategories);
            });

            updateCategories();

            // Auto-format currency
            const amountInput = document.getElementById('amount');
            amountInput.addEventListener('input', function(e) {
                // Remove non-numeric characters
                let value = this.value.replace(/[^0-9]/g, '');
                
                // Format with dots
                if (value !== '') {
                    value = parseInt(value, 10).toLocaleString('id-ID');
                }
                
                this.value = value;
            });
        });
    </script>
</x-blank-layout>
