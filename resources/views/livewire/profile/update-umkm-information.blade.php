<div class="w-full">
    <!-- KARTU: Info UMKM -->
    <div
        class="rounded-2xl bg-white/95 backdrop-blur ring-1 ring-gray-200 shadow-[0_16px_40px_rgba(17,65,119,0.15)] p-3 md:p-4">
        <div class="rounded-xl bg-white ring-1 ring-gray-200 shadow-sm p-4 md:p-5">
            <div class="space-y-5">

                {{-- Nama UMKM --}}
                <div>
                    <p class="text-sm text-gray-500">Nama UMKM</p>
                    <div class="mt-1.5 flex items-center gap-3">
                        @if (!$editing['nama_umkm'])
                            <span class="flex-1 text-gray-800 font-medium">{{ $nama_umkm }}</span>
                        @else
                            <input type="text" wire:model.live="nama_umkm"
                                class="flex-1 rounded-lg border-gray-300 focus:ring-sky-500 focus:border-sky-500">
                        @endif

                        @if (!$editing['nama_umkm'])
                            <button wire:click="toggle('nama_umkm')"
                                class="px-4 py-1.5 text-xs rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700 shadow-sm">
                                Edit
                            </button>
                        @else
                            <button wire:click="save('nama_umkm')"
                                class="px-4 py-1.5 text-xs rounded-full bg-sky-600 hover:bg-sky-700 text-white">
                                Save
                            </button>
                        @endif
                    </div>
                </div>

                {{-- Jenis UMKM --}}
                <div>
                    <p class="text-sm text-gray-500">Jenis UMKM</p>
                    <div class="mt-1.5 flex items-center gap-3">
                        @if (!$editing['jenis_umkm'])
                            <span class="flex-1 text-gray-800 font-medium">{{ $jenis_umkm }}</span>
                        @else
                            <input type="text" wire:model.live="jenis_umkm"
                                class="flex-1 rounded-lg border-gray-300 focus:ring-sky-500 focus:border-sky-500">
                        @endif

                        @if (!$editing['jenis_umkm'])
                            <button wire:click="toggle('jenis_umkm')"
                                class="px-4 py-1.5 text-xs rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700 shadow-sm">
                                Edit
                            </button>
                        @else
                            <button wire:click="save('jenis_umkm')"
                                class="px-4 py-1.5 text-xs rounded-full bg-sky-600 hover:bg-sky-700 text-white">
                                Save
                            </button>
                        @endif
                    </div>
                </div>

                {{-- Asal Produk --}}
                <div>
                    <p class="text-sm text-gray-500">Asal Produk</p>
                    <div class="mt-1.5 flex items-center gap-3">
                        @if (!$editing['asal_produk'])
                            <span class="flex-1 text-gray-800 font-medium">{{ $asal_produk }}</span>
                        @else
                            <input type="text" wire:model.live="asal_produk"
                                class="flex-1 rounded-lg border-gray-300 focus:ring-sky-500 focus:border-sky-500">
                        @endif

                        @if (!$editing['asal_produk'])
                            <button wire:click="toggle('asal_produk')"
                                class="px-4 py-1.5 text-xs rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700 shadow-sm">
                                Edit
                            </button>
                        @else
                            <button wire:click="save('asal_produk')"
                                class="px-4 py-1.5 text-xs rounded-full bg-sky-600 hover:bg-sky-700 text-white">
                                Save
                            </button>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        <!-- KARTU: Deskripsi UMKM -->
        <div class="mt-4 rounded-xl bg-white ring-1 ring-gray-200 shadow-sm p-4 md:p-5">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-lg font-semibold text-gray-900">Deskripsi UMKM</h3>

                @if (!$editing['deskripsi'])
                    <button wire:click="toggle('deskripsi')"
                        class="px-4 py-1.5 text-xs rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700 shadow-sm">
                        Edit
                    </button>
                @else
                    <button wire:click="save('deskripsi')"
                        class="px-4 py-1.5 text-xs rounded-full bg-sky-600 hover:bg-sky-700 text-white">
                        Save
                    </button>
                @endif
            </div>

            @if (!$editing['deskripsi'])
                <p class="text-sm leading-6 text-gray-600">
                    {{ $deskripsi }}
                </p>
            @else
                <textarea rows="4" wire:model.live="deskripsi"
                    class="w-full rounded-lg border-gray-300 focus:ring-sky-500 focus:border-sky-500"></textarea>
            @endif
        </div>
    </div>
</div>
