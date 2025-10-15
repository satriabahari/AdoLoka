<div
    class="rounded-2xl bg-white/95 backdrop-blur ring-1 ring-gray-200 shadow-[0_16px_40px_rgba(17,65,119,0.15)] p-3 md:p-4">
    <div class="rounded-xl bg-white ring-1 ring-gray-200 shadow-sm p-5 md:p-6">
        <div class="space-y-5">

            {{-- Row: Pendapatan --}}
            <div class="flex items-center justify-between">
                <span class="text-gray-700">Pendapatan</span>
                <span class="font-semibold text-emerald-500">
                    {{ $this->formatRupiah($pendapatan) }}
                </span>
            </div>

            {{-- Row: Keuntungan --}}
            <div class="flex items-center justify-between">
                <span class="text-gray-700">Keuntungan</span>
                <span class="font-semibold text-emerald-500">
                    {{ $this->formatRupiah($keuntungan) }}
                </span>
            </div>

            {{-- Button --}}
            <div class="pt-2">
                <button wire:click="hitung" wire:loading.attr="disabled"
                    class="w-full inline-flex items-center justify-center px-6 py-3 rounded-xl text-white font-semibold
                           bg-gradient-to-r from-[#114177] via-[#006A9A] to-[#17A18A] shadow-lg transition
                           disabled:opacity-70 disabled:cursor-not-allowed">
                    <span wire:loading.remove>Hitung Pendapatan</span>
                    <span wire:loading>Memproses…</span>
                </button>
            </div>
        </div>
    </div>
</div>
