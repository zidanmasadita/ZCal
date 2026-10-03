<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3 relative z-10">
            <a href="{{ route('profile.edit') }}" class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-gray-500 hover:text-gray-800 transition-colors">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <h2 class="text-xl font-bold text-gray-800 leading-tight">
                Hubungkan ke Muse
            </h2>
        </div>
    </x-slot>

    <!-- Background Elements -->
    <img src="/images/icon/icon-daun.png" class="fixed top-0 right-0 w-48 opacity-20 -z-10" alt="">
    <div class="fixed top-0 right-0 w-64 h-64 bg-green-50 mix-blend-multiply filter blur-3xl opacity-60 -z-10"></div>

    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <!-- Langkah 1: Buat Token -->
            <div class="bg-white p-6 shadow-sm sm:rounded-2xl border border-gray-100 relative overflow-hidden">
                <div class="flex items-center gap-3 mb-4 relative z-10">
                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0 font-bold text-green-700 text-sm">1</div>
                    <h3 class="text-lg font-bold text-gray-800">Buat token koneksi</h3>
                </div>

                @if (session('success') && session('plainTextToken'))
                    <div class="bg-green-50 border border-green-200 rounded-xl p-5 mb-2 relative z-10">
                        <div class="flex flex-col sm:flex-row gap-3">
                            <input type="text" id="new_muse_token" value="{{ session('plainTextToken') }}" class="bg-white border border-green-200 text-gray-800 text-sm font-mono p-3 rounded-xl focus:ring-green-500 focus:border-green-500 w-full" readonly>
                            <button type="button" onclick="navigator.clipboard.writeText(document.getElementById('new_muse_token').value); this.innerHTML='Disalin!'; setTimeout(() => this.innerHTML='Salin Token', 2000)" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-xl transition-colors whitespace-nowrap shadow-md shadow-green-600/20 text-sm">
                                Salin Token
                            </button>
                        </div>
                        <div class="mt-3 flex items-start gap-2 bg-yellow-50 p-3 rounded-lg border border-yellow-200 text-yellow-800 text-xs font-medium">
                            <i data-lucide="alert-triangle" class="w-4 h-4 flex-shrink-0 text-yellow-600 mt-0.5"></i>
                            <p>⚠️ Token hanya tampil sekali di sini. Salin sekarang — kalau hilang, kamu harus buat token baru.</p>
                        </div>
                    </div>
                @else
                    @php
                        $canCreate = $tokens->count() < 3;
                    @endphp
                    <div class="relative z-10">
                        <p class="text-sm text-gray-600 mb-4 leading-relaxed">Token adalah "kunci rahasia" yang mengizinkan Muse untuk mengirimkan catatan kalori langsung ke akun ZCal-mu.</p>
                        
                        <form action="{{ route('settings.muse.store') }}" method="POST" onsubmit="const b=this.querySelector('button[type=submit]'); if(b){b.disabled=true; b.innerHTML='Memproses...';}">
                            @csrf
                            <button type="submit" @if(!$canCreate) disabled @endif class="w-full sm:w-auto bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl py-3 px-8 font-bold hover:from-green-600 hover:to-green-700 transition-all shadow-lg shadow-green-500/20 disabled:opacity-50 disabled:cursor-not-allowed">
                                Buat Token Baru
                            </button>
                            @if(!$canCreate)
                                <p class="text-xs text-red-500 mt-3 font-medium"><i data-lucide="alert-circle" class="w-3 h-3 inline"></i> Batas maksimal 3 token telah tercapai. Hapus token lama untuk membuat yang baru.</p>
                            @endif
                        </form>
                    </div>
                @endif
            </div>

            <!-- Langkah 2: Tempel ke Muse -->
            <div class="bg-[#f0f7ff] p-6 shadow-sm sm:rounded-2xl border border-blue-100">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-8 h-8 rounded-full bg-blue-200 flex items-center justify-center flex-shrink-0 font-bold text-blue-800 text-sm">2</div>
                    <h3 class="text-lg font-bold text-blue-900">Hubungkan ke Muse</h3>
                </div>
                
                <p class="text-[13px] text-blue-900/80 mb-4 leading-relaxed font-medium">
                    Muse adalah asisten AI yang akan menganalisis foto makananmu. Agar hasilnya otomatis tercatat di ZCal, Muse butuh token dari Langkah 1.
                </p>

                <div class="bg-white rounded-xl border border-blue-200 p-4 mb-4 shadow-sm">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs font-bold text-blue-900">Pesan siap salin:</span>
                        <button type="button" onclick="navigator.clipboard.writeText(document.getElementById('muse_message').textContent); this.innerHTML='<i data-lucide=\'check\' class=\'w-3 h-3 inline mr-1\'></i>Tersalin'; setTimeout(() => this.innerHTML='Salin Pesan', 2000)" class="text-blue-600 hover:text-blue-800 text-[11px] bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors font-bold flex items-center">
                            Salin Pesan
                        </button>
                    </div>
                    <div id="muse_message" class="text-[13px] text-gray-700 font-mono leading-relaxed bg-gray-50 p-3 rounded-lg border border-gray-100 select-all break-all whitespace-pre-wrap">Halo Muse, tolong hubungkan aplikasi ZCal saya supaya setiap foto makanan yang saya kirim ke kamu otomatis tercatat sebagai food log. Endpoint webhook saya: {{ request()->getSchemeAndHttpHost() }}/api/webhooks/agent/food-log — saya akan menempelkan token pribadi saya ke form aman yang kamu berikan.</div>
                </div>

                <ol class="list-decimal list-inside text-[13px] text-blue-900/80 space-y-2 font-medium">
                    <li>Salin pesan di atas dengan menekan tombol <strong>Salin Pesan</strong>.</li>
                    <li>Buka aplikasi/chat WhatsApp dengan Muse.</li>
                    <li>Tempel pesan tersebut dan kirim ke Muse.</li>
                    <li>Muse akan memberikan sebuah form yang aman. Buka tautan tersebut dan <strong>tempel tokenmu dari Langkah 1</strong> ke sana.</li>
                    <li>Selesai! Tokenmu kini tersimpan aman dan tidak pernah lewat di dalam riwayat chat biasa.</li>
                </ol>
            </div>

            <!-- Langkah 3: Verifikasi -->
            @php
                $hasUsedToken = $tokens->whereNotNull('last_used_at')->sortByDesc('last_used_at')->first();
            @endphp
            <div class="bg-white p-6 shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center flex-shrink-0 font-bold text-purple-700 text-sm">3</div>
                    <h3 class="text-lg font-bold text-gray-800">Verifikasi</h3>
                </div>

                @if($hasUsedToken)
                    <div class="flex items-start gap-3 bg-green-50 border border-green-200 rounded-xl p-4">
                        <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i data-lucide="check" class="w-5 h-5 text-white"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-green-900 text-sm">Terhubung</h4>
                            <p class="text-[13px] text-green-800 mt-1">Food log terakhir diterima: <strong>{{ $hasUsedToken->last_used_at->diffForHumans() }}</strong>.</p>
                        </div>
                    </div>
                @else
                    <div class="flex items-start gap-3 bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                        <div class="w-8 h-8 rounded-full bg-yellow-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i data-lucide="hourglass" class="w-5 h-5 text-yellow-900"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-yellow-900 text-sm">Belum Terhubung</h4>
                            <p class="text-[13px] text-yellow-800 mt-1">Kirim foto makanan pertama ke Muse untuk menguji koneksi.</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Kelola Token -->
            <div class="bg-white p-6 shadow-sm sm:rounded-2xl border border-gray-100 mt-8">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i data-lucide="key" class="w-5 h-5 text-gray-400"></i> Kelola Token
                </h3>
                
                <div class="space-y-3" x-data="{ showModal: false, tokenId: null, tokenName: '' }">
                    @forelse($tokens as $token)
                        <div class="p-4 border border-gray-100 rounded-xl bg-gray-50 flex flex-col sm:flex-row sm:items-center justify-between shadow-sm gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gray-200 flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="link" class="w-5 h-5 text-gray-500"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-sm text-gray-800">{{ $token->name }}</div>
                                    <div class="text-[11px] text-gray-500 mt-0.5">
                                        Terakhir dipakai: <span class="font-medium text-gray-700">{{ $token->last_used_at ? $token->last_used_at->diffForHumans() : 'Belum pernah' }}</span>
                                    </div>
                                </div>
                            </div>
                            <button type="button" @click="showModal = true; tokenId = {{ $token->id }}; tokenName = '{{ $token->name }}'" class="text-red-600 hover:text-red-700 bg-red-100/50 hover:bg-red-100 text-xs font-bold px-4 py-2 rounded-lg transition-colors flex justify-center items-center gap-1.5 w-full sm:w-auto">
                                Cabut
                            </button>
                        </div>
                    @empty
                        <div class="text-center py-6 text-gray-400 text-sm bg-gray-50 rounded-xl border border-dashed border-gray-200">Belum ada token aktif.</div>
                    @endforelse

                    <!-- Delete Confirmation Modal -->
                    <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                            <!-- Background overlay -->
                            <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm transition-opacity" @click="showModal = false" aria-hidden="true"></div>

                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                            <!-- Modal panel -->
                            <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-2xl text-left shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-gray-100">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 rounded-t-2xl">
                                    <div class="sm:flex sm:items-start">
                                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-50 sm:mx-0 sm:h-10 sm:w-10">
                                            <i data-lucide="alert-triangle" class="h-5 w-5 text-red-600"></i>
                                        </div>
                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                            <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">Cabut Token Akses</h3>
                                            <div class="mt-2">
                                                <p class="text-sm text-gray-500 leading-relaxed">Apakah Anda yakin ingin mencabut <strong x-text="tokenName" class="text-gray-800"></strong>? Muse yang memakai token ini akan langsung terputus.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-2xl border-t border-gray-100">
                                    <form :action="'{{ route('settings.muse.destroy', 'TID') }}'.replace('TID', tokenId)" method="POST" class="w-full sm:w-auto sm:ml-3" onsubmit="const b=this.querySelector('button[type=submit]'); if(b){b.disabled=true; b.innerHTML='Mencabut...';}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2.5 bg-red-600 text-base font-bold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm transition-colors">
                                            Ya, Cabut
                                        </button>
                                    </form>
                                    <button type="button" @click="showModal = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2.5 bg-white text-base font-bold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                                        Batal
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
