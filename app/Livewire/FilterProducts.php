<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategory;
use Livewire\Attributes\Url;
use Livewire\Component;

class FilterProducts extends Component
{
    #[Url(as: 'q')]
    public string $search = '';

    #[Url(as: 'cat')]
    public ?int $categoryId = null;

    public function getCategoriesProperty()
    {
        return ProductCategory::orderBy('name')->get(['id', 'name', 'slug']);
    }

    public function render()
    {
        $products = Product::query()
            ->with(['category', 'media'])
            ->where('is_active', true)
            ->when(
                $this->search !== '',
                fn($q) =>
                $q->where(
                    fn($x) =>
                    $x->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%')
                )
            )
            ->when($this->categoryId, fn($q) => $q->where('category_id', $this->categoryId))
            ->latest('id')
            ->get(); // ← pakai get() bukan paginate()

        return view('livewire.filter-products', [
            'products'   => $products,
            'categories' => $this->categories,
        ]);
    }
}
