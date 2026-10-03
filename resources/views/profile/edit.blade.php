<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-extrabold tracking-tight text-gray-800">Profile</h1>
    </x-slot>

    <!-- Background Elements -->
    <img src="/images/icon/icon-daun.png" class="fixed top-12 left-10 w-8 opacity-50 -rotate-12 -z-10" alt="">
    <img src="/images/icon/icon-daun.png" class="fixed top-32 right-10 w-10 opacity-60 rotate-45 -z-10" alt="">
    <div class="fixed top-0 left-0 w-full h-64 bg-blue-50 mix-blend-multiply filter blur-3xl opacity-60 -z-10"></div>
    <div class="fixed top-20 right-0 w-64 h-64 bg-yellow-50 mix-blend-multiply filter blur-3xl opacity-60 -z-10"></div>

    <!-- User Info Card -->
    <div class="card relative overflow-hidden bg-gradient-to-br from-white/90 to-yellow-50/90 mb-6">
        <img src="/images/icon/icon-daun.png" class="absolute bottom-4 right-4 w-6 opacity-30 rotate-12" alt="">
        <div class="flex items-center gap-5 relative z-10">
            <div class="relative group cursor-pointer" onclick="document.getElementById('profile_photo_input').click()">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center p-1 overflow-hidden border border-white shadow-sm">
                    @if(Auth::user()->profile_photo_path)
                        <img src="{{ Storage::url(Auth::user()->profile_photo_path) }}" class="w-full h-full object-cover rounded-full" alt="Profile">
                    @else
                        <img src="/images/illustration/mascot-apel-datar.png" class="w-full h-full object-contain" alt="Profile">
                    @endif
                </div>
                <div class="absolute bottom-0 right-0 w-6 h-6 bg-blue-500 rounded-full border-2 border-white flex items-center justify-center shadow-sm group-hover:bg-blue-600 transition-colors">
                    <i data-lucide="pencil" class="w-3 h-3 text-white"></i>
                </div>
            </div>
            <div>
                <h2 class="text-xl font-extrabold text-gray-900">{{ Auth::user()->name }}</h2>
                <p class="text-sm font-medium text-gray-500 mt-0.5">{{ Auth::user()->email }}</p>
            </div>
        </div>

        <form action="{{ route('profile.photo') }}" method="POST" enctype="multipart/form-data" id="photo-upload-form" class="hidden">
            @csrf
            <input type="file" name="photo" id="profile_photo_input" accept="image/*" onchange="document.getElementById('photo-upload-form').submit()">
        </form>

        @error('photo')
            <div class="mt-3 p-2 bg-red-50 text-red-600 text-xs font-bold rounded-lg flex items-center gap-2 border border-red-100 relative z-10">
                <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0"></i>
                <span>{{ $message }}</span>
            </div>
        @enderror
    </div>

    <!-- Profile Information Section -->
    <div class="card mb-6">
        <div class="flex items-start gap-3 mb-4">
            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0 mt-1">
                <i data-lucide="user" class="w-4 h-4 text-green-600"></i>
            </div>
            <div>
                <h3 class="text-[15px] font-bold text-gray-900">Profile Information</h3>
                <p class="text-[11px] text-gray-500 font-medium leading-relaxed mt-1">Update your account's profile information and email address.</p>
            </div>
        </div>

        <form method="post" action="{{ route('profile.update') }}" class="space-y-4" onsubmit="const b=this.querySelector('button[type=submit]'); if(b){b.disabled=true; b.innerHTML='Memproses...';}">
            @csrf
            @method('patch')

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">Name</label>
                <div class="relative">
                    <i data-lucide="user" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                    <input type="text" name="name" id="profile_name" value="{{ old('name', Auth::user()->name) }}" required
                        class="w-full pl-9 pr-4 py-2.5 bg-gray-50 border-0 rounded-xl text-sm font-medium text-gray-900 focus:ring-2 focus:ring-green-500 transition-shadow">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">Email</label>
                <div class="relative">
                    <i data-lucide="mail" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                    <input type="email" name="email" id="profile_email" value="{{ old('email', Auth::user()->email) }}" required
                        class="w-full pl-9 pr-4 py-2.5 bg-gray-50 border-0 rounded-xl text-sm font-medium text-gray-900 focus:ring-2 focus:ring-green-500 transition-shadow">
                </div>
            </div>

            <button type="submit" id="update_profile_btn" disabled class="w-full py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl shadow-md shadow-green-600/20 transition-all flex items-center justify-center gap-2 mt-2 disabled:opacity-50 disabled:cursor-not-allowed">
                <i data-lucide="save" class="w-4 h-4"></i> Save Changes
            </button>
        </form>
    </div>

    <!-- Muse AI Section -->
    <div class="card mb-6 bg-gradient-to-br from-green-50 to-emerald-50 border-emerald-100">
        <div class="flex items-start gap-3 mb-4">
            <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0 mt-1">
                <i data-lucide="bot" class="w-4 h-4 text-emerald-600"></i>
            </div>
            <div>
                <h3 class="text-[15px] font-bold text-emerald-900">Connect to Muse AI on WhatsApp</h3>
                <p class="text-[11px] text-emerald-700 font-medium leading-relaxed mt-1">Gunakan Muse AI untuk mencatat kalori langsung dari foto makanan via WhatsApp.</p>
            </div>
        </div>

        <a href="{{ route('settings.muse.index') }}" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-md shadow-emerald-600/20 transition-all flex items-center justify-center gap-2 mb-4">
            <i data-lucide="settings" class="w-4 h-4"></i> Kelola Koneksi Muse
        </a>
        
        <div class="bg-white/60 p-4 rounded-xl border border-emerald-100">
            <h4 class="font-bold text-emerald-900 text-xs mb-2">Cara Connect:</h4>
            <ol class="list-decimal list-inside text-[11px] text-emerald-800 space-y-1.5">
                <li>Buka halaman kelola koneksi di atas.</li>
                <li>Ikuti panduan mudah untuk membuat token.</li>
                <li>Berikan token tersebut ke bot Muse AI di WhatsApp.</li>
                <li>Kirim foto makanan ke Muse untuk mencatat kalori otomatis!</li>
            </ol>
        </div>
    </div>

    <!-- Target & Anggaran Section -->
    <div class="card mb-6">
        <div class="flex items-start gap-3 mb-4">
            <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center flex-shrink-0 mt-1">
                <i data-lucide="target" class="w-4 h-4 text-indigo-600"></i>
            </div>
            <div>
                <h3 class="text-[15px] font-bold text-gray-900">Target & Anggaran</h3>
                <p class="text-[11px] text-gray-500 font-medium leading-relaxed mt-1">Atur anggaran bulanan dan target kalori harianmu.</p>
            </div>
        </div>

        <form method="post" action="{{ route('profile.settings') }}" class="space-y-4" onsubmit="const b=this.querySelector('button[type=submit]'); if(b){b.disabled=true; b.innerHTML='Memproses...';}">
            @csrf
            @method('patch')

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">Anggaran Bulanan</label>
                <div class="relative flex items-center">
                    <span class="absolute left-4 font-black text-gray-400 text-sm">Rp</span>
                    <input type="text" inputmode="numeric" id="budget" name="budget" value="{{ number_format(old('budget', Auth::user()->budget), 0, ',', '.') }}" required
                        class="w-full pl-12 pr-4 py-2.5 bg-gray-50 border-0 rounded-xl text-sm font-medium text-gray-900 focus:ring-2 focus:ring-indigo-500 transition-shadow">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">Kebutuhan Kalori Harian</label>
                <div class="relative flex items-center">
                    <i data-lucide="flame" class="w-4 h-4 text-gray-400 absolute left-3"></i>
                    <input type="text" inputmode="numeric" id="daily_calories" name="daily_calories" value="{{ number_format(old('daily_calories', Auth::user()->daily_calories), 0, ',', '.') }}" required
                        class="w-full pl-9 pr-12 py-2.5 bg-gray-50 border-0 rounded-xl text-sm font-medium text-gray-900 focus:ring-2 focus:ring-indigo-500 transition-shadow">
                    <span class="absolute right-4 font-black text-gray-400 text-xs">kkal</span>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block text-[10px] font-bold text-gray-700 mb-1.5 truncate">Protein</label>
                    <div class="relative flex items-center">
                        <input type="text" inputmode="numeric" id="target_protein" name="target_protein" value="{{ number_format(old('target_protein', Auth::user()->target_protein), 0, ',', '.') }}" required
                            class="w-full px-3 py-2.5 bg-gray-50 border-0 rounded-xl text-sm font-medium text-gray-900 focus:ring-2 focus:ring-indigo-500 transition-shadow text-center">
                        <span class="absolute right-3 font-bold text-gray-400 text-[10px]">g</span>
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-700 mb-1.5 truncate">Karbohidrat</label>
                    <div class="relative flex items-center">
                        <input type="text" inputmode="numeric" id="target_carbs" name="target_carbs" value="{{ number_format(old('target_carbs', Auth::user()->target_carbs), 0, ',', '.') }}" required
                            class="w-full px-3 py-2.5 bg-gray-50 border-0 rounded-xl text-sm font-medium text-gray-900 focus:ring-2 focus:ring-indigo-500 transition-shadow text-center">
                        <span class="absolute right-3 font-bold text-gray-400 text-[10px]">g</span>
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-700 mb-1.5 truncate">Lemak</label>
                    <div class="relative flex items-center">
                        <input type="text" inputmode="numeric" id="target_fat" name="target_fat" value="{{ number_format(old('target_fat', Auth::user()->target_fat), 0, ',', '.') }}" required
                            class="w-full px-3 py-2.5 bg-gray-50 border-0 rounded-xl text-sm font-medium text-gray-900 focus:ring-2 focus:ring-indigo-500 transition-shadow text-center">
                        <span class="absolute right-3 font-bold text-gray-400 text-[10px]">g</span>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-md shadow-indigo-600/20 transition-all flex items-center justify-center gap-2 mt-2">
                <i data-lucide="save" class="w-4 h-4"></i> Simpan Target
            </button>
        </form>
    </div>

    <!-- Update Password Section -->
    <div class="card mb-6">
        <div class="flex items-start gap-3 mb-4">
            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0 mt-1">
                <i data-lucide="lock" class="w-4 h-4 text-blue-600"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-[15px] font-bold text-gray-900">Update Password</h3>
                <p class="text-[11px] text-gray-500 font-medium leading-relaxed mt-1">Ensure your account is using a long, random password to stay secure.</p>
            </div>
            <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center flex-shrink-0 -mt-2">
                <i data-lucide="key" class="w-5 h-5 text-yellow-600"></i>
            </div>
        </div>

        <form method="post" action="{{ route('password.update') }}" class="space-y-4" onsubmit="const b=this.querySelector('button[type=submit]'); if(b){b.disabled=true; b.innerHTML='Memproses...';}">
            @csrf
            @method('put')

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">Current Password</label>
                <div class="relative">
                    <i data-lucide="lock" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                    <input type="password" name="current_password" placeholder="Enter current password"
                        class="w-full pl-9 pr-10 py-2.5 bg-gray-50 border-0 rounded-xl text-sm font-medium text-gray-900 focus:ring-2 focus:ring-blue-500 transition-shadow">
                    <i data-lucide="eye" class="w-4 h-4 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 cursor-pointer"></i>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">New Password</label>
                <div class="relative">
                    <i data-lucide="lock" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                    <input type="password" name="password" placeholder="Enter new password"
                        class="w-full pl-9 pr-10 py-2.5 bg-gray-50 border-0 rounded-xl text-sm font-medium text-gray-900 focus:ring-2 focus:ring-blue-500 transition-shadow">
                    <i data-lucide="eye" class="w-4 h-4 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 cursor-pointer"></i>
                </div>
            </div>

            <button type="submit" id="update_password_btn" disabled class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-md shadow-blue-600/20 transition-all flex items-center justify-center gap-2 mt-2 disabled:opacity-50 disabled:cursor-not-allowed">
                <i data-lucide="shield-check" class="w-4 h-4"></i> Update Password
            </button>
        </form>
    </div>

    <!-- Danger Zone: Logout -->
    <div class="card mb-6 border-red-100 bg-red-50/30" x-data="{ showLogoutModal: false }">
        <div class="flex items-start gap-3 mb-4">
            <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0 mt-1">
                <i data-lucide="log-out" class="w-4 h-4 text-red-600"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-[15px] font-bold text-red-900">Keluar Akun</h3>
                <p class="text-[11px] text-red-700/80 font-medium leading-relaxed mt-1">Keluar dari sesi saat ini. Kamu harus login kembali untuk mengakses data keuangan dan kalori.</p>
            </div>
        </div>

        <button type="button" @click="showLogoutModal = true" class="w-full py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-md shadow-red-600/20 transition-all flex items-center justify-center gap-2 mt-2">
            <i data-lucide="log-out" class="w-4 h-4"></i> Keluar
        </button>

        <!-- Logout Confirmation Modal -->
        <template x-teleport="body">
            <div x-show="showLogoutModal" class="fixed inset-0 z-[100] overflow-y-auto" style="display: none;" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <!-- Background overlay -->
                    <div x-show="showLogoutModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm transition-opacity" @click="showLogoutModal = false" aria-hidden="true"></div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <!-- Modal panel -->
                    <div x-show="showLogoutModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-2xl text-left shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-gray-100">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 rounded-t-2xl">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-50 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 text-red-600">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                        <polyline points="16 17 21 12 16 7"></polyline>
                                        <line x1="21" y1="12" x2="9" y2="12"></line>
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">Konfirmasi Keluar</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500 leading-relaxed">Apakah Anda yakin ingin keluar dari ZCal? Anda perlu login kembali untuk mengakses data.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-2xl border-t border-gray-100">
                            <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto sm:ml-3" onsubmit="const b=this.querySelector('button[type=submit]'); if(b){b.disabled=true; b.innerHTML='Keluar...';}">
                                @csrf
                                <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2.5 bg-red-600 text-base font-bold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm transition-colors">
                                    Ya, Keluar
                                </button>
                            </form>
                            <button type="button" @click="showLogoutModal = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2.5 bg-white text-base font-bold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                                Batal
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function setupNumberFormatting(inputId) {
                const input = document.getElementById(inputId);
                if(input) {
                    input.addEventListener('input', function(e) {
                        let value = this.value.replace(/[^0-9]/g, '');
                        if (value !== '') {
                            value = parseInt(value, 10).toLocaleString('id-ID');
                        }
                        this.value = value;
                    });
                }
            }

            setupNumberFormatting('budget');
            setupNumberFormatting('daily_calories');
            setupNumberFormatting('target_protein');
            setupNumberFormatting('target_carbs');
            setupNumberFormatting('target_fat');

            // Password fields locker
            const currentPasswordField = document.querySelector('input[name="current_password"]');
            const newPasswordField = document.querySelector('input[name="password"]');
            const updatePasswordBtn = document.querySelector('#update_password_btn');

            if (currentPasswordField && newPasswordField && updatePasswordBtn) {
                function checkPasswordFields() {
                    if (currentPasswordField.value.trim() !== '' && newPasswordField.value.trim() !== '') {
                        updatePasswordBtn.disabled = false;
                    } else {
                        updatePasswordBtn.disabled = true;
                    }
                }
                
                currentPasswordField.addEventListener('input', checkPasswordFields);
                newPasswordField.addEventListener('input', checkPasswordFields);
                checkPasswordFields();
            }

            // Profile info locker
            const profileNameField = document.getElementById('profile_name');
            const profileEmailField = document.getElementById('profile_email');
            const updateProfileBtn = document.getElementById('update_profile_btn');

            if (profileNameField && profileEmailField && updateProfileBtn) {
                const initialName = profileNameField.defaultValue;
                const initialEmail = profileEmailField.defaultValue;

                function checkProfileFields() {
                    if (profileNameField.value.trim() !== initialName || profileEmailField.value.trim() !== initialEmail) {
                        updateProfileBtn.disabled = false;
                    } else {
                        updateProfileBtn.disabled = true;
                    }
                }

                profileNameField.addEventListener('input', checkProfileFields);
                profileEmailField.addEventListener('input', checkProfileFields);
                checkProfileFields();
            }
        });
    </script>
</x-app-layout>
