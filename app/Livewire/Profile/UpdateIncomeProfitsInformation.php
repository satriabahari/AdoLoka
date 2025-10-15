<?php

namespace App\Livewire\Profile;

use Livewire\Component;

class UpdateIncomeProfitsInformation extends Component
{
    // angka contoh; silakan ganti dari query Order/Transaction milikmu
    public int $pendapatan = 8_000_000;
    public int $keuntungan = 1_000_000;

    public bool $calculating = false;

    public function hitung(): void
    {
        // TODO: taruh logika perhitunganmu di sini.
        // Contoh (pseudo):
        // $this->pendapatan = Order::paid()->sum('total');
        // $this->keuntungan = OrderItem::paid()->sum(DB::raw('qty * (price - cogs)'));

        $this->calculating = true;
        // contoh efek loading singkat
        usleep(300_000);
        $this->calculating = false;

        // optional: notifikasi
        $this->dispatch('saved');
    }

    public function formatRupiah(int|float $value): string
    {
        return 'Rp. ' . number_format($value, 0, ',', '.');
    }
    public function render()
    {
        return view('livewire.profile.update-income-profits-information');
    }
}
