<div>
    <h2 class="text-3xl font-bold text-gray-900 mb-2">Sign up</h2>
    <p class="text-gray-600 mb-8">Registrasi akun untuk UMKM (Informasi Jenis Usaha)</p>

    <form wire:submit.prevent="nextStep" class="space-y-5">
        <!-- Business Name & Type -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Usaha</label>
                <input type="text" wire:model.defer="business_name" placeholder="Terpopak-makyus"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition">
                @error('business_name')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori Usaha</label>
                <select wire:model.defer="umkm_category_id"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition bg-white">
                    <option value="" hidden>Pilih kategori</option>
                    @foreach ($umkmCategories as $cat)
                        <option value="{{ $cat['id'] }}">{{ $cat['name'] }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- City -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Daerah/Usaha</label>
            <input type="text" wire:model.defer="city" placeholder="Kota Baru"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition">
            @error('city')
                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <!-- Location Map & Description -->
        <div class="grid grid-cols-2 gap-4">
            <!-- Leaflet Map -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi Usaha</label>
                <div id="umkm-map"
                    class="w-full h-52 border-2 border-gray-300 rounded-lg bg-gray-50 relative overflow-hidden shadow-sm">
                    <!-- Map will be loaded here -->
                    <div id="map-placeholder"
                        class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100 z-10">
                        <div class="text-center">
                            <svg class="w-12 h-12 text-primary mx-auto mb-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <p class="text-sm text-gray-600 font-medium">Klik peta untuk pilih lokasi</p>
                            <p class="text-xs text-gray-500 mt-1">Atau seret marker</p>
                        </div>
                    </div>
                </div>
                <input type="hidden" wire:model="latitude">
                <input type="hidden" wire:model="longitude">
                @if ($latitude && $longitude)
                    <p class="text-xs text-green-600 mt-2 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        Lokasi tersimpan: {{ number_format($latitude, 6) }}, {{ number_format($longitude, 6) }}
                    </p>
                @endif
                @error('latitude')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Usaha</label>
                <textarea wire:model.defer="business_description" rows="7" placeholder="Ceritakan tentang usaha Anda..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent outline-none resize-none transition"></textarea>
                @error('business_description')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex gap-3 pt-4">
            <button type="button" wire:click="previousStep"
                class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-3.5 rounded-lg transition duration-200 shadow-sm hover:shadow-md">
                Kembali
            </button>
            <button type="submit"
                class="flex-1 bg-primary hover:bg-primary-dark text-white font-semibold py-3.5 rounded-lg transition duration-200 shadow-sm hover:shadow-md">
                Selanjutnya
            </button>
        </div>

        <!-- Login Link -->
        <p class="text-center text-sm text-gray-600 pt-2">
            Already have an account? <a href="/login"
                class="text-primary hover:text-primary-dark font-medium">Login</a>
        </p>
    </form>
</div>

{{-- Leaflet CSS & JS - Pastikan sudah di-include di layout --}}
@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        let umkmMap;
        let umkmMarker;
        let mapInitialized = false;

        function initUmkmMap() {
            if (mapInitialized) return;
            mapInitialized = true;

            // Remove placeholder
            const placeholder = document.getElementById('map-placeholder');
            if (placeholder) {
                placeholder.style.display = 'none';
            }

            // Default location (Jambi, Indonesia)
            const defaultLat = {{ $latitude ?? '-1.6101' }};
            const defaultLng = {{ $longitude ?? '103.6131' }};

            // Initialize map
            umkmMap = L.map('umkm-map').setView([defaultLat, defaultLng], 13);

            // Add tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                maxZoom: 19
            }).addTo(umkmMap);

            // Custom icon
            const customIcon = L.divIcon({
                className: 'custom-marker',
                html: `
                <div style="position: relative;">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"
                              fill="#0ea5e9" stroke="#fff" stroke-width="2"/>
                        <circle cx="12" cy="9" r="2.5" fill="#fff"/>
                    </svg>
                </div>
            `,
                iconSize: [40, 40],
                iconAnchor: [20, 40],
                popupAnchor: [0, -40]
            });

            // Add click listener to map
            umkmMap.on('click', function(e) {
                placeUmkmMarker(e.latlng);
            });

            // Try to get user's current location
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const userLocation = L.latLng(position.coords.latitude, position.coords.longitude);
                        umkmMap.setView(userLocation, 15);
                        placeUmkmMarker(userLocation);
                    },
                    () => {
                        // If geolocation fails, place marker at default location
                        placeUmkmMarker(L.latLng(defaultLat, defaultLng));
                    }
                );
            } else {
                placeUmkmMarker(L.latLng(defaultLat, defaultLng));
            }
        }

        function placeUmkmMarker(latlng) {
            const customIcon = L.divIcon({
                className: 'custom-marker',
                html: `
                <div style="position: relative;">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"
                              fill="#0ea5e9" stroke="#fff" stroke-width="2"/>
                        <circle cx="12" cy="9" r="2.5" fill="#fff"/>
                    </svg>
                </div>
            `,
                iconSize: [40, 40],
                iconAnchor: [20, 40]
            });

            if (umkmMarker) {
                umkmMarker.setLatLng(latlng);
            } else {
                umkmMarker = L.marker(latlng, {
                    icon: customIcon,
                    draggable: true,
                    title: "Lokasi Usaha Anda"
                }).addTo(umkmMap);

                umkmMarker.on('dragend', function() {
                    updateUmkmLocation(umkmMarker.getLatLng());
                });
            }

            updateUmkmLocation(latlng);
        }

        function updateUmkmLocation(latlng) {
            const lat = latlng.lat;
            const lng = latlng.lng;

            @this.set('latitude', lat);
            @this.set('longitude', lng);
        }

        // Initialize when document is ready
        document.addEventListener('DOMContentLoaded', function() {
            // Delay to ensure Livewire is ready
            setTimeout(initUmkmMap, 100);
        });

        // Re-initialize if Livewire updates the component
        document.addEventListener('livewire:load', function() {
            setTimeout(initUmkmMap, 100);
        });
    </script>

    <style>
        #umkm-map {
            min-height: 208px;
            z-index: 1;
        }

        .custom-marker {
            background: transparent;
            border: none;
        }
    </style>
@endpush
