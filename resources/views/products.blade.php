<x-app-layout>
    <div class="max-w-7xl mx-auto pt-12">
        <div class="mb-8">
            <a href="{{ route('home') }}"
                class="flex items-center gap-2 text-sky-600 hover:text-sky-700 transition-colors mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                <span class="font-medium">Kembali</span>
            </a>

            <div class="animate-fade-in">
                <h1 class="text-3xl font-bold text-slate-800">Produk UMKM</h1>
                <p class="text-slate-600 mt-2">Temukan produk berkualitas dari UMKM lokal</p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Sidebar Filter -->
                <aside class="lg:w-64 flex-shrink-0 animate-slide-in-left">
                    <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-24">
                        <h2 class="text-xl font-bold text-sky-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            Filter Kategori
                        </h2>

                        <div class="space-y-2">
                            <button onclick="filterByCategory('all')"
                                class="category-filter w-full text-left px-4 py-3 rounded-lg transition-all duration-300 hover:bg-sky-50 active"
                                data-category="all">
                                <span class="font-medium text-slate-700">Semua Produk</span>
                            </button>
                            @foreach ($categories as $category)
                                <button onclick="filterByCategory('{{ $category->slug }}')"
                                    class="category-filter w-full text-left px-4 py-3 rounded-lg transition-all duration-300 hover:bg-sky-50"
                                    data-category="{{ $category->slug }}">
                                    <span class="font-medium text-slate-700">{{ $category->name }}</span>
                                    <span class="text-sm text-slate-500">({{ $category->products_count }})</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </aside>

                <!-- Main Content -->
                <main class="flex-1 animate-fade-in-up">
                    <!-- Search Bar -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                        <div class="relative">
                            <input type="text" id="search-input" placeholder="Cari produk..."
                                class="w-full pl-12 pr-4 py-3 border-2 border-slate-200 rounded-xl focus:border-sky-500 focus:ring-4 focus:ring-sky-100 transition-all duration-300">
                            <svg class="w-5 h-5 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Products Grid -->
                    <div id="products-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse ($products as $index => $product)
                            <div class="product-card group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 animate-fade-in-up cursor-pointer"
                                style="animation-delay: {{ $index * 0.1 }}s"
                                data-category="{{ $product->category->slug }}"
                                data-name="{{ strtolower($product->name) }}"
                                onclick="window.location='{{ route('products.show', $product->slug) }}'">

                                <!-- Product Image -->
                                <div class="relative h-56 overflow-hidden bg-gradient-to-br from-sky-100 to-sky-200">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">

                                    @if ($product->stock < 10)
                                        <div
                                            class="absolute top-4 right-4 bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                            Stok Terbatas
                                        </div>
                                    @endif
                                </div>

                                <!-- Product Info -->
                                <div class="p-5">
                                    <div class="mb-2">
                                        <span
                                            class="text-xs font-semibold text-sky-600 bg-sky-50 px-3 py-1 rounded-full">
                                            {{ $product->category->name }}
                                        </span>
                                    </div>

                                    <h3
                                        class="text-lg font-bold text-slate-800 mb-2 line-clamp-2 group-hover:text-sky-600 transition-colors">
                                        {{ $product->name }}
                                    </h3>

                                    <p class="text-sm text-slate-600 mb-4 line-clamp-2">
                                        {{ $product->description }}
                                    </p>

                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-2xl font-bold text-sky-600">
                                                Rp {{ number_format($product->price, 0, ',', '.') }}
                                            </p>
                                            <p class="text-xs text-slate-500">Stok: {{ $product->stock }}</p>
                                        </div>

                                        <button
                                            class="w-10 h-10 bg-sky-600 text-white rounded-full flex items-center justify-center group-hover:bg-sky-700 group-hover:scale-110 transition-all duration-300">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-16">
                                <svg class="w-24 h-24 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <h3 class="text-xl font-bold text-slate-700 mb-2">Belum Ada Produk Tersedia</h3>
                                <p class="text-slate-500">Produk akan segera ditambahkan</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Empty State (for search/filter results) -->
                    <div id="empty-state" class="hidden text-center py-16">
                        <svg class="w-24 h-24 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-xl font-bold text-slate-700 mb-2">Produk Tidak Ditemukan</h3>
                        <p class="text-slate-500">Coba kata kunci atau kategori lain</p>
                    </div>
                </main>
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

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        .animate-fade-in-up {
            opacity: 0;
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .animate-slide-in-left {
            animation: slideInLeft 0.8s ease-out;
        }

        .category-filter.active {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
        }
    </style>

    <script>
        const searchInput = document.getElementById('search-input');
        const productsContainer = document.getElementById('products-container');
        const emptyState = document.getElementById('empty-state');
        let currentCategory = 'all';

        // Get category from URL parameter
        const urlParams = new URLSearchParams(window.location.search);
        const categoryParam = urlParams.get('category');
        if (categoryParam) {
            filterByCategory(categoryParam);
        }

        // Search functionality
        searchInput.addEventListener('input', function() {
            filterProducts();
        });

        function filterByCategory(category) {
            currentCategory = category;

            // Update active button
            document.querySelectorAll('.category-filter').forEach(btn => {
                btn.classList.remove('active');
            });

            const targetBtn = document.querySelector(`[data-category="${category}"]`);
            if (targetBtn) {
                targetBtn.classList.add('active');
            }

            // Update URL without reload
            const url = new URL(window.location);
            if (category === 'all') {
                url.searchParams.delete('category');
            } else {
                url.searchParams.set('category', category);
            }
            window.history.pushState({}, '', url);

            filterProducts();
        }

        function filterProducts() {
            const searchTerm = searchInput.value.toLowerCase();
            const products = document.querySelectorAll('.product-card');
            let visibleCount = 0;

            products.forEach((product, index) => {
                const productCategory = product.dataset.category;
                const productName = product.dataset.name;

                const matchesCategory = currentCategory === 'all' || productCategory === currentCategory;
                const matchesSearch = productName.includes(searchTerm);

                if (matchesCategory && matchesSearch) {
                    product.style.display = 'block';
                    product.style.animationDelay = `${visibleCount * 0.1}s`;
                    visibleCount++;
                } else {
                    product.style.display = 'none';
                }
            });

            // Show/hide empty state
            if (visibleCount === 0) {
                productsContainer.style.display = 'none';
                emptyState.classList.remove('hidden');
            } else {
                productsContainer.style.display = 'grid';
                emptyState.classList.add('hidden');
            }
        }
    </script>
</x-app-layout>
