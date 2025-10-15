<div class="container mx-auto px-4 pt-24 py-8 ">
    <button
        class="flex gap-2 mb-8 bg-gradient-to-r from-[rgb(17,65,119)] via-[#006A9A] to-[#17A18A] text-white py-1 px-4 rounded-md">
        <x-heroicon-o-arrow-left />
        <p>Back</p>
    </button>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <livewire:profile.update-profile-information />

        <div class="flex flex-col gap-8">
            <livewire:profile.update-umkm-information />
            <livewire:profile.update-income-profits-information />
        </div>

        <!-- penting: biar isi kartu bisa full height -->
        <livewire:profile.update-product-service-information />
    </div>
</div>
