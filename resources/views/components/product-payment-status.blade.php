<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 py-12">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden animate-fade-in">
            <!-- Status Header -->
            @if ($order->payment_status === 'paid')
                <div class="bg-gradient-to-r from-green-500 to-green-600 p-8 text-center">
                    <div
                        class="w-20 h-20 bg-white rounded-full mx-auto mb-4 flex items-center justify-center animate-bounce-in">
                        <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">Pembayaran Berhasil!</h1>
                    <p class="text-green-100">Terima kasih atas pembelian Anda</p>
                </div>
            @elseif($order->payment_status === 'pending')
                <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 p-8 text-center">
                    <div class="w-20 h-20 bg-white rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-12 h-12 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">Menunggu Pembayaran</h1>
                    <p class="text-yellow-100">Silakan selesaikan pembayaran Anda</p>
                </div>
            @else
                <div class="bg-gradient-to-r from-red-500 to-red-600 p-8 text-center">
                    <div class="w-20 h-20 bg-white rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">Pembayaran Gagal</h1>
                    <p class="text-red-100">Terjadi kesalahan dalam proses pembayaran</p>
                </div>
            @endif

            <!-- Order Details -->
            <div class="p-8">
                <!-- Order Number -->
                <div class="bg-slate-50 rounded-lg p-4 mb-6">
                    <p class="text-sm text-slate-600 mb-1">Nomor Pesanan</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $order->order_number }}</p>
                </div>

                <!-- Customer Info -->
                <div class="mb-6">
                    <h2 class="text-lg font-bold text-slate-800 mb-4">Informasi Pembeli</h2>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-slate-600">Nama:</span>
                            <span class="font-medium text-slate-800">{{ $order->customer_name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Email:</span>
                            <span class="font-medium text-slate-800">{{ $order->customer_email }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">WhatsApp:</span>
                            <span class="font-medium text-slate-800">{{ $order->customer_phone }}</span>
                        </div>
                    </div>
                </div>

                <!-- Product Details -->
                <div class="border-t border-slate-200 pt-6 mb-6">
                    <h2 class="text-lg font-bold text-slate-800 mb-4">Detail Produk</h2>
                    <div class="bg-sky-50 rounded-lg p-4">
                        <div class="flex items-start gap-4">
                            <div class="w-20 h-20 rounded-lg overflow-hidden flex-shrink-0">
                                <img src="{{ $order->product->image_url }}" alt="{{ $order->product->name }}"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <span class="text-xs font-semibold text-sky-600 bg-sky-100 px-2 py-1 rounded-full">
                                    {{ $order->product->category->name }}
                                </span>
                                <h3 class="font-bold text-slate-800 mt-2 mb-1">{{ $order->product->name }}</h3>
                                <p class="text-sm text-slate-600 mb-2 line-clamp-2">{{ $order->product->description }}
                                </p>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-slate-600">Jumlah:
                                        <strong>{{ $order->quantity }}x</strong></span>
                                    <span class="text-sm font-medium text-slate-800">
                                        Rp {{ number_format($order->price_per_unit, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($order->notes)
                        <div class="mt-4">
                            <p class="text-sm font-medium text-slate-700 mb-2">Catatan:</p>
                            <p class="text-sm text-slate-600 bg-slate-50 p-3 rounded-lg">{{ $order->notes }}</p>
                        </div>
                    @endif
                </div>

                <!-- Total -->
                <div class="border-t border-slate-200 pt-6 mb-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-slate-600">Subtotal</span>
                        <span class="font-medium text-slate-800">Rp
                            {{ number_format((float) $order->total_amount, 0, ',', '.') }}</span>
                    </div>
                    <div
                        class="flex items-center justify-between text-xl font-bold text-sky-600 pt-4 border-t border-slate-200">
                        <span>Total</span>
                        <span>Rp {{ number_format((float) $order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Payment Status Info -->
                @if ($order->payment_status === 'paid')
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-green-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div>
                                <p class="font-medium text-green-800 mb-1">Pembayaran Dikonfirmasi</p>
                                <p class="text-sm text-green-700">
                                    Pesanan Anda sedang diproses.
                                    @if ($order->product->umkm)
                                        {{ $order->product->umkm->name }} akan segera menghubungi Anda.
                                    @else
                                        Kami akan segera menghubungi Anda.
                                    @endif
                                </p>
                                @if ($order->paid_at)
                                    <p class="text-xs text-green-600 mt-2">
                                        Dibayar pada: {{ $order->paid_at->format('d M Y, H:i') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @elseif($order->payment_status === 'pending')
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div>
                                <p class="font-medium text-yellow-800 mb-1">Menunggu Pembayaran</p>
                                <p class="text-sm text-yellow-700">
                                    Silakan selesaikan pembayaran Anda untuk melanjutkan proses pesanan.
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-red-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div>
                                <p class="font-medium text-red-800 mb-1">Pembayaran Gagal atau Kadaluarsa</p>
                                <p class="text-sm text-red-700">Silakan hubungi kami untuk bantuan lebih lanjut.</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('products.index') }}"
                        class="flex-1 px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white rounded-lg font-medium transition-colors text-center">
                        Lihat Produk Lain
                    </a>

                    @if ($order->product->umkm && $order->product->umkm->whatsapp)
                        <a href="https://wa.me/{{ $order->product->umkm->whatsapp }}" target="_blank"
                            class="flex-1 px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors text-center flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                            </svg>
                            Hubungi Penjual
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        .animate-bounce-in {
            animation: bounceIn 0.8s ease-out;
        }
    </style>
</x-app-layout>
