@props(['title', 'backUrl' => 'javascript:history.back()', 'textColor' => 'text-gray-800'])

<div class="w-full flex items-center justify-center relative py-5 px-5 z-50">
    <a href="{{ $backUrl }}" class="absolute left-5 p-2 -ml-2 {{ $textColor }} opacity-80 hover:opacity-100 active:scale-95 transition-all">
        <i data-lucide="arrow-left" class="w-6 h-6"></i>
    </a>
    <h1 class="text-[19px] font-black {{ $textColor }} tracking-tight">{{ $title }}</h1>
</div>
