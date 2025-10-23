<x-app-layout>
    <div class="max-w-5xl mx-auto pt-12">
        <!-- Back Button -->
        <button onclick="window.history.back()"
            class="flex items-center gap-2 text-sky-600 hover:text-sky-700 transition-colors mb-8 animate-fade-in">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <span class="font-medium">Kembali</span>
        </button>

        <!-- Product Detail Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden animate-fade-in-up">
            <div class="grid md:grid-cols-2 gap-8 p-8">
                <!-- Product Image -->
                <div class="space-y-4">
                    <div
                        class="relative h-96 rounded-2xl overflow-hidden bg-gradient-to-br from-sky-100 to-sky-200 group">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">

                        <!-- Category Badge -->
                        <div class="absolute top-4 left-4">
                            <span
                                class="px-4 py-2 bg-white/90 backdrop-blur-sm text-sky-600 rounded-full text-sm font-semibold shadow-lg">
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
                        <div class="bg-sky-50 rounded-xl p-4 border-2 border-sky-100">
                            <p class="text-xs text-sky-600 font-semibold mb-1">Dijual oleh</p>
                            <h3 class="text-lg font-bold text-sky-900">{{ $product->umkm->name }}</h3>
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
                    <div class="bg-gradient-to-br from-sky-50 to-sky-100 rounded-xl p-6 border-2 border-sky-200">
                        <p class="text-sm text-slate-600 mb-2">Harga</p>
                        <p class="text-4xl font-bold text-sky-600 mb-4">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            <span class="text-slate-600">Stok tersedia: <strong
                                    class="text-sky-600">{{ $product->stock }}</strong></span>
                        </div>
                    </div>

                    <!-- Quantity Selector -->
                    <div class="bg-slate-50 rounded-xl p-6">
                        <label class="block text-sm font-semibold text-slate-700 mb-3">Jumlah Pembelian</label>
                        <div class="flex items-center gap-4">
                            <div
                                class="flex items-center gap-2 bg-white rounded-lg shadow-md border-2 border-slate-200">
                                <button type="button" id="decrease-qty"
                                    class="px-4 py-3 hover:bg-sky-50 rounded-l-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                    <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor"
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
                                    class="px-4 py-3 hover:bg-sky-50 rounded-r-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                    <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-slate-600">Total Harga</p>
                                <p id="total-price" class="text-2xl font-bold text-sky-600">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Information Form -->
                    <div class="bg-slate-50 rounded-xl p-6 space-y-4">
                        <h3 class="text-lg font-bold text-slate-800 mb-4">Informasi Pembeli</h3>

                        <!-- Nama -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap *</label>
                            <input type="text" id="customer-name"
                                class="w-full px-4 py-3 border-2 border-slate-300 rounded-lg focus:ring-4 focus:ring-sky-100 focus:border-sky-500 transition-all"
                                placeholder="Masukkan nama lengkap">
                            <p id="error-name" class="hidden text-sm text-red-600 mt-2 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span></span>
                            </p>
                        </div>

                        <div class="grid md:grid-cols-2 gap-4">
                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Email *</label>
                                <input type="email" id="customer-email"
                                    class="w-full px-4 py-3 border-2 border-slate-300 rounded-lg focus:ring-4 focus:ring-sky-100 focus:border-sky-500 transition-all"
                                    placeholder="email@example.com">
                                <p id="error-email" class="hidden text-sm text-red-600 mt-2 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span></span>
                                </p>
                            </div>

                            <!-- Phone -->
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">No. WhatsApp *</label>
                                <input type="tel" id="customer-phone"
                                    class="w-full px-4 py-3 border-2 border-slate-300 rounded-lg focus:ring-4 focus:ring-sky-100 focus:border-sky-500 transition-all"
                                    placeholder="08xxxxxxxxxx">
                                <p id="error-phone" class="hidden text-sm text-red-600 mt-2 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span></span>
                                </p>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Catatan (Opsional)</label>
                            <textarea id="customer-notes" rows="3"
                                class="w-full px-4 py-3 border-2 border-slate-300 rounded-lg focus:ring-4 focus:ring-sky-100 focus:border-sky-500 transition-all"
                                placeholder="Tambahkan catatan untuk pesanan"></textarea>
                        </div>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="flex gap-3">
                        <button id="buy-now-btn"
                            class="flex-1 px-8 py-4 bg-sky-600 hover:bg-sky-700 text-white rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center gap-2 disabled:bg-slate-400 disabled:cursor-not-allowed">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            Beli Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Midtrans Snap Script --}}
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>

    <script>
        const productPrice = {{ $product->price }};
        const maxStock = {{ $product->stock }};
        const qtyInput = document.getElementById('quantity');
        const decreaseBtn = document.getElementById('decrease-qty');
        const increaseBtn = document.getElementById('increase-qty');
        const buyNowBtn = document.getElementById('buy-now-btn');
        const totalPriceEl = document.getElementById('total-price');

        // Error elements
        const nameInput = document.getElementById('customer-name');
        const emailInput = document.getElementById('customer-email');
        const phoneInput = document.getElementById('customer-phone');
        const errorName = document.getElementById('error-name');
        const errorEmail = document.getElementById('error-email');
        const errorPhone = document.getElementById('error-phone');

        // Update total price
        function updateTotalPrice() {
            const quantity = parseInt(qtyInput.value);
            const total = productPrice * quantity;
            totalPriceEl.textContent = 'Rp ' + total.toLocaleString('id-ID');

            // Update button states
            decreaseBtn.disabled = quantity <= 1;
            increaseBtn.disabled = quantity >= maxStock;
        }

        // Show error message
        function showError(element, errorElement, message) {
            element.classList.add('border-red-500', 'focus:ring-red-100', 'focus:border-red-500');
            element.classList.remove('border-slate-300', 'focus:ring-sky-100', 'focus:border-sky-500');
            errorElement.classList.remove('hidden');
            errorElement.querySelector('span').textContent = message;
        }

        // Clear error message
        function clearError(element, errorElement) {
            element.classList.remove('border-red-500', 'focus:ring-red-100', 'focus:border-red-500');
            element.classList.add('border-slate-300', 'focus:ring-sky-100', 'focus:border-sky-500');
            errorElement.classList.add('hidden');
        }

        // Clear all errors
        function clearAllErrors() {
            clearError(nameInput, errorName);
            clearError(emailInput, errorEmail);
            clearError(phoneInput, errorPhone);
        }

        // Validate on blur
        nameInput.addEventListener('blur', () => {
            if (nameInput.value.trim()) {
                clearError(nameInput, errorName);
            }
        });

        emailInput.addEventListener('blur', () => {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (emailInput.value.trim() && emailRegex.test(emailInput.value.trim())) {
                clearError(emailInput, errorEmail);
            }
        });

        phoneInput.addEventListener('blur', () => {
            const phoneRegex = /^(08|62|8)[0-9]{8,11}$/;
            if (phoneInput.value.trim() && phoneRegex.test(phoneInput.value.replace(/[\s-]/g, ''))) {
                clearError(phoneInput, errorPhone);
            }
        });

        // Quantity controls
        decreaseBtn.addEventListener('click', () => {
            let value = parseInt(qtyInput.value);
            if (value > 1) {
                qtyInput.value = value - 1;
                updateTotalPrice();
            }
        });

        increaseBtn.addEventListener('click', () => {
            let value = parseInt(qtyInput.value);
            if (value < maxStock) {
                qtyInput.value = value + 1;
                updateTotalPrice();
            }
        });

        // Buy Now - Midtrans Integration
        buyNowBtn.addEventListener('click', async () => {
            clearAllErrors();

            // Check stock
            if (maxStock === 0) {
                alert('Maaf, produk ini sedang habis');
                return;
            }

            const quantity = parseInt(qtyInput.value);
            const customerName = nameInput.value.trim();
            const customerEmail = emailInput.value.trim();
            const customerPhone = phoneInput.value.trim();
            const customerNotes = document.getElementById('customer-notes').value.trim();

            let hasError = false;

            // Validation
            if (!customerName) {
                showError(nameInput, errorName, 'Nama lengkap harus diisi');
                hasError = true;
                if (!hasError) nameInput.focus();
            }

            if (!customerEmail) {
                showError(emailInput, errorEmail, 'Email harus diisi');
                hasError = true;
                if (!customerName) emailInput.focus();
            } else {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(customerEmail)) {
                    showError(emailInput, errorEmail, 'Format email tidak valid');
                    hasError = true;
                    if (!customerName) emailInput.focus();
                }
            }

            if (!customerPhone) {
                showError(phoneInput, errorPhone, 'Nomor WhatsApp harus diisi');
                hasError = true;
                if (!customerName && !customerEmail) phoneInput.focus();
            } else {
                const phoneRegex = /^(08|62|8)[0-9]{8,11}$/;
                if (!phoneRegex.test(customerPhone.replace(/[\s-]/g, ''))) {
                    showError(phoneInput, errorPhone, 'Format nomor tidak valid (contoh: 08123456789)');
                    hasError = true;
                    if (!customerName && !customerEmail) phoneInput.focus();
                }
            }

            if (hasError) {
                const firstError = document.querySelector('.border-red-500');
                if (firstError) {
                    firstError.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
                return;
            }

            buyNowBtn.disabled = true;
            buyNowBtn.innerHTML = `
                <svg class="animate-spin h-5 w-5 mr-2" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Memproses...
            `;

            try {
                const response = await fetch('{{ route('products.payment.create', $product) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        quantity: quantity,
                        customer_name: customerName,
                        customer_email: customerEmail,
                        customer_phone: customerPhone,
                        notes: customerNotes
                    })
                });

                const data = await response.json();

                if (data.success) {
                    window.snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            window.location.href = '{{ url('/products/payment/status') }}/' + data
                                .order_id;
                        },
                        onPending: function(result) {
                            window.location.href = '{{ url('/products/payment/status') }}/' + data
                                .order_id;
                        },
                        onError: function(result) {
                            alert('Pembayaran gagal, silakan coba lagi');
                            resetButton();
                        },
                        onClose: function() {
                            resetButton();
                        }
                    });
                } else {
                    if (data.errors) {
                        if (data.errors.customer_name) {
                            showError(nameInput, errorName, data.errors.customer_name[0]);
                        }
                        if (data.errors.customer_email) {
                            showError(emailInput, errorEmail, data.errors.customer_email[0]);
                        }
                        if (data.errors.customer_phone) {
                            showError(phoneInput, errorPhone, data.errors.customer_phone[0]);
                        }
                    } else {
                        alert(data.message || 'Terjadi kesalahan');
                    }
                    resetButton();
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan, silakan coba lagi');
                resetButton();
            }
        });

        function resetButton() {
            buyNowBtn.disabled = false;
            buyNowBtn.innerHTML = `
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                Beli Sekarang
            `;
        }

        // Disable buy button if stock is 0
        if (maxStock === 0) {
            buyNowBtn.disabled = true;
            buyNowBtn.innerHTML = 'Stok Habis';
        }
    </script>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }
    </style>
</x-app-layout>
