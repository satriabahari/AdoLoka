<div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    {{-- SIDEBAR FILTER --}}
    <aside class="md:col-span-1">
        <div
            class="rounded-2xl bg-white/95 backdrop-blur ring-1 ring-gray-200 p-4 md:p-6
                    shadow-[0_16px_40px_rgba(17,65,119,0.10)]">
            {{-- KATEGORI --}}
            <div class="mb-6">
                <h3 class="text-xs font-semibold tracking-[.15em] text-gray-500 mb-3">KATEGORI</h3>

                <div class="space-y-2">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="radio" name="category" class="size-4 text-primary-700" wire:model.live="categoryId"
                            value="">
                        <span class="text-sm">Semua</span>
                    </label>

                    @foreach ($categories as $cat)
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="category" class="size-4 text-primary-700"
                                wire:model.live="categoryId" value="{{ $cat->id }}">
                            <span class="text-sm">{{ $cat->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
    </aside>

    {{-- CONTENT LIST --}}
    <div class="md:col-span-3">
        {{-- Search bar --}}
        <div class="mb-4">
            <input wire:model.debounce.400ms="search" type="text" placeholder="Cari produk…"
                class="w-full rounded-full border px-5 py-3 text-sm border-gray-200 focus:ring-2 focus:ring-primary-400 focus:outline-none">
        </div>

        {{-- Grid produk --}}
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($products as $product)
                @isset($product)
                    <x-product-card :product="$product" />
                @endisset
            @empty
                <div class="col-span-full text-center text-gray-500 py-8">
                    Tidak ada produk yang cocok dengan filter.
                </div>
            @endforelse
        </div>
    </div>
</div>
