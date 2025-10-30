<div x-data="{ openFaq: null }" class="bg-gradient-to-b from-white to-sky-50 py-16 px-8 md:px-16">
    <div class="container mx-auto px-4">
        <div class="w-full flex justify-between flex-col md:flex-row gap-12">
            <!-- Left Section -->
            <div class="animate-slide-in-left">
                <div class="mb-12 w-96 max-w-full">
                    <span class="inline-block text-sm font-semibold text-sky-600 bg-sky-100 px-4 py-1 rounded-full mb-4">
                        FAQ
                    </span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Pertanyaan Yang Sering
                        <span class="text-sky-600">
                            Ditanyakan
                        </span>
                    </h2>
                    <p class="text-gray-600 text-lg">
                        Berikut ada banyak pertanyaan yang sering diajukan beserta jawabannya.
                    </p>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="space-y-4 md:w-1/2 animate-slide-in-right">
                <!-- FAQ Item 1 -->
                <div class="bg-white rounded-xl shadow-sm border-2 border-gray-100 hover:border-sky-300 hover:shadow-lg transition-all duration-300"
                    :class="{ 'border-sky-400 shadow-md': openFaq === 1 }">
                    <button @click="openFaq === 1 ? openFaq = null : openFaq = 1"
                        class="w-full px-6 py-5 flex items-center justify-between text-left group">
                        <span class="font-semibold text-gray-900 group-hover:text-sky-600 transition-colors">
                            Apa keunggulan platform AdoLoka?
                        </span>
                        <div
                            class="w-8 h-8 rounded-full flex items-center justify-center bg-sky-50 group-hover:bg-sky-100 transition-colors flex-shrink-0 ml-4">
                            <svg :class="{ 'rotate-90': openFaq === 1 }"
                                class="w-5 h-5 text-sky-600 transition-transform duration-300" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </button>

                    <!-- Answer -->
                    <div x-show="openFaq === 1" x-collapse class="px-6 pb-5">
                        <div class="pt-2 border-t border-sky-100">
                            <p class="text-gray-600 leading-relaxed">
                                AdoLoka menawarkan koneksi langsung antara UMKM dengan event organizer, proses
                                verifikasi terpercaya, dan kemudahan dalam promosi bisnis Anda.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="bg-white rounded-xl shadow-sm border-2 border-gray-100 hover:border-sky-300 hover:shadow-lg transition-all duration-300"
                    :class="{ 'border-sky-400 shadow-md': openFaq === 2 }">
                    <button @click="openFaq === 2 ? openFaq = null : openFaq = 2"
                        class="w-full px-6 py-5 flex items-center justify-between text-left group">
                        <span class="font-semibold text-gray-900 group-hover:text-sky-600 transition-colors">
                            Berapa biaya bergabung di AdoLoka?
                        </span>
                        <div
                            class="w-8 h-8 rounded-full flex items-center justify-center bg-sky-50 group-hover:bg-sky-100 transition-colors flex-shrink-0 ml-4">
                            <svg :class="{ 'rotate-90': openFaq === 2 }"
                                class="w-5 h-5 text-sky-600 transition-transform duration-300" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </button>

                    <!-- Answer -->
                    <div x-show="openFaq === 2" x-collapse class="px-6 pb-5">
                        <div class="pt-2 border-t border-sky-100">
                            <p class="text-gray-600 leading-relaxed">
                                Biaya bergabung disesuaikan dengan paket layanan yang Anda pilih. Hubungi tim kami untuk
                                informasi detail mengenai harga.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="bg-white rounded-xl shadow-sm border-2 border-gray-100 hover:border-sky-300 hover:shadow-lg transition-all duration-300"
                    :class="{ 'border-sky-400 shadow-md': openFaq === 3 }">
                    <button @click="openFaq === 3 ? openFaq = null : openFaq = 3"
                        class="w-full px-6 py-5 flex items-center justify-between text-left group">
                        <span class="font-semibold text-gray-900 group-hover:text-sky-600 transition-colors">
                            Apakah AdoLoka aman dan terpercaya?
                        </span>
                        <div
                            class="w-8 h-8 rounded-full flex items-center justify-center bg-sky-50 group-hover:bg-sky-100 transition-colors flex-shrink-0 ml-4">
                            <svg :class="{ 'rotate-90': openFaq === 3 }"
                                class="w-5 h-5 text-sky-600 transition-transform duration-300" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </button>

                    <!-- Answer -->
                    <div x-show="openFaq === 3" x-collapse class="px-6 pb-5">
                        <div class="pt-2 border-t border-sky-100">
                            <p class="text-gray-600 leading-relaxed">
                                Ya, AdoLoka menggunakan sistem verifikasi ketat dan menjamin transparansi dalam setiap
                                transaksi dan kolaborasi.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="bg-white rounded-xl shadow-sm border-2 border-gray-100 hover:border-sky-300 hover:shadow-lg transition-all duration-300"
                    :class="{ 'border-sky-400 shadow-md': openFaq === 4 }">
                    <button @click="openFaq === 4 ? openFaq = null : openFaq = 4"
                        class="w-full px-6 py-5 flex items-center justify-between text-left group">
                        <span class="font-semibold text-gray-900 group-hover:text-sky-600 transition-colors">
                            Saya masih ada pertanyaan
                        </span>
                        <div
                            class="w-8 h-8 rounded-full flex items-center justify-center bg-sky-50 group-hover:bg-sky-100 transition-colors flex-shrink-0 ml-4">
                            <svg :class="{ 'rotate-90': openFaq === 4 }"
                                class="w-5 h-5 text-sky-600 transition-transform duration-300" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </button>

                    <!-- Answer -->
                    <div x-show="openFaq === 4" x-collapse class="px-6 pb-5">
                        <div class="pt-2 border-t border-sky-100">
                            <p class="text-gray-600 leading-relaxed">
                                Silakan hubungi tim dukungan kami melalui halaman kontak untuk mendapatkan bantuan lebih
                                lanjut.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-50px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(50px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .animate-slide-in-left {
        animation: slideInLeft 0.8s ease-out;
    }

    .animate-slide-in-right {
        animation: slideInRight 0.8s ease-out;
    }

    [x-cloak] {
        display: none !important;
    }
</style>
