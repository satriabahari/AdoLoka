<?php

namespace App\Livewire\Profile;

use Livewire\Attributes\Validate;
use Livewire\Component;

class UpdateUmkmInformation extends Component
{
    #[Validate('required|string|max:255')]
    public string $nama_umkm = 'Sid market';

    #[Validate('required|string|max:100')]
    public string $jenis_umkm = 'Kuliner';

    #[Validate('required|string|max:100')]
    public string $asal_produk = 'Desa Tangkit';

    #[Validate('nullable|string|max:2000')]
    public string $deskripsi = 'Lorem ipsum dolor sit amet consectetur. Erat auctor a aliquam vel congue luctus. Leo diam cras neque mauris ac arcu elit ipsum dolor sit amet consectetur.';

    public array $editing = [
        'nama_umkm'  => false,
        'jenis_umkm' => false,
        'asal_produk' => false,
        'deskripsi'  => false,
    ];

    public function toggle(string $field): void
    {
        $this->editing[$field] = ! $this->editing[$field];
    }

    public function save(string $field): void
    {
        $this->validateOnly($field);
        // TODO: simpan ke DB sesuai model kamu
        $this->editing[$field] = false;
        $this->dispatch('saved');
    }

    public function render()
    {
        return view('livewire.profile.update-umkm-information');
    }
}
