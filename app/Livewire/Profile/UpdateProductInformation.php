<?php

namespace App\Livewire\Profile;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateProductInformation extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $editingProductId;

    public $name;
    public $description;
    public $price;
    public $stock;
    public $category_id;
    public $is_active = true;
    public $product_image;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'category_id' => 'required|exists:categories,id',
        'product_image' => 'nullable|image|max:2048',
    ];

    public function mount(): void
    {
        // No need to load products here, we'll do it in render()
    }

    public function openModal($productId = null): void
    {
        $this->resetForm();

        if ($productId) {
            $product = Product::findOrFail($productId);

            if ($product->user_id !== Auth::id()) {
                session()->flash('error', 'Unauthorized access.');
                return;
            }

            $this->editingProductId = $productId;
            $this->name = $product->name;
            $this->description = $product->description;
            $this->price = $product->price;
            $this->stock = $product->stock;
            $this->category_id = $product->category_id;
            $this->is_active = $product->is_active;
        }

        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'category_id' => $this->category_id,
            'is_active' => $this->is_active,
            'user_id' => Auth::id(),
            'umkm_id' => Auth::user()->umkm?->id,
        ];

        if ($this->editingProductId) {
            $product = Product::findOrFail($this->editingProductId);
            $product->update($data);
            $message = 'Product berhasil diupdate!';
        } else {
            $product = Product::create($data);
            $message = 'Product berhasil ditambahkan!';
        }

        if ($this->product_image) {
            $product->clearMediaCollection('product');
            $product->addMedia($this->product_image->getRealPath())
                ->toMediaCollection('product');
        }

        session()->flash('message', $message);
        $this->closeModal();
    }

    public function deleteProduct($productId): void
    {
        $product = Product::findOrFail($productId);

        if ($product->user_id !== Auth::id()) {
            session()->flash('error', 'Unauthorized access.');
            return;
        }

        $product->delete();
        session()->flash('message', 'Product berhasil dihapus!');
        $this->closeModal();
    }

    private function resetForm(): void
    {
        $this->editingProductId = null;
        $this->name = '';
        $this->description = '';
        $this->price = '';
        $this->stock = '';
        $this->category_id = '';
        $this->is_active = true;
        $this->product_image = null;
        $this->resetValidation();
    }

    public function render()
    {
        // Load products fresh on each render
        $products = Product::where('user_id', Auth::id())
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->get();

        // Load categories
        $categories = ProductCategory::all();

        return view('livewire.profile.update-product-information', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }
}
