<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard') }}" class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm text-gray-600 hover:bg-gray-50 transition-colors relative z-10">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <h1 class="text-[22px] font-extrabold tracking-tight text-gray-800">Notifikasi</h1>
        </div>
    </x-slot>

    @if($notifications->isEmpty())
        <!-- Empty State -->
        <div class="flex flex-col items-center justify-center py-24 opacity-80 px-4 text-center">
            <img src="/images/assets/empty-state.png" class="w-40 h-40 object-contain mb-5" alt="Kosong">
            <div class="text-gray-700 font-black text-[17px] mb-2">Belum ada notifikasi</div>
            <p class="text-[13px] text-gray-500 font-medium max-w-[250px] leading-relaxed">
                Pemberitahuan terkait target kalori, budget keuangan, dan pengingat makanmu akan muncul di sini.
            </p>
        </div>
    @else
        <div class="px-4 py-6 space-y-4">
            @foreach($notifications as $notif)
                @php
                    $colors = [
                        'blue' => 'bg-blue-50 text-blue-600 border-blue-100',
                        'green' => 'bg-green-50 text-green-600 border-green-100',
                        'red' => 'bg-red-50 text-red-600 border-red-100',
                        'yellow' => 'bg-yellow-50 text-yellow-600 border-yellow-100',
                    ];
                    $theme = $colors[$notif->data['color'] ?? 'blue'] ?? $colors['blue'];
                @endphp
                <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center border flex-shrink-0 {{ $theme }}">
                        <i data-lucide="{{ $notif->data['icon'] ?? 'bell' }}" class="w-5 h-5"></i>
                    </div>
                    <div class="flex-1 min-w-0 pt-0.5">
                        <div class="font-bold text-gray-900 text-sm mb-0.5">{{ $notif->data['title'] ?? 'Notifikasi' }}</div>
                        <p class="text-xs text-gray-500 font-medium leading-relaxed">{{ $notif->data['message'] ?? '' }}</p>
                        <div class="text-[10px] text-gray-400 font-bold mt-2">{{ $notif->created_at->diffForHumans() }}</div>
                    </div>
                    @if(is_null($notif->read_at))
                        <div class="w-2 h-2 bg-red-500 rounded-full mt-2 flex-shrink-0"></div>
                    @endif
                </div>
            @endforeach
        </div>
        
        <div class="px-4 pb-6">
            {{ $notifications->links() }}
        </div>
    @endif
</x-app-layout>
