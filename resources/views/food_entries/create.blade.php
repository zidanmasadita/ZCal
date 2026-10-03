<x-blank-layout>
    <div class="min-h-[100dvh] w-full bg-cover bg-center bg-no-repeat relative flex flex-col" style="background-image: url('/images/assets/bg-daun.png');">
        <!-- Overlay gradient -->
        <div class="absolute inset-0 bg-gradient-to-b from-green-50/90 via-green-50/50 to-green-50 pointer-events-none"></div>
    <!-- Header is a component, usually it has its own z-index, but let's make sure it's above overlay -->
    <div class="relative z-10">
        <x-header-back title="Catat Kalori" backUrl="{{ route('dashboard') }}" />
    </div>

    <div class="px-5 pb-6 pt-2 flex-1 flex flex-col justify-center relative z-10 max-w-xl mx-auto w-full">
        <form action="{{ route('food-entries.store') }}" method="POST" class="space-y-6" onsubmit="const b=this.querySelector('button[type=submit]'); if(b){b.disabled=true; b.innerHTML='Memproses...';}">
            @csrf

            <!-- Nama Makanan -->
            <div>
                <label class="block text-[11px] font-extrabold text-gray-400 mb-2 ml-1 tracking-wider">NAMA MAKANAN</label>
                <div class="bg-white rounded-[20px] p-1.5 shadow-sm border border-gray-100 flex items-center pr-4 focus-within:ring-2 focus-within:ring-green-400 transition-shadow">
                    <div class="w-12 h-12 rounded-[16px] bg-green-50 flex items-center justify-center text-green-500 ml-1">
                        <i data-lucide="utensils" class="w-5 h-5"></i>
                    </div>
                    <input type="text" name="name" required placeholder="Contoh: Nasi Ayam Bakar" class="w-full bg-transparent border-0 px-4 py-3 font-bold text-gray-800 text-[15px] focus:ring-0 placeholder-gray-300">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <!-- Porsi -->
                <div>
                    <label class="block text-[11px] font-extrabold text-gray-400 mb-2 ml-1 tracking-wider">PORSI</label>
                    <div class="bg-white rounded-[20px] p-1.5 shadow-sm border border-gray-100 flex items-center pr-4 focus-within:ring-2 focus-within:ring-gray-400 transition-shadow">
                        <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 ml-1">
                            <i data-lucide="pie-chart" class="w-4 h-4"></i>
                        </div>
                        <input type="text" name="portion" placeholder="1 Piring" class="w-full bg-transparent border-0 px-3 py-2 font-bold text-gray-800 focus:ring-0 placeholder-gray-300 text-[13px]">
                    </div>
                </div>
                
                <!-- Kalori -->
                <div>
                    <label class="block text-[11px] font-extrabold text-green-500 mb-2 ml-1 tracking-wider">TOTAL (KKAL)</label>
                    <div class="bg-green-50 rounded-[20px] p-1.5 shadow-sm border border-green-200 flex items-center pr-4 ring-2 ring-green-100 focus-within:ring-green-400 transition-shadow">
                        <div class="w-10 h-10 rounded-xl bg-green-400 flex items-center justify-center text-white ml-1 shadow-inner">
                            <i data-lucide="flame" class="w-4 h-4 fill-current"></i>
                        </div>
                        <input type="number" name="calories" required placeholder="0" class="w-full bg-transparent border-0 px-3 py-2 font-black text-green-700 text-xl focus:ring-0 placeholder-green-300">
                    </div>
                </div>
            </div>
            
            <!-- Makronutrisi -->
            <div>
                <label class="block text-[11px] font-extrabold text-gray-400 mb-2 ml-1 tracking-wider">MAKRONUTRISI (OPSIONAL)</label>
                <div class="bg-white rounded-[24px] p-4 shadow-sm border border-gray-100">
                    <div class="grid grid-cols-3 gap-3">
                        <div class="flex flex-col items-center">
                            <div class="w-full bg-blue-50/50 rounded-2xl p-3 border border-blue-100/50 text-center relative group focus-within:ring-2 focus-within:ring-blue-400 transition-shadow">
                                <label class="block text-[10px] font-extrabold text-blue-400 mb-1">KARBO</label>
                                <div class="flex items-end justify-center">
                                    <input type="number" name="carbs" placeholder="0" class="w-full max-w-[40px] bg-transparent border-0 p-0 text-center font-black text-xl text-blue-700 focus:ring-0">
                                    <span class="text-xs font-bold text-blue-300 mb-1">g</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col items-center">
                            <div class="w-full bg-orange-50/50 rounded-2xl p-3 border border-orange-100/50 text-center relative group focus-within:ring-2 focus-within:ring-orange-400 transition-shadow">
                                <label class="block text-[10px] font-extrabold text-orange-400 mb-1">PROTEIN</label>
                                <div class="flex items-end justify-center">
                                    <input type="number" name="protein" placeholder="0" class="w-full max-w-[40px] bg-transparent border-0 p-0 text-center font-black text-xl text-orange-700 focus:ring-0">
                                    <span class="text-xs font-bold text-orange-300 mb-1">g</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col items-center">
                            <div class="w-full bg-pink-50/50 rounded-2xl p-3 border border-pink-100/50 text-center relative group focus-within:ring-2 focus-within:ring-pink-400 transition-shadow">
                                <label class="block text-[10px] font-extrabold text-pink-400 mb-1">LEMAK</label>
                                <div class="flex items-end justify-center">
                                    <input type="number" name="fat" placeholder="0" class="w-full max-w-[40px] bg-transparent border-0 p-0 text-center font-black text-xl text-pink-700 focus:ring-0">
                                    <span class="text-xs font-bold text-pink-300 mb-1">g</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Waktu Makan -->
            <div>
                <label class="block text-[11px] font-extrabold text-gray-400 mb-2 ml-1 tracking-wider">WAKTU MAKAN</label>
                <div class="grid grid-cols-2 gap-3">
                    @foreach(['Sarapan', 'Makan Siang', 'Makan Malam', 'Cemilan'] as $index => $meal)
                        <label class="cursor-pointer group">
                            <input type="radio" name="meal_time" value="{{ $meal }}" class="peer sr-only" {{ $index === 0 ? 'checked' : '' }} required>
                            <div class="px-4 py-3.5 rounded-[18px] bg-white border-2 border-gray-100 text-[13px] font-bold text-gray-500 peer-checked:border-green-500 peer-checked:bg-green-50 peer-checked:text-green-700 transition-all shadow-sm flex items-center justify-center relative overflow-hidden active:scale-95 group-hover:border-gray-200">
                                {{ $meal }}
                                <div class="absolute inset-0 bg-green-500/10 opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="w-full bg-green-500 text-white font-black rounded-[20px] py-4 mt-2 shadow-lg shadow-green-500/30 hover:bg-green-600 active:scale-95 transition-all text-lg flex items-center justify-center gap-2">
                Simpan Kalori <i data-lucide="check-circle" class="w-5 h-5"></i>
            </button>
        </form>
    </div>
    </div>
</x-blank-layout>
