<div>
    <h2 class="text-3xl font-bold text-gray-900 mb-2">Sign up</h2>
    <p class="text-gray-600 mb-8">Registrasi akun untuk UMKM (Informasi Jenis Usaha)</p>

    <form wire:submit.prevent="nextStep" class="space-y-5">
        <!-- Business Name & Type -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Usaha</label>
                <input type="text" wire:model.defer="business_name" placeholder="Terpopak-makyus"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent outline-none transition">
                @error('business_name')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Usaha</label>
                <input type="text" wire:model.defer="business_type" placeholder="Makanan"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent outline-none transition">
                @error('business_type')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- City -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Daerah/Usaha</label>
            <input type="text" wire:model.defer="city" placeholder="Kota Baru"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent outline-none transition">
            @error('city')
                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <!-- Location Map & Description -->
        <div class="grid grid-cols-2 gap-4">
            <!-- Google Map -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi Usaha</label>
                <div id="map"
                    class="w-full h-52 border-2 border-gray-300 rounded-lg bg-gray-50 relative overflow-hidden shadow-sm">
                    <!-- Map will be loaded here -->
                    <div id="map-placeholder"
                        class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100">
                        <div class="text-center">
                            <i class="fas fa-map-marker-alt text-5xl text-teal-500 mb-3"></i>
                            <p class="text-sm text-gray-600 font-medium">Klik peta untuk pilih lokasi</p>
                            <p class="text-xs text-gray-500 mt-1">Atau seret marker</p>
                        </div>
                    </div>
                </div>
                <input type="hidden" wire:model="latitude">
                <input type="hidden" wire:model="longitude">
                @if ($latitude && $longitude)
                    <p class="text-xs text-green-600 mt-2">
                        <i class="fas fa-check-circle"></i> Lokasi tersimpan: {{ number_format($latitude, 6) }},
                        {{ number_format($longitude, 6) }}
                    </p>
                @endif
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Usaha</label>
                <textarea wire:model.defer="business_description" rows="7" placeholder="Ceritakan tentang usaha Anda..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent outline-none resize-none transition"></textarea>
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex gap-3 pt-4">
            <button type="submit"
                class="flex-1 bg-teal-600 hover:bg-teal-700 text-white font-semibold py-3.5 rounded-lg transition duration-200 shadow-sm hover:shadow-md">
                Selanjutnya
            </button>
            <button type="button" wire:click="previousStep"
                class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-3.5 rounded-lg transition duration-200 shadow-sm hover:shadow-md">
                Kembali
            </button>
        </div>

        <!-- Login Link -->
        <p class="text-center text-sm text-gray-600 pt-2">
            Already have an account? <a href="/login" class="text-teal-600 hover:text-teal-700 font-medium">Login</a>
        </p>
    </form>
</div>

<!-- Google Maps Script -->
<script>
    let map;
    let marker;
    let mapInitialized = false;

    function initMap() {
        if (mapInitialized) return;
        mapInitialized = true;

        // Remove placeholder
        const placeholder = document.getElementById('map-placeholder');
        if (placeholder) {
            placeholder.remove();
        }

        // Default location (Palembang, Indonesia)
        const defaultLocation = {
            lat: -2.9761,
            lng: 104.7754
        };

        // Map options
        const mapOptions = {
            center: defaultLocation,
            zoom: 13,
            mapTypeControl: false,
            streetViewControl: false,
            fullscreenControl: true,
            zoomControl: true,
            styles: [{
                featureType: "poi",
                elementType: "labels",
                stylers: [{
                    visibility: "off"
                }]
            }]
        };

        map = new google.maps.Map(document.getElementById('map'), mapOptions);

        // Add click listener to map
        map.addListener('click', (event) => {
            placeMarker(event.latLng);
        });

        // Try to get user's current location
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const userLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    map.setCenter(userLocation);
                    placeMarker(new google.maps.LatLng(userLocation.lat, userLocation.lng));
                },
                () => {
                    // If geolocation fails, use default location
                    console.log('Geolocation failed, using default location');
                }
            );
        }
    }

    function placeMarker(location) {
        if (marker) {
            marker.setPosition(location);
        } else {
            marker = new google.maps.Marker({
                position: location,
                map: map,
                draggable: true,
                animation: google.maps.Animation.DROP,
                title: "Lokasi Usaha Anda"
            });

            marker.addListener('dragend', () => {
                updateLocation(marker.getPosition());
            });
        }

        updateLocation(location);
    }

    function updateLocation(location) {
        const lat = location.lat();
        const lng = location.lng();

        @this.set('latitude', lat);
        @this.set('longitude', lng);

        console.log('Location updated:', lat, lng);
    }

    // Load Google Maps API
    function loadGoogleMaps() {
        if (typeof google !== 'undefined' && google.maps) {
            initMap();
            return;
        }

        const script = document.createElement('script');
        script.src = `https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&callback=initMap`;
        script.async = true;
        script.defer = true;
        script.onerror = () => {
            console.error('Failed to load Google Maps');
            document.getElementById('map-placeholder').innerHTML = `
                <div class="text-center">
                    <i class="fas fa-exclamation-triangle text-5xl text-red-500 mb-3"></i>
                    <p class="text-sm text-red-600 font-medium">Gagal memuat Google Maps</p>
                    <p class="text-xs text-gray-500 mt-1">Periksa API key Anda</p>
                </div>
            `;
        };
        document.head.appendChild(script);
    }

    // Initialize when document is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', loadGoogleMaps);
    } else {
        loadGoogleMaps();
    }
</script>

<style>
    #map {
        min-height: 208px;
    }

    .gm-style .gm-style-iw-c {
        border-radius: 8px;
    }

    .gm-style .gm-style-iw-t::after {
        background: linear-gradient(45deg, rgba(255, 255, 255, 1) 50%, rgba(255, 255, 255, 0) 51%, rgba(255, 255, 255, 0) 100%);
    }
</style>
