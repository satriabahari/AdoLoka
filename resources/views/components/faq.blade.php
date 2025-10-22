{{-- <div x-data="{ openFaq: null }" class="bg-white py-16 px-16">
    <div class="container px-4">
        <div class="w-full flex justify-between flex-col md:flex-row gap-8">
            <!-- Left Section -->
            <div>
                <div class="mb-12 w-96 max-w-full">
                    <h3
                        class="text-sm font-semibold bg-gradient-to-r from-[#114177] via-[#006A9A] to-[#17A18A] bg-clip-text text-transparent mb-2">
                        FAQ
                    </h3>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                        Pertanyaan Yang Sering
                        <span
                            class="bg-gradient-to-r from-[#114177] via-[#006A9A] to-[#17A18A] bg-clip-text text-transparent">
                            Ditanyakan
                        </span>
                    </h2>
                    <p class="text-gray-600">
                        Berikut ada banyak pertanyaan yang sering diajukan beserta jawabannya.
                    </p>
                </div>
                <button
                    class="bg-gradient-to-r from-[#114177] via-[#006A9A] to-[#17A18A] text-white font-semibold px-8 py-3 rounded-lg transition duration-300 shadow-lg">
                    Daftar Member
                </button>
            </div>

            <!-- FAQ Section -->
            <div class="space-y-4 md:w-1/2">
                <!-- Template FAQ Item -->
                <template
                    x-for="(faq, index) in [
                    { question: 'Apa keunggulan GatesflycliAction payment gateway Paywin?', answer: 'GatesflycliAction menawarkan proses pembayaran cepat, aman, dan mendukung berbagai metode pembayaran lokal maupun internasional.' },
                    { question: 'Berapa biaya menggunakan GatesPay?', answer: 'GatesPay memiliki biaya transaksi kompetitif yang disesuaikan dengan volume dan jenis transaksi Anda.' },
                    { question: 'Apakah GatesPay aman?', answer: 'Ya, GatesPay menggunakan enkripsi SSL dan sertifikasi keamanan PCI DSS Level 1.' },
                    { question: 'Saya masih ada pertanyaan', answer: 'Silakan hubungi tim dukungan kami melalui halaman kontak untuk mendapatkan bantuan lebih lanjut.' }
                ]"
                    :key="index">
                    <div
                        class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition duration-300">
                        <button @click="openFaq === index ? openFaq = null : openFaq = index"
                            class="w-full px-6 py-4 flex items-center justify-between text-left">
                            <span class="font-semibold text-gray-900" x-text="faq.question"></span>
                            <svg :class="{ 'rotate-90 text-[#006A9A]': openFaq === index }"
                                class="w-5 h-5 text-gray-500 flex-shrink-0 ml-4 transition-transform duration-300"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        <!-- Answer -->
                        <div x-show="openFaq === index" x-collapse class="px-6 pb-4 text-gray-600">
                            <p x-text="faq.answer"></p>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>

<!-- Tambahkan Alpine.js jika belum -->
<script src="//unpkg.com/alpinejs" defer></script> --}}

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

<!-- Tambahkan Alpine.js jika belum -->
<script src="//unpkg.com/alpinejs" defer></script>

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
