<div
    class="rounded-2xl bg-white/95 backdrop-blur ring-1 ring-gray-200 shadow-[0_16px_40px_rgba(17,65,119,0.15)] p-4 md:p-6">
    {{-- Judul --}}
    <h2 class="text-2xl md:text-3xl font-bold text-sky-900 mb-4">
        <span class="bg-gradient-to-r from-sky-700 to-emerald-500 bg-clip-text text-transparent">
            Produk atau Jasa
        </span>
    </h2>

    {{-- List Produk --}}
    <div class="space-y-4">
        @forelse ($products as $product)
            <div class="rounded-xl ring-1 ring-gray-200 bg-white shadow-sm p-3 md:p-4">
                <div class="flex items-start gap-3 md:gap-4">
                    {{-- Gambar --}}
                    <div class="shrink-0">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                            class="h-24 w-32 object-cover rounded-md ring-1 ring-gray-200" />
                    </div>

                    {{-- Info --}}
                    <div class="flex-1">
                        <div class="flex items-start justify-between gap-3">
                            <h3 class="text-lg font-semibold text-gray-900 leading-6">
                                {{ $product->name }}
                            </h3>

                            <button wire:click="edit({{ $product->id }})"
                                class="text-xs px-4 py-1.5 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700 shadow-sm">
                                Edit
                            </button>
                        </div>

                        <p class="mt-1 text-sm leading-6 text-gray-600 line-clamp-3">
                            {{ $product->description }}
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <div class="rounded-xl ring-1 ring-gray-200 bg-white p-6 text-center text-gray-600">
                Belum ada produk. Tambahkan produk pertamamu.
            </div>
        @endforelse
    </div>

    {{-- Tombol Tambah --}}
    <div class="mt-6">
        <button wire:click="add"
            class="w-full inline-flex items-center justify-center px-6 py-3 rounded-xl text-white font-semibold
                   bg-gradient-to-r from-[#114177] via-[#006A9A] to-[#17A18A] hover:opacity-95 shadow-lg">
            Tambah Produk atau Jasa
        </button>
    </div>
</div>
