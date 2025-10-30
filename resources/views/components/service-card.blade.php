<div class="relative z-10 -mt-32 mx-auto px-4 pb-8 animate-slide-up">
    <div class="bg-white rounded-2xl p-8 max-w-4xl mx-auto shadow-xl border border-sky-100">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Branding Card -->
            <a href="{{ route('services.index') }}"
                class="relative overflow-hidden rounded-xl group cursor-pointer transform transition-all duration-300 hover:-translate-y-2">
                <img src="/images/home/branding.jpg" alt="Branding"
                    class="w-full h-48 object-cover transition duration-500 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-sky-900/70 via-sky-800/30 to-transparent"></div>
                <div class="absolute bottom-4 left-4">
                    <span class="text-white font-semibold text-lg drop-shadow-lg">Branding</span>
                </div>
                <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </a>

            <!-- Promosi Card -->
            <a href="{{ route('services.index') }}"
                class="relative overflow-hidden rounded-xl group cursor-pointer transform transition-all duration-300 hover:-translate-y-2">
                <img src="/images/home/promosi.jpg" alt="Promosi"
                    class="w-full h-48 object-cover transition duration-500 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-sky-900/70 via-sky-800/30 to-transparent"></div>
                <div class="absolute bottom-4 left-4">
                    <span class="text-white font-semibold text-lg drop-shadow-lg">Promosi</span>
                </div>
                <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </a>
        </div>
    </div>
</div>

<style>
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-slide-up {
        animation: slideUp 0.6s ease-out;
    }
</style>
