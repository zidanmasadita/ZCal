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
    <div class="card mb-6 border-red-100 bg-red-50/30">
        <div class="flex items-start gap-3 mb-4">
            <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0 mt-1">
                <i data-lucide="log-out" class="w-4 h-4 text-red-600"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-[15px] font-bold text-red-900">Keluar Akun</h3>
                <p class="text-[11px] text-red-700/80 font-medium leading-relaxed mt-1">Keluar dari sesi saat ini. Kamu harus login kembali untuk mengakses data keuangan dan kalori.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-md shadow-red-600/20 transition-all flex items-center justify-center gap-2 mt-2">
                <i data-lucide="log-out" class="w-4 h-4"></i> Keluar
            </button>
        </form>
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
