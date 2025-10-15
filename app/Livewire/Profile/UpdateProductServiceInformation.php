<?php

namespace App\Livewire\Profile;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UpdateProductServiceInformation extends Component
{
    /** @var \Illuminate\Database\Eloquent\Collection<Product> */
    public $products;

    public function mount(): void
    {
        // Ambil produk milik user aktif (ubah sesuai kebutuhanmu)
        $this->products = Product::query()
            ->with('media')
            ->when(Auth::check(), fn($q) => $q->where('user_id', Auth::id()))
            ->latest('id')
            ->get();
    }

    public function edit(int $productId): void
    {
        // Arahkan ke halaman edit milikmu (ganti rute sesuai project)
        $product = $this->products->firstWhere('id', $productId);
        if ($product) {
            $this->redirectRoute('products.show', $product); // contoh: ke detail dulu
            // atau: $this->redirectRoute('products.edit', $product);
        }
    }

    public function add(): void
    {
        // Sesuaikan rute create produkmu
        $this->redirectRoute('products'); // atau 'products.create'
    }

    public function render()
    {
        return view('livewire.profile.update-product-service-information');
    }
}
