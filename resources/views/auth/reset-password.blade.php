<x-blank-layout>
    <!-- Background Design -->
    <div class="fixed inset-0 w-full h-full bg-gradient-to-b from-[#E0F7FA] to-[#C8E6C9] -z-20"></div>
    
    <!-- Abstract Hills/Leaves -->
    <div class="fixed bottom-0 left-0 w-full h-64 bg-[#A5D6A7] rounded-t-[100%] scale-150 -translate-y-10 opacity-60 -z-10"></div>
    <div class="fixed bottom-0 left-0 w-full h-48 bg-[#81C784] rounded-t-[100%] scale-125 translate-x-10 opacity-80 -z-10"></div>
    <div class="fixed bottom-0 left-0 w-full h-32 bg-[#66BB6A] rounded-t-[100%] scale-110 -translate-x-10 -z-10"></div>
    
    <!-- Floating Leaves & Stars -->
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <img src="/images/icon/icon-daun.png" class="absolute top-10 left-10 w-8 opacity-60 -rotate-12 animate-[bounce_4s_infinite]" alt="">
        <img src="/images/icon/icon-daun.png" class="absolute top-32 right-8 w-12 opacity-80 rotate-45 animate-[bounce_5s_infinite]" alt="">
        <img src="/images/icon/icon-daun.png" class="absolute bottom-40 right-20 w-10 opacity-50 rotate-90" alt="">
        
        <!-- Yellow Sparkles -->
        <div class="absolute top-24 left-32 text-yellow-300 text-2xl font-bold opacity-80 rotate-12">✨</div>
        <div class="absolute top-32 right-32 text-yellow-300 text-xl font-bold opacity-80 -rotate-12">✨</div>
    </div>

    <!-- Back Button -->
    <a href="{{ route('login') }}" class="absolute top-6 left-6 w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm hover:bg-gray-50 transition-colors z-20">
        <i data-lucide="arrow-left" class="w-5 h-5 text-[#1A237E]"></i>
    </a>

    <!-- Content -->
    <div class="min-h-screen flex flex-col justify-center px-5 relative z-10 py-10">
        
        <!-- Main White Card -->
        <div class="bg-white rounded-[32px] p-6 shadow-[0_20px_50px_-10px_rgba(0,0,0,0.1)] relative z-10 max-w-md mx-auto w-full border border-green-50">
            
            <!-- Header -->
            <div class="text-center mb-6">
                <h1 class="text-[26px] font-black text-[#1A237E] tracking-tight mb-2">Reset Password</h1>
                <p class="text-gray-500 font-medium text-[13px] px-2 leading-relaxed">
                    Masukkan kode OTP yang telah dikirimkan ke email Anda beserta password baru.
                </p>
            </div>
            
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-4">
                    <label class="block text-[13px] font-bold text-[#1A237E] mb-1.5 ml-1">Email</label>
                    <div class="relative flex items-center bg-gray-50 border border-gray-200 rounded-2xl p-1 transition-colors">
                        <div class="w-10 h-10 bg-gray-100 rounded-[12px] flex items-center justify-center flex-shrink-0">
                            <i data-lucide="mail" class="w-5 h-5 text-gray-400"></i>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email', request()->email) }}" required readonly
                            class="w-full bg-transparent border-0 focus:ring-0 text-[13px] font-medium text-gray-500 px-3 cursor-not-allowed">
                    </div>
                </div>

                <!-- OTP Code -->
                <div class="mb-4">
                    <label class="block text-[13px] font-bold text-[#1A237E] mb-1.5 ml-1">Kode OTP (6 Angka)</label>
                    <div class="relative flex items-center bg-white border border-gray-200 focus-within:border-[#4CAF50] rounded-2xl p-1 transition-colors">
                        <div class="w-10 h-10 bg-[#E8F5E9] rounded-[12px] flex items-center justify-center flex-shrink-0">
                            <i data-lucide="key-round" class="w-5 h-5 text-[#4CAF50]"></i>
                        </div>
                        <input id="otp" type="text" name="otp" required autofocus inputmode="numeric" maxlength="6"
                            class="w-full bg-transparent border-0 focus:ring-0 text-[13px] font-medium text-gray-800 px-3 tracking-widest placeholder-gray-400" placeholder="000000">
                    </div>
                    <x-input-error :messages="$errors->get('otp')" class="mt-1 text-[10px] text-red-500 font-bold ml-1" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="block text-[13px] font-bold text-[#1A237E] mb-1.5 ml-1">Password Baru</label>
                    <div class="relative flex items-center bg-white border border-gray-200 focus-within:border-[#4CAF50] rounded-2xl p-1 transition-colors">
                        <div class="w-10 h-10 bg-[#E8F5E9] rounded-[12px] flex items-center justify-center flex-shrink-0">
                            <i data-lucide="lock" class="w-5 h-5 text-[#4CAF50]"></i>
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                            class="w-full bg-transparent border-0 focus:ring-0 text-[13px] font-medium text-gray-800 px-3 placeholder-gray-400" placeholder="Masukkan password baru">
                        <button type="button" class="pr-3 pl-2 flex items-center justify-center focus:outline-none toggle-password" data-target="password">
                            <i data-lucide="eye-off" class="w-4 h-4 text-gray-400 hover:text-gray-600 transition-colors"></i>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-[10px] text-red-500 font-bold ml-1" />
                </div>

                <!-- Confirm Password -->
                <div class="mb-8">
                    <label class="block text-[13px] font-bold text-[#1A237E] mb-1.5 ml-1">Konfirmasi Password Baru</label>
                    <div class="relative flex items-center bg-white border border-gray-200 focus-within:border-[#4CAF50] rounded-2xl p-1 transition-colors">
                        <div class="w-10 h-10 bg-[#E8F5E9] rounded-[12px] flex items-center justify-center flex-shrink-0">
                            <i data-lucide="lock" class="w-5 h-5 text-[#4CAF50]"></i>
                        </div>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                            class="w-full bg-transparent border-0 focus:ring-0 text-[13px] font-medium text-gray-800 px-3 placeholder-gray-400" placeholder="Konfirmasi password baru">
                        <button type="button" class="pr-3 pl-2 flex items-center justify-center focus:outline-none toggle-password" data-target="password_confirmation">
                            <i data-lucide="eye-off" class="w-4 h-4 text-gray-400 hover:text-gray-600 transition-colors"></i>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-[10px] text-red-500 font-bold ml-1" />
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-[12px] bg-[#38C968] hover:bg-[#2CA152] text-white font-bold rounded-2xl shadow-[0_8px_15px_-5px_rgba(56,201,104,0.4)] transition-all flex items-center justify-center text-[15px]">
                    Reset Password
                </button>
            </form>
        </div>
    </div>

    <script>
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = this.querySelector('i');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.setAttribute('data-lucide', 'eye');
                } else {
                    input.type = 'password';
                    icon.setAttribute('data-lucide', 'eye-off');
                }
                
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            });
        });
    </script>
</x-blank-layout>
