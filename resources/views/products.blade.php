<x-app-layout>
    {{-- HERO --}}
    <section
        class="relative h-[180px] md:h-[220px] bg-gradient-to-r from-sky-700 to-sky-900 text-white flex items-center justify-center">
        <h1 class="text-3xl md:text-4xl font-extrabold">Menu Produk UMKM</h1>
    </section>

    {{-- SEARCH BAR --}}
    <div class="max-w-6xl mx-auto px-4 -mt-8 relative z-10">
        <div class="bg-white shadow-lg rounded-xl p-4">
            <input type="text" placeholder="Cari produk..."
                class="w-full rounded-lg border border-gray-200 focus:ring-2 focus:ring-sky-400 focus:outline-none p-3">
        </div>
    </div>

    {{-- CONTENT --}}
    <section class="max-w-6xl mx-auto px-4 py-10">
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('events') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-sky-50 hover:bg-sky-100 text-sky-800 transition">
                ← Back
            </a>
        </div>

        {{-- GRID PRODUK --}}
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-6">
            @foreach ($products as $product)
                {{-- <x-product-card :image="$product->image_url" :title="$product->name" :price="'Rp' . number_format($product->price, 0, ',', '.')" :rating="rand(3, 5)"
                    :reviews="rand(120, 800)" /> --}}
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </section>
</x-app-layout>
