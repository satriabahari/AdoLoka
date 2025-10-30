<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('home', absolute: false), navigate: true);
    }
}; ?>

{{-- resources/views/auth/login.blade.php --}}
@push('styles')
    @vite('resources/css/registration.css')
@endpush

<div class="max-w-6xl mx-auto pt-8">
    <div class="bg-white rounded-2xl flex md:flex-row flex-col shadow-2xl overflow-hidden">
        <!-- Illustration (optional) -->
        <div
            class="lg:w-1/2 p-8 flex flex-col justify-center items-center text-center bg-gradient-to-br from-primary to-primary-dark">
            <img src="{{ asset('images/login.svg') }}" alt="Ilustrasi" class="w-96">
            <div class="flex flex-col justify-center text-white mt-8">
                <h2 class="text-3xl font-bold mb-2">Selamat datang kembali!</h2>
                <p class="text-white/90">Masuk untuk mengelola UMKM, event, dan produk Anda.</p>
            </div>
        </div>

        <!-- Form -->
        <div class="lg:w-1/2 p-8 lg:p-12 bg-white">
            <div class="max-w-md mx-auto">
                <h1 class="text-2xl font-bold text-gray-900 mb-6">Masuk Akun</h1>

                @if (session('status'))
                    <div class="mb-4 p-3 rounded-md bg-emerald-50 text-primary text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 p-3 rounded-md bg-red-50 text-error text-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form wire:submit="login" class="space-y-5">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                            Email
                        </label>
                        <input id="email" type="email" required autocomplete="email" wire:model.defer="form.email"
                            class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary-dark"
                            placeholder="you@example.com">
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input id="password" type="password" autocomplete="current-password"
                            wire:model.defer="form.password"
                            class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary-dark"
                            placeholder="Password">
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between pt-2">
                        <a href="{{ route('password.request') }}"
                            class="text-sm text-primary hover:text-primary-dark">Lupa password?</a>
                    </div>

                    <button type="submit"
                        class="w-full mt-2 inline-flex items-center justify-center gap-2 px-4 py-3 rounded-lg font-semibold text-white bg-gradient-to-r from-primary to-primary-dark hover:from-primary-dark hover:to-primary-hover shadow-md hover:shadow-lg transition">
                        Masuk
                    </button>

                    <p class="text-sm text-gray-600 text-center">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="text-primary hover:text-primary-dark font-medium">
                            Daftar sekarang
                        </a>
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
                    <a href="{{ route('auth.google') }}"
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
        </div>
        <!-- End Form -->
    </div>
</div>
