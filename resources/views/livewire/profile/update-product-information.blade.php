<div class="w-full">
    @if (session()->has('message'))
        <div class="mb-4 p-3 rounded-lg bg-emerald-100 text-emerald-700 text-sm">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div
        class="rounded-2xl bg-white/95 backdrop-blur ring-1 ring-gray-200 shadow-[0_16px_40px_rgba(17,65,119,0.15)] overflow-hidden">
        <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Produk</h2>
                        <p class="text-sm text-primary-200">Transaksi pembelian Anda</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-4">
            <!-- Product List dengan Scroll -->
            <div class="max-h-[500px] overflow-y-auto space-y-3 mb-4">
                @forelse($products as $product)
                    <div
                        class="rounded-xl bg-gradient-to-br from-white to-slate-50 border border-slate-200 shadow-sm p-4 flex items-center gap-4">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                            class="w-24 h-24 object-cover rounded-lg">

                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900">{{ $product->name }}</h4>
                            <p class="text-sm text-gray-600 line-clamp-2">{{ $product->description }}</p>
                            <p class="text-sm text-primary-600 font-medium mt-1">Rp
                                {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>

                        <button wire:click="openModal({{ $product->id }})"
                            class="px-4 py-1.5 text-xs rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700">
                            Edit
                        </button>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <p>Belum ada produk. Tambahkan produk pertama Anda!</p>
                    </div>
                @endforelse
            </div>

            <!-- Tombol Tambah Product -->
            <button wire:click="openModal"
                class="w-full py-3 rounded-lg bg-primary-600 hover:bg-primary-700 text-white font-medium transition">
                + Tambah Produk
            </button>
        </div>
    </div>

    <!-- Modal Form -->
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4 pt-12"
            wire:click="closeModal">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[80vh] overflow-y-auto" wire:click.stop>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-semibold text-gray-900">
                            {{ $editingProductId ? 'Edit Product' : 'Tambah Product' }}
                        </h3>
                        <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form wire:submit.prevent="save" class="space-y-4">
                        <!-- Product Image -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Produk</label>
                            <input type="file" wire:model="product_image" accept="image/*"
                                class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                            @error('product_image')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror

                            @if ($product_image)
                                <div class="mt-2">
                                    <img src="{{ $product_image->temporaryUrl() }}" alt="Preview"
                                        class="w-32 h-32 object-cover rounded-lg">
                                </div>
                            @elseif($editingProductId)
                                @php
                                    $currentProduct = $products->find($editingProductId);
                                @endphp
                                @if ($currentProduct)
                                    <div class="mt-2">
                                        <img src="{{ $currentProduct->image_url }}" alt="Current"
                                            class="w-32 h-32 object-cover rounded-lg">
                                    </div>
                                @endif
                            @endif
                        </div>

                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Produk</label>
                            <input type="text" wire:model="name"
                                class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                            @error('name')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                            <textarea wire:model="description" rows="3"
                                class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500"></textarea>
                            @error('description')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                            <select wire:model="category_id"
                                class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price & Stock -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Harga</label>
                                <input type="number" wire:model="price" step="0.01"
                                    class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                                @error('price')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Stok</label>
                                <input type="number" wire:model="stock"
                                    class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                                @error('stock')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Is Active -->
                        <div class="flex items-center gap-2">
                            <input type="checkbox" wire:model="is_active" id="is_active"
                                class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                            <label for="is_active" class="text-sm text-gray-700">Produk Aktif</label>
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-center justify-between gap-3 pt-4">
                            @if ($editingProductId)
                                <button type="button" wire:click="deleteProduct({{ $editingProductId }})"
                                    onclick="confirm('Yakin ingin menghapus produk ini?') || event.stopImmediatePropagation()"
                                    class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white text-sm font-medium">
                                    Hapus
                                </button>
                            @else
                                <div></div>
                            @endif

                            <div class="flex gap-2">
                                <button type="button" wire:click="closeModal"
                                    class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 rounded-lg bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium">
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
