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

        <!-- Service Detail Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Header Image -->
            <div
                class="bg-gradient-to-br from-primary-400 to-primary-600 h-64 flex items-center justify-center relative">
                <img src="{{ $service->image_url }}" alt="{{ $service->name }}" class="w-full h-full object-cover">
                <div class="absolute top-6 left-6">
                    <span class="px-4 py-2 bg-white/20 backdrop-blur-sm text-white rounded-full text-sm font-medium">
                        {{ $service->category->name }}
                    </span>
                </div>
            </div>

            <!-- Content -->
            <div class="p-8">
                <!-- Service Name & Description -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-slate-800 mb-4">{{ $service->name }}</h1>
                    <p class="text-slate-600 text-lg leading-relaxed">{{ $service->description }}</p>
                </div>

                <!-- Price Box with Quantity -->
                <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-xl p-6 mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-sm text-slate-600 mb-2">Harga per {{ $service->unit ?? 'Paket' }}</p>
                            <div class="flex items-baseline gap-2">
                                <p class="text-4xl font-bold text-primary-600">
                                    Rp {{ number_format($service->price, 0, ',', '.') }}
                                </p>
                                @if ($service->unit)
                                    <p class="text-lg text-slate-600">{{ $service->unit }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Quantity Selector -->
                        <div class="flex items-center gap-3">
                            <span class="text-sm font-medium text-slate-700">Jumlah:</span>
                            <div class="flex items-center gap-2 bg-white rounded-lg shadow-sm">
                                <button type="button" id="decrease-qty"
                                    class="px-3 py-2 hover:bg-primary-50 rounded-l-lg transition-colors">
                                    <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 12H4" />
                                    </svg>
                                </button>
                                <input type="number" id="quantity" value="1" min="1" max="100"
                                    class="w-16 text-center font-semibold text-slate-800 border-0 focus:ring-0"
                                    readonly>
                                <button type="button" id="increase-qty"
                                    class="px-3 py-2 hover:bg-primary-50 rounded-r-lg transition-colors">
                                    <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Total Price -->
                    <div class="pt-4 border-t border-primary-200">
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-medium text-slate-700">Total Harga:</span>
                            <span id="total-price" class="text-3xl font-bold text-primary-600">
                                Rp {{ number_format($service->price, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Service Features -->
                <div class="grid md:grid-cols-2 gap-4 mb-8">
                    @if ($service->has_brand_identity)
                        <div class="flex items-start gap-3 p-4 bg-primary-50 rounded-lg">
                            <div
                                class="w-10 h-10 bg-primary-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-slate-800 mb-1">Brand Identity</h3>
                                <p class="text-sm text-slate-600">Termasuk panduan identitas brand lengkap</p>
                            </div>
                        </div>
                    @endif

                    @if ($service->delivery_label)
                        <div class="flex items-start gap-3 p-4 bg-slate-50 rounded-lg">
                            <div
                                class="w-10 h-10 bg-slate-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-slate-800 mb-1">Waktu Pengerjaan</h3>
                                <p class="text-sm text-slate-600">{{ $service->delivery_label }}</p>
                            </div>
                        </div>
                    @endif

                    @if ($service->revision_max > 0)
                        <div class="flex items-start gap-3 p-4 bg-slate-50 rounded-lg">
                            <div
                                class="w-10 h-10 bg-slate-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-slate-800 mb-1">Revisi</h3>
                                <p class="text-sm text-slate-600">{{ $service->revision_label }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Notes Only -->
                <div class="bg-slate-50 rounded-xl p-6 mb-8">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Catatan Pesanan (Opsional)</label>
                    <textarea id="customer-notes" rows="3"
                        class="w-full px-4 py-3 border-2 border-slate-300 rounded-lg focus:ring-4 focus:ring-primary-100 focus:border-primary-500 transition-all"
                        placeholder="Tambahkan catatan khusus untuk pesanan Anda"></textarea>
                </div>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <button id="buy-now-btn"
                        class="flex-1 px-8 py-4 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        Pesan Sekarang
                    </button>

                    @if ($service->consultation_link)
                        <a href="{{ $service->consultation_link }}" target="_blank"
                            class="flex-1 px-8 py-4 bg-white hover:bg-slate-50 text-primary-600 border-2 border-primary-600 rounded-xl font-semibold transition-all duration-300 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                            </svg>
                            Konsultasi Gratis
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>

    <script>
        const servicePrice = {{ (int) $service->price }};
        const qtyInput = document.getElementById('quantity');
        const decreaseBtn = document.getElementById('decrease-qty');
        const increaseBtn = document.getElementById('increase-qty');
        const buyNowBtn = document.getElementById('buy-now-btn');
        const totalPriceEl = document.getElementById('total-price');

        function formatIDR(n) {
            return 'Rp ' + Number(n).toLocaleString('id-ID');
        }

        function updateTotalPrice() {
            const quantity = Math.max(1, Math.min(Number(qtyInput.value), 100));
            qtyInput.value = quantity;
            const total = servicePrice * quantity;
            totalPriceEl.textContent = formatIDR(total);

            decreaseBtn.disabled = quantity <= 1;
            increaseBtn.disabled = quantity >= 100;
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
            if (value < 100) {
                qtyInput.value = value + 1;
                updateTotalPrice();
            }
        });

        updateTotalPrice();

        buyNowBtn.addEventListener('click', async () => {
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
                const res = await fetch('/payment/service/{{ $service->id }}/create', {
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
