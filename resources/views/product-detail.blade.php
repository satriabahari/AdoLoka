<x-app-layout>
    <div class="max-w-5xl mx-auto pt-12 px-4">
        <!-- Back Button -->
        <button onclick="window.history.back()"
            class="flex items-center gap-2 text-primary-600 hover:text-primary-700 transition-colors mb-8">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <span class="font-medium">Kembali</span>
        </button>

        <!-- Product Detail Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="grid md:grid-cols-2 gap-8 p-8">
                <!-- Product Image -->
                <div class="space-y-4">
                    <div
                        class="relative h-96 rounded-2xl overflow-hidden bg-gradient-to-br from-primary-100 to-primary-200 group">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">

                        <!-- Category Badge -->
                        <div class="absolute top-4 left-4">
                            <span
                                class="px-4 py-2 bg-white/90 backdrop-blur-sm text-primary-600 rounded-full text-sm font-semibold shadow-lg">
                                {{ $product->category->name }}
                            </span>
                        </div>

                        @if ($product->stock < 10 && $product->stock > 0)
                            <div
                                class="absolute top-4 right-4 bg-yellow-500 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg">
                                Stok Terbatas
                            </div>
                        @elseif($product->stock == 0)
                            <div
                                class="absolute top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg">
                                Stok Habis
                            </div>
                        @endif
                    </div>

                    <!-- UMKM Info -->
                    @if ($product->umkm)
                        <div class="bg-primary-50 rounded-xl p-4 border-2 border-primary-100">
                            <p class="text-xs text-primary-600 font-semibold mb-1">Dijual oleh</p>
                            <h3 class="text-lg font-bold text-primary-900">{{ $product->umkm->name }}</h3>
                            @if ($product->umkm->address)
                                <p class="text-sm text-slate-600 mt-1">{{ $product->umkm->address }}</p>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="space-y-6">
                    <div>
                        <h1 class="text-3xl font-bold text-slate-800 mb-4">{{ $product->name }}</h1>
                        <p class="text-slate-600 leading-relaxed">{{ $product->description }}</p>
                    </div>

                    <!-- Price & Stock -->
                    <div
                        class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-xl p-6 border-2 border-primary-200">
                        <p class="text-sm text-slate-600 mb-2">Harga</p>
                        <p class="text-4xl font-bold text-primary-600 mb-4">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            <span class="text-slate-600">Stok tersedia: <strong
                                    class="text-primary-600">{{ $product->stock }}</strong></span>
                        </div>
                    </div>

                    <!-- Quantity Selector -->
                    <div class="bg-slate-50 rounded-xl p-6">
                        <label class="block text-sm font-semibold text-slate-700 mb-3">Jumlah Pembelian</label>
                        <div class="flex items-center gap-4">
                            <div
                                class="flex items-center gap-2 bg-white rounded-lg shadow-md border-2 border-slate-200">
                                <button type="button" id="decrease-qty"
                                    class="px-4 py-3 hover:bg-primary-50 rounded-l-lg transition-colors">
                                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 12H4" />
                                    </svg>
                                </button>
                                <input type="number" id="quantity" value="1" min="1"
                                    max="{{ $product->stock }}"
                                    class="w-20 text-center font-bold text-xl text-slate-800 border-0 focus:ring-0"
                                    readonly>
                                <button type="button" id="increase-qty"
                                    class="px-4 py-3 hover:bg-primary-50 rounded-r-lg transition-colors">
                                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-slate-600">Total Harga</p>
                                <p id="total-price" class="text-2xl font-bold text-primary-600">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Notes Only -->
                    <div class="bg-slate-50 rounded-xl p-6">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Catatan Pesanan (Opsional)</label>
                        <textarea id="customer-notes" rows="3"
                            class="w-full px-4 py-3 border-2 border-slate-300 rounded-lg focus:ring-4 focus:ring-primary-100 focus:border-primary-500 transition-all"
                            placeholder="Tambahkan catatan untuk pesanan Anda"></textarea>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="flex gap-3">
                        <button id="buy-now-btn" {{ $product->stock == 0 ? 'disabled' : '' }}
                            class="flex-1 px-8 py-4 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center gap-2 disabled:bg-slate-400 disabled:cursor-not-allowed">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            {{ $product->stock == 0 ? 'Stok Habis' : 'Beli Sekarang' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>

    <script>
        const productPrice = {{ (int) $product->price }};
        const maxStock = {{ (int) $product->stock }};
        const qtyInput = document.getElementById('quantity');
        const decreaseBtn = document.getElementById('decrease-qty');
        const increaseBtn = document.getElementById('increase-qty');
        const buyNowBtn = document.getElementById('buy-now-btn');
        const totalPriceEl = document.getElementById('total-price');

        function formatIDR(n) {
            return 'Rp ' + Number(n).toLocaleString('id-ID');
        }

        function updateTotalPrice() {
            const quantity = Math.max(1, Math.min(Number(qtyInput.value), maxStock || 0));
            qtyInput.value = quantity;
            const total = productPrice * quantity;
            totalPriceEl.textContent = formatIDR(total);

            decreaseBtn.disabled = quantity <= 1;
            increaseBtn.disabled = quantity >= maxStock;
        }

        decreaseBtn.addEventListener('click', () => {
            let value = Number(qtyInput.value);
            if (value > 1) {
                qtyInput.value = value - 1;
                updateTotalPrice();
            }
        });

        increaseBtn.addEventListener('click', () => {
            let value = Number(qtyInput.value);
            if (value < maxStock) {
                qtyInput.value = value + 1;
                updateTotalPrice();
            }
        });

        updateTotalPrice();

        buyNowBtn.addEventListener('click', async () => {
            if (maxStock === 0) {
                alert('Maaf, produk ini sedang habis');
                return;
            }

            const quantity = Number(qtyInput.value);
            const notes = document.getElementById('customer-notes').value.trim();

            const defaultBtnHTML = buyNowBtn.innerHTML;
            buyNowBtn.disabled = true;
            buyNowBtn.innerHTML = `
                <svg class="animate-spin h-5 w-5 mr-2 inline" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Memproses...
            `;

            const resetButton = () => {
                buyNowBtn.disabled = false;
                buyNowBtn.innerHTML = defaultBtnHTML;
            };

            try {
                const res = await fetch('/payment/product/{{ $product->id }}/create', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        quantity: quantity,
                        notes: notes
                    })
                });

                const data = await res.json();

                if (data.success) {
                    window.snap.pay(data.snap_token, {
                        onSuccess: function() {
                            window.location.href = '/payment/status/' + data.order_number;
                        },
                        onPending: function() {
                            window.location.href = '/payment/status/' + data.order_number;
                        },
                        onError: function() {
                            alert('Pembayaran gagal, silakan coba lagi');
                            resetButton();
                        },
                        onClose: function() {
                            resetButton();
                        }
                    });
                } else {
                    alert(data.message || 'Terjadi kesalahan');
                    resetButton();
                }
            } catch (e) {
                console.error(e);
                alert('Terjadi kesalahan jaringan, silakan coba lagi');
                resetButton();
            }
        });
    </script>
</x-app-layout>
