@push('styles')
    @vite('resources/css/registration.css')
@endpush

<div class="w-full">

    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-primary to-primary-dark rounded-full flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <span class="font-bold text-xl text-gray-900">UMKM Platform</span>
                </div>
                <nav class="hidden md:flex space-x-8">
                    <a href="#" class="text-gray-700 hover:text-primary-dark transition">Event</a>
                    <a href="#" class="text-gray-700 hover:text-primary-dark transition">UMKM</a>
                    <a href="#" class="text-gray-700 hover:text-primary-dark transition">Member</a>
                </nav>
                <div class="flex space-x-3">
                    <a href="/login"
                        class="px-4 py-2 text-gray-700 hover:text-primary-dark transition font-medium">Masuk</a>
                    <a href="/register"
                        class="px-6 py-2 bg-gradient-to-r from-primary to-primary-dark text-white rounded-lg hover:from-primary-dark hover:to-teal-700 transition shadow-md hover:shadow-lg font-medium">Daftar</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Progress Indicator -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="flex items-center justify-between relative">
                <!-- Step 1 -->
                <div
                    class="progress-step {{ $currentStep >= 1 ? 'active' : '' }} {{ $currentStep > 1 ? 'completed' : '' }} flex-1 text-center">
                    <div
                        class="step-circle w-10 h-10 rounded-full border-2 border-gray-300 flex items-center justify-center mx-auto font-bold transition-all duration-300">
                        @if ($currentStep > 1)
                            <x-bi-check />
                        @else
                            1
                        @endif
                    </div>
                    <p class="text-xs mt-2 font-medium text-gray-600">Data Pengguna</p>
                </div>

                <!-- Step 2 -->
                <div
                    class="progress-step {{ $currentStep >= 2 ? 'active' : '' }} {{ $currentStep > 2 ? 'completed' : '' }} flex-1 text-center">
                    <div
                        class="step-circle w-10 h-10 rounded-full border-2 border-gray-300 flex items-center justify-center mx-auto font-bold transition-all duration-300">
                        @if ($currentStep > 2)
                            <x-bi-check />
                        @else
                            2
                        @endif
                    </div>
                    <p class="text-xs mt-2 font-medium text-gray-600">Data UMKM</p>
                </div>


                <!-- Step 3 -->
                <div class="progress-step {{ $currentStep >= 3 ? 'active' : '' }} flex-1 text-center">
                    <div
                        class="step-circle w-10 h-10 rounded-full border-2 border-gray-300 flex items-center justify-center mx-auto font-bold transition-all duration-300">
                        3
                    </div>
                    <p class="text-xs mt-2 font-medium text-gray-600">Data Produk</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <div class="max-w-6xl mx-auto">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <div class="flex flex-col lg:flex-row min-h-[600px]">
                    <!-- Illustration Section -->
                    <div class="lg:w-1/2 illustration-wrapper p-8 lg:p-12 relative">
                        <div class="relative z-10 h-full flex flex-col justify-center">
                            <!-- Decorative elements -->
                            <div class="absolute top-10 left-10 w-20 h-20 bg-primary rounded-full opacity-30 floating"
                                style="animation-delay: 0s;"></div>
                            <div class="absolute top-32 right-16 w-16 h-16 bg-primary rounded-full opacity-40 floating"
                                style="animation-delay: 1s;"></div>
                            <div class="absolute bottom-20 right-10 w-32 h-32 bg-purple-400 rounded-full opacity-20 floating"
                                style="animation-delay: 2s;"></div>

                            <!-- Chat bubble -->
                            <div class="absolute top-16 left-12 bg-blue-500 rounded-2xl p-3 shadow-lg floating"
                                style="animation-delay: 0.5s;">
                                <div class="flex space-x-2">
                                    <div class="w-2 h-2 bg-white rounded-full"></div>
                                    <div class="w-2 h-2 bg-white rounded-full"></div>
                                    <div class="w-2 h-2 bg-white rounded-full"></div>
                                </div>
                            </div>

                            <!-- Main illustration -->
                            <div class="relative mt-8 mb-8">
                                <div class="w-full max-w-md mx-auto floating">
                                    <svg viewBox="0 0 400 500" class="w-full h-full drop-shadow-2xl">
                                        <!-- Character -->
                                        <ellipse cx="200" cy="400" rx="150" ry="30"
                                            fill="#1e40af" opacity="0.2" />

                                        <!-- Legs -->
                                        <path d="M 180 350 Q 170 400 175 450" stroke="#3b4371" stroke-width="14"
                                            fill="none" stroke-linecap="round" />
                                        <path d="M 220 350 Q 230 400 225 450" stroke="#3b4371" stroke-width="14"
                                            fill="none" stroke-linecap="round" />

                                        <!-- Shoes -->
                                        <ellipse cx="175" cy="455" rx="22" ry="12"
                                            fill="#3b4371" />
                                        <ellipse cx="225" cy="455" rx="22" ry="12"
                                            fill="#3b4371" />

                                        <!-- Shoe laces -->
                                        <line x1="170" y1="450" x2="180" y2="450" stroke="white"
                                            stroke-width="2" />
                                        <line x1="220" y1="450" x2="230" y2="450" stroke="white"
                                            stroke-width="2" />

                                        <!-- Socks -->
                                        <rect x="163" y="430" width="24" height="28" fill="#ff6b35"
                                            rx="3" />
                                        <rect x="213" y="430" width="24" height="28" fill="#ff6b35"
                                            rx="3" />
                                        <line x1="163" y1="442" x2="187" y2="442"
                                            stroke="white" stroke-width="3" opacity="0.8" />
                                        <line x1="213" y1="442" x2="237" y2="442"
                                            stroke="white" stroke-width="3" opacity="0.8" />

                                        <!-- Body/Skirt -->
                                        <path d="M 200 220 L 155 350 L 245 350 Z" fill="#5865c3" />
                                        <path d="M 200 220 L 155 350 L 245 350 Z" fill="#4a56b3" opacity="0.3" />

                                        <!-- Shirt -->
                                        <rect x="168" y="180" width="64" height="52" fill="#ff6b35"
                                            rx="6" />

                                        <!-- Arms -->
                                        <path d="M 168 190 Q 135 215 145 245" stroke="#ffb38a" stroke-width="12"
                                            fill="none" stroke-linecap="round" />
                                        <path d="M 232 190 Q 265 215 255 245" stroke="#ffb38a" stroke-width="12"
                                            fill="none" stroke-linecap="round" />

                                        <!-- Hands -->
                                        <circle cx="145" cy="245" r="10" fill="#ffb38a" />
                                        <circle cx="255" cy="245" r="10" fill="#ffb38a" />

                                        <!-- Necklace -->
                                        <circle cx="200" cy="208" r="10" fill="white" stroke="#ffd700"
                                            stroke-width="3" />
                                        <ellipse cx="200" cy="208" rx="6" ry="6"
                                            fill="#ffd700" opacity="0.5" />

                                        <!-- Head -->
                                        <ellipse cx="200" cy="150" rx="42" ry="52"
                                            fill="#ffb38a" />

                                        <!-- Ears -->
                                        <ellipse cx="162" cy="150" rx="8" ry="12"
                                            fill="#ffb38a" />
                                        <ellipse cx="238" cy="150" rx="8" ry="12"
                                            fill="#ffb38a" />

                                        <!-- Hair -->
                                        <path
                                            d="M 158 128 Q 175 75 200 88 Q 225 75 242 128 L 242 172 Q 225 185 200 185 Q 175 185 158 172 Z"
                                            fill="#3b4371" />
                                        <ellipse cx="180" cy="100" rx="15" ry="25"
                                            fill="#3b4371" />
                                        <ellipse cx="220" cy="100" rx="15" ry="25"
                                            fill="#3b4371" />

                                        <!-- Face -->
                                        <circle cx="182" cy="145" r="5" fill="#2d1f3f" />
                                        <circle cx="218" cy="145" r="5" fill="#2d1f3f" />
                                        <circle cx="183" cy="146" r="2" fill="white" opacity="0.8" />
                                        <circle cx="219" cy="146" r="2" fill="white" opacity="0.8" />

                                        <!-- Smile -->
                                        <path d="M 185 162 Q 200 172 215 162" stroke="#2d1f3f" stroke-width="3"
                                            fill="none" stroke-linecap="round" />

                                        <!-- Cheeks -->
                                        <ellipse cx="172" cy="158" rx="8" ry="5"
                                            fill="#ff9999" opacity="0.4" />
                                        <ellipse cx="228" cy="158" rx="8" ry="5"
                                            fill="#ff9999" opacity="0.4" />

                                        <!-- Plant -->
                                        <rect x="275" y="315" width="65" height="75" fill="#3b4371"
                                            rx="6" />
                                        <rect x="280" y="320" width="55" height="10" fill="#2d2d4f" />

                                        <!-- Plant leaves -->
                                        <ellipse cx="307" cy="275" rx="32" ry="55"
                                            fill="#4ade80" />
                                        <ellipse cx="290" cy="295" rx="22" ry="38"
                                            fill="#22c55e" />
                                        <ellipse cx="324" cy="295" rx="22" ry="38"
                                            fill="#22c55e" />
                                        <ellipse cx="307" cy="260" rx="25" ry="35"
                                            fill="#86efac" />

                                        <!-- Plant dots -->
                                        <circle cx="297" cy="285" r="5" fill="white" opacity="0.6" />
                                        <circle cx="315" cy="305" r="4" fill="white" opacity="0.6" />
                                        <circle cx="307" cy="270" r="4" fill="white" opacity="0.6" />

                                        <!-- Dashboard mockup -->
                                        <rect x="245" y="115" width="145" height="115" fill="#2d3b5f"
                                            rx="6" />
                                        <rect x="250" y="120" width="135" height="105" fill="white"
                                            rx="4" />

                                        <!-- Browser dots -->
                                        <circle cx="258" cy="128" r="3" fill="#ff5f56" />
                                        <circle cx="268" cy="128" r="3" fill="#ffbd2e" />
                                        <circle cx="278" cy="128" r="3" fill="#27c93f" />

                                        <!-- User avatar -->
                                        <circle cx="270" cy="150" r="12" fill="#3b82f6" />
                                        <path d="M 270 145 L 270 155 M 265 150 L 275 150" stroke="white"
                                            stroke-width="2" stroke-linecap="round" />

                                        <!-- Dashboard lines -->
                                        <rect x="288" y="143" width="80" height="4" fill="#e5e7eb"
                                            rx="2" />
                                        <rect x="288" y="152" width="60" height="4" fill="#e5e7eb"
                                            rx="2" />

                                        <!-- Grid -->
                                        <g transform="translate(255, 165)">
                                            <rect x="0" y="0" width="16" height="16" fill="#3b82f6"
                                                rx="3" />
                                            <rect x="22" y="0" width="16" height="16" fill="#3b82f6"
                                                rx="3" />
                                            <rect x="44" y="0" width="16" height="16" fill="#3b82f6"
                                                rx="3" />
                                            <rect x="66" y="0" width="16" height="16" fill="#3b82f6"
                                                rx="3" />
                                            <rect x="88" y="0" width="16" height="16" fill="#3b82f6"
                                                rx="3" />
                                            <rect x="110" y="0" width="16" height="16" fill="#3b82f6"
                                                rx="3" />
                                            <rect x="0" y="22" width="16" height="16" fill="#3b82f6"
                                                rx="3" />
                                            <rect x="22" y="22" width="16" height="16" fill="#3b82f6"
                                                rx="3" />
                                            <rect x="44" y="22" width="16" height="16" fill="#3b82f6"
                                                rx="3" />
                                            <rect x="66" y="22" width="16" height="16" fill="#3b82f6"
                                                rx="3" />
                                            <rect x="88" y="22" width="16" height="16" fill="#3b82f6"
                                                rx="3" />
                                            <rect x="110" y="22" width="16" height="16" fill="#3b82f6"
                                                rx="3" />
                                        </g>

                                        <!-- Trophy -->
                                        <g transform="translate(305, 195)">
                                            <path d="M 5 0 L 8 12 L 12 12 L 15 0 Z" fill="#fbbf24" />
                                            <rect x="7" y="12" width="6" height="10" fill="#fbbf24"
                                                rx="1" />
                                            <rect x="4" y="22" width="12" height="5" fill="#fbbf24"
                                                rx="2" />
                                            <circle cx="10" cy="5" r="2" fill="#fde047" />
                                        </g>

                                        <!-- Progress lines -->
                                        <rect x="260" y="205" width="100" height="3" fill="#3b82f6"
                                            opacity="0.5" rx="2" />
                                        <rect x="260" y="212" width="80" height="3" fill="#3b82f6"
                                            opacity="0.5" rx="2" />
                                        <rect x="260" y="219" width="70" height="3" fill="#3b82f6"
                                            opacity="0.5" rx="2" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Info text -->
                            <div class="text-center text-white space-y-2">
                                <h3 class="text-2xl font-bold">Bergabung dengan Kami!</h3>
                                <p class="text-blue-100 text-sm">Daftarkan UMKM Anda dan jangkau lebih banyak pelanggan
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Form Section -->
                    <div class="lg:w-1/2 p-8 lg:p-12 bg-white slide-in">
                        @if ($currentStep == 1)
                            @include('livewire.pages.auth.user-registration')
                        @elseif ($currentStep == 2)
                            @include('livewire.pages.auth.umkm-registration')
                        @elseif ($currentStep == 3)
                            @include('livewire.pages.auth.product-registration')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@livewireScripts

<script>
    // Update URL when step changes
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('updateUrl', (event) => {
            const step = event.step;
            const url = new URL(window.location);
            url.searchParams.set('step', step);
            window.history.pushState({}, '', url);
        });
    });
</script>
