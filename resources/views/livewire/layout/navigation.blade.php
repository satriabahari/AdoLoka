<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
};
?>

<nav x-data="{ open: false }" class="bg-white fixed top-0 inset-x-0 z-[99] drop-shadow-xl">
    @php
        $user = auth()->user();
        $avatarUrl = null;

        if ($user) {
            try {
                $avatarUrl = $user->getFirstMediaUrl('avatar') ?: null;
            } catch (\Throwable $e) {
                $avatarUrl = null;
            }
            $avatarUrl = $avatarUrl ?: asset('images/placeholder.png');
        }
    @endphp

    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 lg:px-12">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <a href="{{ route('home') }}" wire:navigate class="shrink-0 flex items-center gap-3">
                <img src="/images/logo.png" class="h-[34px]" alt="Logo">
                <span class="font-bold text-2xl text-gray-900">Adoloka</span>
            </a>

            <!-- Middle Nav -->
            <div class="flex gap-4 justify-center items-center">
                <x-nav-link :href="route('events')" :active="request()->routeIs('events')" wire:navigate>
                    {{ __('Events') }}
                </x-nav-link>

                <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')" wire:navigate>
                    {{ __('UMKM') }}
                </x-nav-link>

                <x-nav-link :href="route('services.index')" :active="request()->routeIs('services.index')" wire:navigate>
                    {{ __('Services') }}
                </x-nav-link>
            </div>

            <!-- Right Side -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @guest
                    <!-- Guest: Masuk | Daftar -->
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}" wire:navigate
                            class="px-4 py-2 text-gray-700 hover:text-sky-600 transition font-medium">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" wire:navigate
                            class="rounded-tl-2xl rounded-br-2xl bg-gradient-to-r from-sky-500 to-sky-600 text-white px-8 py-2 hover:opacity-95 transition">
                            Daftar
                        </a>
                    </div>
                @endguest

                @auth
                    <!-- Authenticated Dropdown -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center gap-3 text-sm focus:outline-none">
                                <img src="{{ $avatarUrl }}" alt="Avatar"
                                    class="h-9 w-9 rounded-full object-cover ring-1 ring-primary">
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile')" wire:navigate>
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Logout menggunakan wire:click -->
                            <button wire:click="logout" class="w-full text-start">
                                <x-dropdown-link>
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </button>
                        </x-slot>
                    </x-dropdown>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('events')" :active="request()->routeIs('events')" wire:navigate>
                {{ __('Events') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')" wire:navigate>
                {{ __('UMKM') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('services.index')" :active="request()->routeIs('services.index')" wire:navigate>
                {{ __('Services') }}
            </x-responsive-nav-link>

            @auth
                <x-responsive-nav-link :href="route('profile')" :active="request()->routeIs('profile')" wire:navigate>
                    {{ __('Profile') }}
                </x-responsive-nav-link>
            @endauth
        </div>

        @guest
            <div class="border-t border-gray-200 px-4 py-3 flex items-center justify-between">
                <a href="{{ route('login') }}" wire:navigate
                    class="px-4 py-2 rounded-md text-primary ring-1 ring-primary/20 hover:bg-primary/5 transition">
                    Masuk
                </a>
                <a href="{{ route('register') }}" wire:navigate
                    class="rounded-tl-xl rounded-br-xl bg-gradient-to-r from-primary to-primary-dark text-white px-6 py-2 font-semibold">
                    Daftar
                </a>
            </div>
        @endguest

        @auth
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4 flex items-center gap-3">
                    <img src="{{ $avatarUrl }}" alt="Avatar"
                        class="h-9 w-9 rounded-full object-cover ring-1 ring-gray-200">
                    <div>
                        <div class="font-medium text-base text-gray-800">{{ $user->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ $user->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile')" wire:navigate>
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Logout pakai wire:click -->
                    <button wire:click="logout" class="w-full text-start">
                        <x-responsive-nav-link>
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </button>
                </div>
            </div>
        @endauth
    </div>
</nav>
