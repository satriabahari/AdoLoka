<div>
    <h2 class="text-3xl font-bold text-gray-900 mb-2">Sign up</h2>
    <p class="text-gray-600 mb-8">Registrasi akun untuk UMKM (Informasi Jenis Usaha)</p>

    <form wire:submit.prevent="submit" class="space-y-5">
        <!-- Product Name & Category -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Produk</label>
                <input type="text" wire:model.defer="product_name" placeholder="Terpopak-makyus"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition">
                @error('product_name')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori Produk</label>
                <select wire:model.defer="product_category_id"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition">
                    <option value="" hidden>-- Pilih Kategori --</option>
                    @foreach ($productCategories as $category)
                        <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                    @endforeach
                </select>
                @error('product_category_id')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- City (readonly) -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Asal Produk</label>
            <input type="text" value="{{ $city ?: 'Kota Baru' }}" readonly
                class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-600 focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none cursor-not-allowed">
            <p class="text-xs text-gray-500 mt-1">
                <i class="fas fa-info-circle"></i> Lokasi diambil dari data UMKM Anda
            </p>
        </div>

        <!-- Product Photo & Description -->
        <div class="grid grid-cols-2 gap-4">
            <!-- Photo Upload -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Produk</label>
                <div
                    class="relative w-full h-52 border-2 border-dashed border-gray-300 rounded-lg bg-primary-50 overflow-hidden transition hover:border-primary hover:bg-primary-50">
                    @if ($product_photo)
                        <!-- Image Preview -->
                        <div class="relative w-full h-full">
                            <img src="{{ $product_photo->temporaryUrl() }}" class="w-full h-full object-cover"
                                alt="Preview">
                            <div
                                class="absolute inset-0 bg-black bg-opacity-40 opacity-0 hover:opacity-100 transition flex items-center justify-center">
                                <button type="button" wire:click="$set('product_photo', null)"
                                    class="bg-red-500 hover:bg-red-600 text-white rounded-full w-12 h-12 flex items-center justify-center shadow-lg transition">
                                    <x-bi-x />
                                </button>
                            </div>
                        </div>
                    @else
                        <!-- Upload Placeholder -->
                        <label for="product_photo"
                            class="absolute inset-0 flex flex-col items-center justify-center cursor-pointer group">
                            <div class="text-center transition group-hover:scale-105">
                                <div
                                    class="w-16 h-16 mx-auto mb-3 bg-primary-200 rounded-full flex items-center justify-center group-hover:bg-primary-300 transition">
                                    {{-- <i class="fas fa-image text-3xl text-teal-600"></i> --}}
                                    <x-heroicon-s-photo class="w-6 h-6 text-white" />
                                </div>
                                <p class="text-sm text-gray-600 font-medium mb-1">Klik untuk upload foto</p>
                                <p class="text-xs text-gray-500">PNG, JPG, JPEG (Max 2MB)</p>
                            </div>
                        </label>
                        <input type="file" id="product_photo" wire:model="product_photo"
                            accept="image/png,image/jpg,image/jpeg" class="hidden">
                    @endif
                </div>

                @error('product_photo')
                    <span class="text-red-500 text-xs mt-2 block">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </span>
                @enderror

                <!-- Loading Indicator -->
                <div wire:loading wire:target="product_photo" class="mt-2">
                    <div class="flex items-center text-sm text-primary-500">
                        <svg class="animate-spin h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span>Uploading...</span>
                    </div>
                </div>

                @if ($product_photo && !$errors->has('product_photo'))
                    <div class="mt-2 flex items-center text-xs text-primary-600">
                        <i class="fas fa-check-circle mr-1"></i>
                        <span>Foto berhasil dipilih</span>
                    </div>
                @endif
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Produk</label>
                <textarea wire:model.defer="product_description" rows="7"
                    placeholder="Ceritakan tentang produk Anda, keunggulan, bahan baku, dll..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none resize-none transition"></textarea>
                <p class="text-xs text-gray-500 mt-1">
                    <i class="fas fa-lightbulb"></i> Deskripsi yang menarik akan menarik lebih banyak pembeli
                </p>
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex gap-3 pt-4">
            <button type="button" wire:click="previousStep"
                class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-3.5 rounded-lg transition duration-200 shadow-sm hover:shadow-md disabled:opacity-50 disabled:cursor-not-allowed"
                wire:loading.attr="disabled" wire:target="submit">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </button>
            <button type="submit"
                class="flex-1 bg-primary-500 hover:bg-primary-700 text-white font-semibold py-3.5 rounded-lg transition duration-200 shadow-sm hover:shadow-md flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed"
                wire:loading.attr="disabled" wire:target="submit">
                <span wire:loading.remove wire:target="submit">
                    <i class="fas fa-check-circle mr-2"></i>Buat Akun
                </span>
                <span wire:loading wire:target="submit" class="flex items-center">
                    <svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Processing...
                </span>
            </button>
        </div>

        <!-- Login Link -->
        <p class="text-center text-sm text-gray-600 pt-2">
            Already have an account? <a href="/login"
                class="text-primary-500 hover:text-primary-700 font-medium">Login</a>
        </p>
    </form>
</div>

<style>
    /* Custom file input styling */
    input[type="file"]::file-selector-button {
        display: none;
    }

    /* Image preview animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.95);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* Smooth transitions for Livewire loading states */
    [wire\:loading\.remove] {
        display: inline-flex !important;
    }

    [wire\:loading] {
        display: none !important;
    }

    /* Show loading state */
    [wire\:loading\.attr\:disabled] {
        animation: fadeIn 0.3s ease-in-out;
    }

    /* File upload hover effect */
    .group:hover .fa-image {
        transform: scale(1.1);
        transition: transform 0.2s ease-in-out;
    }

    /* Image preview overlay */
    .relative:hover .absolute {
        transition: opacity 0.3s ease-in-out;
    }
</style>

<script>
    // Optional: Add drag and drop functionality
    document.addEventListener('DOMContentLoaded', function() {
        const dropZone = document.getElementById('product_photo')?.parentElement;

        if (dropZone) {
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, unhighlight, false);
            });

            function highlight(e) {
                dropZone.classList.add('border-primary-500', 'bg-primary-50');
            }

            function unhighlight(e) {
                dropZone.classList.remove('border-primary-500', 'bg-primary-50');
            }

            dropZone.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;

                if (files.length > 0) {
                    const fileInput = document.getElementById('product_photo');
                    fileInput.files = files;
                    fileInput.dispatchEvent(new Event('change', {
                        bubbles: true
                    }));
                }
            }
        }
    });

    // Image preview enhancement
    window.addEventListener('livewire:load', function() {
        Livewire.hook('message.processed', (message, component) => {
            // Add smooth fade-in for image preview
            const preview = document.querySelector('[alt="Preview"]');
            if (preview && !preview.classList.contains('fade-in-done')) {
                preview.style.opacity = '0';
                setTimeout(() => {
                    preview.style.transition = 'opacity 0.3s ease-in-out';
                    preview.style.opacity = '1';
                    preview.classList.add('fade-in-done');
                }, 10);
            }
        });
    });
</script>
