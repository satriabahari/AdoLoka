<div>
    <h2 class="text-3xl font-bold text-gray-900 mb-2">Sign up</h2>
    <p class="text-gray-600 mb-8">Registrasi akun untuk UMKM (Informasi Pengguna Akun)</p>

    <form wire:submit.prevent="nextStep" class="space-y-4">
        <!-- First Name & Last Name -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                <input type="text" wire:model.defer="first_name" placeholder="Satria"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition">
                @error('first_name')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                <input type="text" wire:model.defer="last_name" placeholder="Bahari (Optional)"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition">
                @error('last_name')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Email & Phone -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" wire:model.defer="email" placeholder="satria@gmail.com"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition">
                @error('email')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                <input type="text" wire:model.defer="phone_number" placeholder="+628 atau 08"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition">
                @error('phone_number')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror

            </div>
        </div>

        <!-- Password -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
            <div class="relative">
                <input type="password" id="password" wire:model.defer="password" placeholder="Password"
                    class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition">
                <button type="button" onclick="togglePassword('password')"
                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 password-toggle transition">
                    <i class="fas fa-eye-slash"></i>
                </button>
            </div>
            @error('password')
                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
            <div class="relative">
                <input type="password" id="password_confirmation" wire:model.defer="password_confirmation"
                    placeholder="password"
                    class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition">
                <button type="button" onclick="togglePassword('password_confirmation')"
                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 password-toggle transition">
                    <i class="fas fa-eye-slash"></i>
                </button>
            </div>
            @error('password_confirmation')
                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <!-- Terms & Conditions -->
        <div class="flex items-start pt-2">
            <input type="checkbox" wire:model.defer="agree_terms" id="agree_terms"
                class="mt-1 w-4 h-4 text-primary-500 border-gray-300 rounded focus:ring-primary-500 cursor-pointer">
            <label for="agree_terms" class="ml-3 text-sm text-gray-600 select-none">
                I agree to all the <span class="text-primary-500 hover:text-primary-600 font-medium">Terms</span>
                and
                <span class="text-primary-500 hover:text-primary-600 font-medium">Privacy Policies</span>
            </label>
        </div>
        @error('agree_terms')
            <span class="text-red-500 text-xs block">{{ $message }}</span>
        @enderror

        <!-- Submit Button -->
        <button type="submit"
            class="w-full bg-primary-500 hover:bg-primary-600 text-white font-semibold py-3.5 rounded-lg transition duration-200 shadow-sm hover:shadow-md mt-6">
            Selanjutnya
        </button>

        <!-- Login Link -->
        <p class="text-center text-sm text-gray-600 pt-2">
            Already have an account? <a href="/login"
                class="text-primary-500 hover:text-primary-600 font-medium">Login</a>
        </p>

        <!-- Divider -->
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-4 bg-white text-gray-500">Or Sign up with</span>
            </div>
        </div>

        <!-- Google Sign Up -->
        <a href="{{ route('auth.google.redirect') }}"
            class="w-full flex items-center justify-center gap-3 px-4 py-3.5 border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-200 shadow-sm hover:shadow-md">
            <svg class="w-5 h-5" viewBox="0 0 24 24">
                <path fill="#4285F4"
                    d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                <path fill="#34A853"
                    d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                <path fill="#FBBC05"
                    d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                <path fill="#EA4335"
                    d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
            </svg>
            <span class="text-gray-700 font-medium">Sign up with Google</span>
        </a>
    </form>
</div>

<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = field.nextElementSibling.querySelector('i');

        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            field.type = 'password';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    }
</script>
