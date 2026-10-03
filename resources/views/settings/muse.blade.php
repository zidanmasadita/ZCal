<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('profile.edit') }}" class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-gray-500 hover:text-gray-800 transition-colors">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <h2 class="text-xl font-bold text-gray-800 leading-tight">
                Hubungkan ke Muse
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            @if (session('success'))
                <div class="bg-green-50 text-green-800 p-4 rounded-xl text-sm mb-4 border border-green-200">
                    {{ session('success') }}
                    
                    @if (session('plainTextToken'))
                        <div class="mt-3 p-3 bg-white rounded-lg border border-green-200 break-all font-mono text-sm relative">
                            {{ session('plainTextToken') }}
                        </div>
                        <p class="text-xs text-red-600 mt-2 font-bold"><i data-lucide="alert-triangle" class="w-3 h-3 inline"></i> Peringatan: Salin token ini sekarang! Ini satu-satunya kesempatan Anda melihatnya.</p>
                    @endif
                </div>
            @endif

            <div class="bg-white p-6 shadow sm:rounded-2xl border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-2">Buat Token Baru</h3>
                <p class="text-sm text-gray-500 mb-4">Token ini akan memberi Muse akses khusus untuk mengirim catatan kalori dari WhatsApp ke akun Anda.</p>
                
                <form action="{{ route('settings.muse.store') }}" method="POST" onsubmit="const b=this.querySelector('button[type=submit]'); if(b){b.disabled=true; b.innerHTML='Memproses...';}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nama Token</label>
                        <input type="text" name="name" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-green-500 focus:ring-green-500" placeholder="Mis: Muse WhatsApp" required>
                    </div>
                    <button type="submit" class="w-full bg-black text-white rounded-xl py-3 px-4 font-bold hover:bg-gray-800 transition-colors">Buat Token</button>
                </form>
            </div>

            <div class="bg-white p-6 shadow sm:rounded-2xl border border-gray-100 mt-6">
                <h3 class="text-lg font-bold text-gray-800 mb-2">Token Aktif</h3>
                
                <div class="space-y-3 mt-4">
                    @forelse($tokens as $token)
                        <div class="p-4 border border-gray-100 rounded-xl bg-gray-50 flex items-center justify-between">
                            <div>
                                <div class="font-bold text-sm text-gray-800">{{ $token->name }}</div>
                                <div class="text-xs text-gray-500 mt-0.5">Terakhir dipakai: {{ $token->last_used_at ? $token->last_used_at->diffForHumans() : 'Belum pernah' }}</div>
                            </div>
                            <form action="{{ route('settings.muse.destroy', $token->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mencabut token ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-bold p-2 bg-red-50 rounded-lg">Cabut</button>
                            </form>
                        </div>
                    @empty
                        <div class="text-center py-6 text-gray-400 text-sm">Belum ada token yang dibuat.</div>
                    @endforelse
                </div>
            </div>

            <div class="bg-blue-50 p-6 rounded-2xl border border-blue-100 mt-6">
                <h3 class="font-bold text-blue-900 mb-2">Cara Menggunakan:</h3>
                <ol class="list-decimal list-inside text-sm text-blue-800 space-y-2">
                    <li>Buat token baru di atas lalu salin hasilnya.</li>
                    <li>Berikan token tersebut ke Muse di WhatsApp.</li>
                    <li>Sistem Muse akan menyimpan tokenmu dengan aman.</li>
                    <li>Mulai kirim foto makanan! Muse akan mengirimkan data kalori ke <code class="bg-white px-2 py-0.5 rounded text-blue-900">{{ url('/api/webhooks/agent/food-log') }}</code></li>
                </ol>
            </div>
            
        </div>
    </div>
</x-app-layout>
