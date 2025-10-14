<x-app-layout>
    @php
        $image = $product->getFirstMediaUrl('product_image') ?: $product->image_url;
    @endphp

    {{-- HERO HEADER --}}
    <section class="relative h-[200px] md:h-[260px] overflow-hidden">
        <img src="{{ asset('images/header-umkm.jpg') }}" alt="Header"
            class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/30 to-black/50"></div>

        <div class="relative container mx-auto h-full flex items-center justify-between px-4">
            <a href="{{ route('events') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 hover:bg-white/30 text-white backdrop-blur ring-1 ring-white/30 transition">
                ← Back
            </a>
            <h1 class="text-3xl md:text-4xl font-bold text-white drop-shadow">Menu Produk UMKM</h1>
        </div>
    </section>

    {{-- PRODUCT DETAIL --}}
    <section class="max-w-6xl mx-auto px-4 py-10 md:py-12">
        <div class="grid md:grid-cols-2 gap-10">
            {{-- LEFT IMAGE --}}
            <div>
                <img src="{{ $image }}" alt="{{ $product->name }}"
                    class="rounded-xl w-full object-cover shadow-md ring-1 ring-gray-200">
            </div>

            {{-- RIGHT DETAILS --}}
            <div>
                {{-- Rating --}}
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-yellow-400 text-lg">★</span>
                    <span class="text-slate-700 font-semibold">4.7 Star Rating</span>
                </div>

                {{-- Title & Price --}}
                <h1 class="text-3xl font-bold text-slate-800 mb-2">{{ $product->name }}</h1>
                <p class="text-sky-700 text-2xl font-semibold mb-4">Rp{{ number_format($product->price, 0, ',', '.') }}
                </p>

                {{-- Availability --}}
                <p class="text-sm text-green-600 font-medium mb-1">
                    Ketersediaan: {{ $product->stock > 0 ? 'Ada' : 'Habis' }}
                </p>
                <p class="text-sm text-slate-600">Category: {{ $product->category->name ?? '-' }}</p>
                <p class="text-sm text-slate-600 mb-6">Asal Produk: Desa Mekar Jaya</p>

                {{-- Quantity + Buttons --}}
                <div class="flex items-center gap-3 mb-6">
                    <div class="flex items-center border border-gray-300 rounded-lg">
                        <button class="px-3 py-2 text-gray-700 font-bold hover:bg-gray-100 transition">−</button>
                        <input type="text" value="1" readonly
                            class="w-10 text-center border-x border-gray-300 text-gray-800 font-semibold">
                        <button class="px-3 py-2 text-gray-700 font-bold hover:bg-gray-100 transition">+</button>
                    </div>

                    <button
                        class="bg-blue-800 hover:bg-blue-900  font-semibold px-6 py-2.5 rounded-lg shadow">
                        BELI SEKARANG
                    </button>
                    <button
                        class="border-2 border-blue-800 text-blue-800 font-semibold px-6 py-2.5 rounded-lg hover:bg-blue-50 transition">
                        KERANJANG
                    </button>
                </div>
            </div>
        </div>

        {{-- TAB SECTION --}}
        <div class="mt-10 border-t border-gray-200 pt-6">
            <div class="flex gap-6 mb-4 border-b border-gray-200">
                <button class="text-orange-500 font-semibold border-b-2 border-orange-500 pb-2">
                    DESCRIPTION
                </button>
                <button class="text-slate-500 hover:text-slate-800 transition pb-2">
                    REVIEW
                </button>
            </div>

            {{-- Description --}}
            <div class="space-y-4 text-slate-600 leading-relaxed">
                <h3 class="text-lg font-semibold text-slate-800">Description</h3>
                <p>
                    {{ $product->description }}
                </p>
            </div>
        </div>
    </section>
</x-app-layout>
