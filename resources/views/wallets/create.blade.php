<x-blank-layout>
    <div class="min-h-[100dvh] w-full bg-cover bg-center bg-no-repeat relative flex flex-col" style="background-image: url('/images/assets/bg-uang.png');">
        <!-- Overlay gradient for readability -->
        <div class="absolute inset-0 bg-gradient-to-b from-sky-200 via-sky-50 to-white pointer-events-none z-0"></div>
        <div class="absolute inset-0 backdrop-blur-[2px] pointer-events-none z-0"></div>

        <!-- Header -->
        <x-header-back title="Tambah Dompet" backUrl="{{ route('transactions.create') }}" textColor="text-sky-900" />

        <!-- Illustration Area (Fills the empty space) -->
        <div class="flex-1 flex flex-col items-center justify-center relative z-10 px-6 -mt-4">
            <!-- Decorative Glow -->
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-40 h-40 bg-white/20 rounded-full blur-3xl"></div>
            
            <img src="/images/illustration/mascot-dompet.png" class="w-36 object-contain drop-shadow-[0_20px_40px_rgba(0,0,0,0.4)] animate-[float_4s_ease-in-out_infinite] relative z-10" alt="Mascot Dompet">
            
            <div class="mt-4 text-center relative z-10">
                <h2 class="text-sky-900 text-xl font-black tracking-tight">Simpan Uangmu!</h2>
                <p class="text-sky-700 text-[11px] font-medium mt-0.5 opacity-90 max-w-[250px] mx-auto">Tambahkan dompet, e-wallet, atau bank untuk mencatat keuanganmu.</p>
            </div>
            
            <!-- Floating badges for cheerfulness -->
            <div class="absolute top-1/4 left-8 bg-white/60 backdrop-blur-md px-2 py-1 rounded-xl border border-sky-100 flex items-center gap-1 -rotate-6 animate-[pulse_3s_infinite] shadow-sm">
                <img src="/images/icon/icon-dompet.png" class="w-3 h-3" alt="">
                <span class="text-sky-900 text-[9px] font-bold">BCA</span>
            </div>
            <div class="absolute top-1/3 right-6 bg-white/60 backdrop-blur-md px-2 py-1 rounded-xl border border-sky-100 flex items-center gap-1 rotate-12 animate-[pulse_4s_infinite] shadow-sm">
                <span class="text-sky-900 text-[9px] font-bold">Gopay</span>
                <span class="text-sm leading-none">📱</span>
            </div>
        </div>

        <!-- Floating Glass Container for Form -->
        <div class="relative z-20 bg-white/60 backdrop-blur-2xl border-t border-white/80 p-5 pt-4 rounded-t-[32px] shadow-[0_-15px_50px_rgba(14,165,233,0.15)] pb-6 w-full animate-[slideUp_0.4s_ease-out]">
            <!-- Decorative handle -->
            <div class="w-10 h-1 bg-sky-200 rounded-full mx-auto mb-4"></div>

            <form action="{{ route('wallets.store') }}" method="POST" class="space-y-3" onsubmit="const b=this.querySelector('button[type=submit]'); if(b){b.disabled=true; b.innerHTML='Memproses...';}">
                @csrf

                <!-- Name Input -->
                <div class="bg-white/80 p-3 rounded-[20px] border border-sky-100 shadow-sm">
                    <label class="block text-[10px] font-extrabold text-sky-600 mb-1 uppercase tracking-wider">Nama Dompet / Rekening</label>
                    <input type="text" name="name" required placeholder="Contoh: Dompet Utama, BCA..." class="w-full bg-white border-0 rounded-[12px] px-3 py-2.5 font-black text-base text-sky-900 shadow-sm focus:ring-4 focus:ring-sky-200/50 placeholder-sky-300 transition-shadow">
                </div>

                <!-- Balance Input -->
                <div class="bg-white/80 p-3 rounded-[20px] border border-sky-100 shadow-sm">
                    <label class="block text-[10px] font-extrabold text-sky-600 mb-1 uppercase tracking-wider">Saldo Awal (Opsional)</label>
                    <div class="relative flex items-center">
                        <span class="absolute left-3 font-black text-sky-400 text-lg">Rp</span>
                        <input type="text" inputmode="numeric" id="balance" name="balance" class="w-full bg-white border-0 rounded-[12px] px-3 py-2.5 pl-10 font-black text-xl text-sky-900 shadow-sm focus:ring-4 focus:ring-sky-200/50 placeholder-sky-300 transition-shadow" placeholder="0">
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-gradient-to-r from-sky-500 via-blue-500 to-sky-500 bg-[length:200%_auto] animate-[gradient_3s_ease_infinite] text-white font-black rounded-[16px] py-3 mt-2 shadow-[0_10px_30px_rgba(14,165,233,0.4)] hover:shadow-[0_15px_40px_rgba(14,165,233,0.5)] hover:-translate-y-1 active:translate-y-0 active:scale-95 transition-all text-base flex items-center justify-center gap-2 border border-sky-200/50">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i> Tambahkan
                </button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-format currency
            const balanceInput = document.getElementById('balance');
            balanceInput.addEventListener('input', function(e) {
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
