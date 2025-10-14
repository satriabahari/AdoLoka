<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('media')->get();
        return view('products', compact('products'));
    }

    public function show(Product $product)
    {
        $product->load('media');
        return view('product-detail', compact('product'));
    }
}
