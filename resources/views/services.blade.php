@push('styles')
    @vite('resources/css/service.css')
@endpush

<x-app-layout>
    <div class="max-w-7xl mx-auto pt-12">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('home') }}"
                class="flex items-center gap-2 text-sky-600 hover:text-sky-700 transition-colors mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                <span class="font-medium">Kembali</span>
            </a>

            <h1 class="text-3xl font-bold text-slate-800">Layanan Kami</h1>
            <p class="text-slate-600 mt-2">Pilih layanan yang sesuai dengan kebutuhan bisnis Anda</p>
        </div>


        @foreach ($categories as $category)
            <div class="mb-12">
                <!-- Category Header -->
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-slate-800">{{ $category->name }}</h2>
                    @php
                        $serviceCount = $category->services->count();
                        // Show buttons if: mobile (>1 services) OR desktop (>3 services)
                        $showButtonsMobile = $serviceCount > 1; // Show on mobile if > 1
                        $showButtonsDesktop = $serviceCount > 3; // Show on desktop if > 3

                        if ($showButtonsMobile && $showButtonsDesktop) {
                            $buttonClass = 'flex'; // Show on all screens
                        } elseif ($showButtonsMobile && !$showButtonsDesktop) {
                            $buttonClass = 'flex lg:hidden'; // Show only on mobile
                        } elseif (!$showButtonsMobile && $showButtonsDesktop) {
                            $buttonClass = 'hidden lg:flex'; // Show only on desktop
                        } else {
                            $buttonClass = 'hidden'; // Hide on all screens
                        }
                    @endphp

                    @if ($showButtonsMobile || $showButtonsDesktop)
                        <div class="gap-2 {{ $buttonClass }}">
                            <button onclick="scrollContainer('{{ $category->slug }}', -1)"
                                class="p-2 rounded-full bg-white shadow-md hover:bg-sky-50 transition-colors">
                                <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <button onclick="scrollContainer('{{ $category->slug }}', 1)"
                                class="p-2 rounded-full bg-white shadow-md hover:bg-sky-50 transition-colors">
                                <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Services Grid with Horizontal Scroll -->
                <div id="container-{{ $category->slug }}"
                    class="flex gap-6 overflow-x-auto hide-scrollbar scroll-smooth pb-4">
                    @foreach ($category->services as $service)
                        <div class="flex-shrink-0 w-80 group">
                            <div
                                class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden h-full flex flex-col">
                                <!-- Service Image -->
                                <div
                                    class="h-56 overflow-hidden bg-gradient-to-br from-sky-400 to-sky-600 flex items-center justify-center">
                                    <img src="{{ $service->image_url }}" alt="{{ $service->name }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    {{-- <svg class="w-20 h-20 text-white opacity-80" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        @if ($category->slug === 'branding')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        @endif
                                    </svg> --}}
                                </div>

                                <!-- Service Content -->
                                <div class="p-6 flex-grow flex flex-col">
                                    <h3 class="text-xl font-bold text-slate-800 mb-2">{{ $service->name }}</h3>
                                    <p class="text-slate-600 text-sm mb-4 flex-grow">{{ $service->description }}</p>

                                    <!-- Service Info -->
                                    <div class="space-y-2 mb-4">
                                        @if ($service->has_brand_identity)
                                            <div class="flex items-center gap-2 text-sm text-sky-700">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <span>Brand Identity</span>
                                            </div>
                                        @endif

                                        @if ($service->delivery_label)
                                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span>{{ $service->delivery_label }}</span>
                                            </div>
                                        @endif

                                        @if ($service->revision_max > 0)
                                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                                <span>{{ $service->revision_label }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Price & Button -->
                                    <div class="flex items-center justify-between pt-4 border-t border-slate-200">
                                        <div>
                                            <p class="text-2xl font-bold text-sky-600">
                                                Rp {{ number_format($service->price, 0, ',', '.') }}
                                            </p>
                                            @if ($service->unit)
                                                <p class="text-xs text-slate-500">{{ $service->unit }}</p>
                                            @endif
                                        </div>
                                        <a href="{{ route('services.show', $service) }}"
                                            class="px-6 py-2.5 bg-sky-600 hover:bg-sky-700 text-white rounded-lg font-medium transition-colors shadow-md hover:shadow-lg">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
    <script>
        function scrollContainer(categorySlug, direction) {
            const container = document.getElementById(`container-${categorySlug}`);
            const scrollAmount = 350;
            container.scrollBy({
                left: direction * scrollAmount,
                behavior: 'smooth'
            });
        }
    </script>
</x-app-layout>
