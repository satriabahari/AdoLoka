<x-app-layout>
    <div class="max-w-3xl mx-auto pt-12 px-4 pb-12">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Status Header -->
            <div class="px-8 pt-8 pb-6 text-center
                @if($order->status === 'paid') bg-gradient-to-br from-green-50 to-green-100
                @elseif($order->status === 'waiting_payment') bg-gradient-to-br from-yellow-50 to-yellow-100
                @elseif($order->status === 'expired') bg-gradient-to-br from-gray-50 to-gray-100
                @else bg-gradient-to-br from-red-50 to-red-100
                @endif">

                <!-- Status Icon -->
                <div class="w-20 h-20 mx-auto mb-4 rounded-full flex items-center justify-center
                    @if($order->status === 'paid') bg-green-500
                    @elseif($order->status === 'waiting_payment') bg-yellow-500
                    @elseif($order->status === 'expired') bg-gray-500
                    @else bg-red-500
                    @endif">
                    @if($order->status === 'paid')
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    @elseif($order->status === 'waiting_payment')
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    @else
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    @endif
                </div>

                <!-- Status Text -->
                <h1 class="text-2xl font-bold text-slate-800 mb-2">
                    @if($order->status === 'paid')
                        Pembayaran Berhasil!
                    @elseif($order->status === 'waiting_payment')
                        Menunggu Pembayaran
                    @elseif($order->status === 'expired')
                        Pembayaran Kadaluarsa
                    @else
                        Pembayaran Gagal
                    @endif
                </h1>

                <p class="text-slate-600">
                    @if($order->status === 'paid')
                        Terima kasih! Pesanan Anda telah berhasil dibayar.
                    @elseif($order->status === 'waiting_payment')
                        Silakan selesaikan pembayaran Anda.
                    @elseif($order->status === 'expired')
                        Waktu pembayaran telah habis.
                    @else
                        Terjadi kesalahan dalam proses pembayaran.
                    @endif
                </p>
            </div>

            <!-- Order Details -->
            <div class="px-8 py-6 space-y-6">
                <!-- Order Number -->
                <div class="flex items-center justify-between pb-4 border-b border-slate-200">
                    <span class="text-sm text-slate-600">Nomor Pesanan</span>
                    <span class="font-semibold text-slate-800">{{ $order->order_number }}</span>
                </div>

                <!-- Item Details -->
                <div class="bg-slate-50 rounded-xl p-4">
                    <h3 class="font-semibold text-slate-800 mb-3">Detail Pesanan</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-slate-600">{{ $order->item_name }}</span>
                            <span class="font-medium text-slate-800">{{ $order->formatted_unit_price }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Jumlah</span>
                            <span class="font-medium text-slate-800">{{ $order->quantity }} item</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Tipe</span>
                            <span class="font-medium text-slate-800">{{ $order->item_type }}</span>
                        </div>
                        @if($order->notes)
                            <div class="pt-2 border-t border-slate-200">
                                <span class="text-sm text-slate-600">Catatan:</span>
                                <p class="text-slate-700 mt-1">{{ $order->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Customer Info -->
                <div class="bg-slate-50 rounded-xl p-4">
                    <h3 class="font-semibold text-slate-800 mb-3">Informasi Pemesan</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-600">Nama</span>
                            <span class="font-medium text-slate-800">{{ $order->customer_name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Email</span>
                            <span class="font-medium text-slate-800">{{ $order->customer_email }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">WhatsApp</span>
                            <span class="font-medium text-slate-800">{{ $order->customer_phone }}</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Info -->
                <div class="bg-slate-50 rounded-xl p-4">
                    <h3 class="font-semibold text-slate-800 mb-3">Informasi Pembayaran</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between text-lg">
                            <span class="text-slate-700">Total Pembayaran</span>
                            <span class="font-bold text-sky-600">{{ $order->formatted_gross_amount }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-600">Status</span>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($order->status === 'paid') bg-green-100 text-green-700
                                @elseif($order->status === 'waiting_payment') bg-yellow-100 text-yellow-700
                                @elseif($order->status === 'expired') bg-gray-100 text-gray-700
                                @else bg-red-100 text-red-700
                                @endif">
                                {{ $order->status_label }}
                            </span>
                        </div>
                        @if($order->payment_type)
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-600">Metode Pembayaran</span>
                                <span class="font-medium text-slate-800">{{ strtoupper($order->payment_type) }}</span>
                            </div>
                        @endif
                        @if($order->paid_at)
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-600">Dibayar pada</span>
                                <span class="font-medium text-slate-800">{{ $order->paid_at->format('d M Y, H:i') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-3 pt-4">
                    <a href="{{ url('/') }}"
                        class="flex-1 px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white rounded-lg font-semibold transition-colors text-center">
                        Kembali ke Beranda
                    </a>

                    @if($order->status === 'paid' && $order->purchasable)
                        <a href="{{ $order->purchasable_type === App\Models\Product::class
                                ? route('products.show', $order->purchasable)
                                : route('services.show', $order->purchasable) }}"
                            class="flex-1 px-6 py-3 bg-white hover:bg-slate-50 text-sky-600 border-2 border-sky-600 rounded-lg font-semibold transition-colors text-center">
                            Lihat Item
                        </a>
                    @endif
                </div>
            </div>
        </div>

        @if($order->status === 'waiting_payment')
            <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <div>
                        <p class="font-medium text-yellow-800 mb-1">Pembayaran Belum Selesai</p>
                        <p class="text-sm text-yellow-700">Silakan selesaikan pembayaran Anda untuk melanjutkan pesanan.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
