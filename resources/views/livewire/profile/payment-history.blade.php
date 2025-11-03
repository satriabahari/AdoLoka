<div class="bg-white rounded-2xl shadow-lg overflow-hidden">
    <!-- Header -->
    <div class="bg-gradient-to-r from-sky-500 to-sky-600 px-6 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-white">Riwayat Pembayaran</h2>
                    <p class="text-sm text-sky-200">Transaksi pembelian Anda</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <!-- Status Filter -->
            <div>
                <label class="block text-xs font-medium text-slate-700 mb-1">Status</label>
                <select wire:model.live="statusFilter"
                    class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                    <option value="all">Semua Status</option>
                    <option value="waiting_payment">Menunggu Pembayaran</option>
                    <option value="paid">Dibayar</option>
                    <option value="expired">Kadaluarsa</option>
                    <option value="failed">Gagal</option>
                </select>
            </div>

            <!-- Type Filter -->
            <div>
                <label class="block text-xs font-medium text-slate-700 mb-1">Tipe</label>
                <select wire:model.live="typeFilter"
                    class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                    <option value="all">Semua Tipe</option>
                    <option value="product">Produk</option>
                    <option value="service">Layanan</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Orders List -->
    <div class="p-6">
        @if ($orders->count() > 0)
            <div class="space-y-4">
                @foreach ($orders as $order)
                    <div
                        class="border border-slate-200 rounded-xl p-4 hover:shadow-md transition-shadow bg-gradient-to-br from-white to-slate-50">
                        <div class="flex items-start justify-between gap-4">
                            <!-- Order Info -->
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <h3 class="font-semibold text-slate-800">{{ $order->item_name }}</h3>
                                    <span
                                        class="px-2 py-0.5 text-xs font-medium rounded-full
                                        {{ $order->purchasable_type === 'App\Models\Product' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                        {{ $order->item_type }}
                                    </span>
                                </div>

                                <div class="flex flex-wrap items-center gap-3 text-sm text-slate-600 mb-3">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                        </svg>
                                        {{ $order->order_number }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $order->created_at->format('d M Y, H:i') }}
                                    </span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="text-sm">
                                        <span class="text-slate-600">{{ $order->quantity }}x</span>
                                        <span
                                            class="font-bold text-sky-600 ml-2">{{ $order->formatted_gross_amount }}</span>
                                    </div>

                                    <!-- Status Badge -->
                                    <span
                                        class="px-3 py-1 text-xs font-semibold rounded-full
                                        @if ($order->status === 'paid') bg-green-100 text-green-700
                                        @elseif($order->status === 'waiting_payment') bg-yellow-100 text-yellow-700
                                        @elseif($order->status === 'expired') bg-gray-100 text-gray-700
                                        @else bg-red-100 text-red-700 @endif">
                                        {{ $order->status_label }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="mt-3 pt-3 border-t border-slate-200">
                            <a href="{{ route('payment.status', $order->order_number) }}"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-sky-50 hover:bg-sky-100 text-sky-700 rounded-lg text-sm font-medium transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="w-20 h-20 bg-slate-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-slate-800 mb-2">Belum Ada Transaksi</h3>
                <p class="text-slate-600 mb-6">Anda belum melakukan pembelian</p>
                <div class="flex items-center justify-center gap-3">
                    <a href="{{ route('products.index') }}"
                        class="px-6 py-2 bg-sky-600 hover:bg-sky-700 text-white rounded-lg font-medium transition-colors">
                        Belanja Produk
                    </a>
                    <a href="{{ route('services.index') }}"
                        class="px-6 py-2 bg-white hover:bg-slate-50 text-sky-600 border-2 border-sky-600 rounded-lg font-medium transition-colors">
                        Lihat Layanan
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
