{{-- <?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }" class="bg-white fixed top-0 inset-x-0 z-[99] drop-shadow-xl">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="shrink-0 flex items-center">
                <a href="{{ route('home') }}" wire:navigate>
                    <img src="/images/logo.png" class="h-[40px]" />
                </a>
            </div>

            <div class="flex gap-4 justify-center items-center">
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('events')" :active="request()->routeIs('events')" wire:navigate>
                        {{ __('Events') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('products')" :active="request()->routeIs('products')" wire:navigate>
                        {{ __('UMKM') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('services')" :active="request()->routeIs('services')" wire:navigate>
                        {{ __('Services') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('profile')" :active="request()->routeIs('profile')" wire:navigate>
                        {{ __('Profile') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name"
                                x-on:profile-updated.window="name = $event.detail.name"></div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile')" wire:navigate>
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>

                <button
                    class="rounded-tl-2xl rounded-br-2xl bg-gradient-to-r from-[#114177] via-[#006A9A] to-[#17A18A] text-white px-8 py-2 text-bold">
                    Daftar
                </button>
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

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name"
                    x-on:profile-updated.window="name = $event.detail.name"></div>
                <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile')" wire:navigate>
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>
</nav> --}}




<nav x-data="{ open: false }" class="bg-white fixed top-0 inset-x-0 z-[99] drop-shadow-xl">
    @php
        $user = auth()->user();
        $avatarUrl = null;

        if ($user) {
            // Ganti 'avatar' jika koleksi avatarmu berbeda
            try {
                $avatarUrl = $user->getFirstMediaUrl('avatar') ?: null;
            } catch (\Throwable $e) {
                $avatarUrl = null; // jaga-jaga jika model belum pakai InteractsWithMedia
            }

            $avatarUrl = $avatarUrl ?: asset('images/placeholder.png');
        }
    @endphp

    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-12">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="shrink-0 flex items-center gap-3">
                <a href="{{ route('home') }}" wire:navigate>
                    <img src="/images/logo.png" class="h-[34px]" alt="Logo">
                </a>
                <span class="font-bold text-2xl text-gray-900">Adoloka</span>
            </div>

            <!-- Middle Nav -->
            <div class="flex gap-4 justify-center items-center">
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('events')" :active="request()->routeIs('events')" wire:navigate>
                        {{ __('Events') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')" wire:navigate>
                        {{ __('UMKM') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('services.index')" :active="request()->routeIs('services.index')" wire:navigate>
                        {{ __('Services') }}
                    </x-nav-link>
                </div>
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
                    <!-- Auth: Avatar + Dropdown -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center gap-3 text-sm focus:outline-none">
                                <img src="{{ $avatarUrl }}" alt="Avatar"
                                    class="h-9 w-9 rounded-full object-cover ring-1 ring-gray-200">
                                {{-- <svg class="h-4 w-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M5.23 7.21a.75.75 0 011.06.02L10 11.19l3.71-3.96a.75.75 0 111.08 1.04l-4.25 4.53a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z"
                                        clip-rule="evenodd" />
                                </svg> --}}
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile')" wire:navigate>
                                {{ __('Profile') }}
                            </x-dropdown-link>

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

    <!-- Responsive Navigation Menu -->
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

        <!-- Responsive Settings Options -->
        @guest
            <div class="border-t border-gray-200 px-4 py-3 flex items-center justify-between">
                <a href="{{ route('login') }}" wire:navigate
                    class="px-4 py-2 rounded-md text-[#114177] ring-1 ring-[#114177]/20 hover:bg-[#114177]/5 transition">
                    Masuk
                </a>
                <a href="{{ route('register') }}" wire:navigate
                    class="rounded-tl-xl rounded-br-xl bg-gradient-to-r from-[#114177] via-[#006A9A] to-[#17A18A] text-white px-6 py-2 font-semibold">
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
