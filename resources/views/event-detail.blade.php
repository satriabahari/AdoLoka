<x-app-layout>
    {{-- Leaflet CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

    <div class="max-w-6xl mx-auto pt-12">
        <button onclick="window.history.back()"
            class="flex items-center gap-2 text-sky-600 hover:text-sky-700 transition-colors mb-8 animate-fade-in">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <span class="font-medium">Kembali</span>
        </button>

        {{-- HERO SECTION --}}
        <section class="relative h-[320px] md:h-[420px] w-full overflow-hidden">
            <img src="{{ $event->image_url }}" alt="{{ $event->title }}"
                class="absolute inset-0 w-full h-full object-cover rounded-xl">
            <div
                class="relative h-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col justify-center items-center py-6">
                <div class="flex items-center justify-center flex-col">
                    <div class="mb-3">
                        <span
                            class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-semibold bg-sky-500/90 backdrop-blur-sm text-white shadow-lg">
                            {{ ucfirst($event->type) }}
                        </span>
                    </div>
                    <h1 class="text-4xl md:text-6xl font-extrabold text-white drop-shadow-lg leading-tight">
                        {{ $event->title }}
                    </h1>
                </div>
            </div>
        </section>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                <div
                    class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-xl flex items-start gap-3 shadow-sm">
                    <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        {{-- MAIN CONTENT --}}
        <section class="max-w-7xl mx-auto py-12 md:py-16">
            <div class="grid lg:grid-cols-3 gap-8">
                {{-- LEFT CONTENT (2 cols) --}}
                <div class="lg:col-span-2 space-y-8">
                    {{-- Event Info Card --}}
                    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-100 p-6 md:p-8">
                        <div>
                            <h2 class="text-3xl font-bold text-sky-900 mb-2">{{ $event->title }}</h2>
                            <div class="flex items-center gap-2 text-slate-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="font-medium">{{ $event->date_range }}</span>
                            </div>
                        </div>

                        <div class="prose prose-slate max-w-none mt-6">
                            <h3 class="text-lg font-semibold text-slate-900 mb-3">Tentang Event</h3>
                            <p class="text-slate-600 leading-relaxed">{{ $event->description }}</p>
                        </div>
                    </div>

                    {{-- UMKM Terkait Section --}}
                    @if ($event->registrations && $event->registrations->count() > 0)
                        <div
                            class="bg-gradient-to-br from-sky-50 to-white rounded-2xl shadow-sm ring-1 ring-sky-100 p-6 md:p-8">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h3 class="text-2xl font-bold text-sky-900">UMKM Terkait</h3>
                                    <p class="text-slate-600 text-sm mt-1">{{ $event->registrations->count() }} UMKM
                                        telah
                                        terdaftar</p>
                                </div>
                            </div>

                            <div class="grid sm:grid-cols-2 gap-4">
                                @foreach ($event->registrations as $registration)
                                    <div
                                        class="bg-white rounded-xl p-5 shadow-sm ring-1 ring-slate-100 hover:shadow-md transition-all duration-200 group">
                                        <div class="flex items-start gap-4">
                                            <div class="flex-shrink-0">
                                                @php
                                                    $brandPhoto = $registration->getFirstMediaUrl('brand_photo');
                                                @endphp
                                                @if ($brandPhoto)
                                                    <img src="{{ $brandPhoto }}"
                                                        alt="{{ $registration->umkm_brand_name }}"
                                                        class="w-16 h-16 rounded-lg object-cover ring-2 ring-sky-100">
                                                @else
                                                    <div
                                                        class="w-16 h-16 rounded-lg bg-gradient-to-br from-sky-100 to-sky-200 flex items-center justify-center">
                                                        <svg class="w-8 h-8 text-sky-600" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h4
                                                    class="font-bold text-sky-900 group-hover:text-sky-700 transition-colors truncate">
                                                    {{ $registration->umkm_brand_name }}
                                                </h4>
                                                <p class="text-sm text-slate-600 mt-0.5">
                                                    {{ $registration->business_type }}
                                                </p>
                                                @if ($registration->instagram_name)
                                                    <a href="https://instagram.com/{{ ltrim($registration->instagram_name, '@') }}"
                                                        target="_blank"
                                                        class="inline-flex items-center gap-1 text-xs text-sky-600 hover:text-sky-700 mt-2">
                                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                            <path
                                                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                                        </svg>
                                                        <span>{{ $registration->instagram_name }}</span>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Location & Map Section --}}
                    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-100 p-6 md:p-8">
                        <div class="flex items-start gap-3 mb-5">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-sky-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-slate-900">Lokasi Event</h3>
                                <p class="text-slate-600 mt-1">{{ $event->title }}</p>
                                @if($event->latitude && $event->longitude)
                                    <a href="https://www.google.com/maps/search/?api=1&query={{ $event->latitude }},{{ $event->longitude }}"
                                        target="_blank"
                                        class="inline-flex items-center gap-1 text-sm text-sky-600 hover:text-sky-700 font-medium mt-2">
                                        Buka di Google Maps
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="rounded-xl overflow-hidden shadow-lg ring-1 ring-slate-200">
                            <div id="event-map" class="w-full h-[400px]"></div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT SIDEBAR --}}
                <div class="lg:col-span-1 space-y-6">
                    {{-- Event Image Card --}}
                    <div class="sticky top-6">
                        <div class="bg-white rounded-2xl shadow-lg ring-1 ring-slate-100 p-4">
                            <div class="aspect-[4/3] rounded-xl overflow-hidden">
                                <img src="{{ $event->image_url }}" alt="{{ $event->title }}"
                                    class="w-full h-full object-cover">
                            </div>
                        </div>

                        {{-- Event Details Card --}}
                        <div
                            class="bg-gradient-to-br from-sky-50 to-white rounded-2xl shadow-sm ring-1 ring-sky-100 p-6 mt-6">
                            <h4 class="text-lg font-bold text-sky-900 mb-4">Detail Event</h4>

                            <div class="space-y-4">
                                {{-- Date --}}
                                <div class="flex items-start gap-3">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 rounded-lg bg-sky-100 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500 font-medium">Tanggal</p>
                                        <p class="text-sm text-slate-900 font-semibold mt-0.5">
                                            {{ $event->date_range }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Category --}}
                                <div class="flex items-start gap-3">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 rounded-lg bg-sky-100 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500 font-medium">Kategori</p>
                                        <p class="text-sm text-slate-900 font-semibold mt-0.5">
                                            {{ ucfirst($event->type) }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Participants --}}
                                @if ($event->registrations && $event->registrations->count() > 0)
                                    <div class="flex items-start gap-3">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-lg bg-sky-100 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-sky-600" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-slate-500 font-medium">Peserta</p>
                                            <p class="text-sm text-slate-900 font-semibold mt-0.5">
                                                {{ $event->registrations->count() }} UMKM</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            {{-- CTA Button --}}
                            <div class="mt-6 pt-6 border-t border-sky-100">
                                @livewire('event-registration-modal', ['event' => $event], key('sidebar-register'))
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- Leaflet JS & Script --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data dari Laravel
            const eventTitle = @json($event->title);
            const eventLat = {{ $event->latitude ?? '-1.6101' }};
            const eventLng = {{ $event->longitude ?? '103.6131' }};

            // Inisialisasi map
            const map = L.map('event-map').setView([eventLat, eventLng], 15);

            // Tambahkan tile layer (OpenStreetMap)
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                maxZoom: 19
            }).addTo(map);

            // Custom icon untuk marker
            const customIcon = L.divIcon({
                className: 'custom-marker',
                html: `
                    <div style="position: relative;">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"
                                  fill="#0284c7" stroke="#fff" stroke-width="2"/>
                            <circle cx="12" cy="9" r="2.5" fill="#fff"/>
                        </svg>
                    </div>
                `,
                iconSize: [40, 40],
                iconAnchor: [20, 40],
                popupAnchor: [0, -40]
            });

            // Tambahkan marker
            const marker = L.marker([eventLat, eventLng], { icon: customIcon }).addTo(map);

            // URL Google Maps
            const googleMapsUrl = `https://www.google.com/maps/search/?api=1&query=${eventLat},${eventLng}`;

            // Popup content dengan link ke Google Maps
            const popupContent = `
                <div class="text-center p-2" style="min-width: 200px;">
                    <h4 class="font-bold text-slate-900 mb-2">${eventTitle}</h4>
                    <p class="text-xs text-slate-600 mb-3">${eventLat.toFixed(6)}, ${eventLng.toFixed(6)}</p>
                    <a href="${googleMapsUrl}"
                       target="_blank"
                       class="inline-flex items-center gap-2 bg-sky-600 hover:bg-sky-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                        </svg>
                        Buka di Google Maps
                    </a>
                </div>
            `;

            marker.bindPopup(popupContent, {
                maxWidth: 300,
                className: 'custom-popup'
            });

            // Otomatis buka popup
            marker.openPopup();

            // Klik marker untuk buka Google Maps
            marker.on('click', function() {
                window.open(googleMapsUrl, '_blank');
            });
        });
    </script>

    {{-- Custom CSS untuk styling popup --}}
    <style>
        .custom-marker {
            background: transparent;
            border: none;
        }

        .leaflet-popup-content-wrapper {
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .leaflet-popup-content {
            margin: 12px;
        }

        .leaflet-popup-tip {
            background: white;
        }

        .custom-popup .leaflet-popup-close-button {
            color: #64748b;
            font-size: 20px;
            padding: 8px;
        }

        .custom-popup .leaflet-popup-close-button:hover {
            color: #0f172a;
        }
    </style>
</x-app-layout>
