@props(['product'])

@php
    $image = $product->getFirstMediaUrl('product_image') ?: $product->image_url;
    $url = route('products.show', $product);
@endphp

<a href="{{ $url }}" class="block group">
    <div
        class="bg-white rounded-lg shadow-sm ring-1 ring-gray-100 overflow-hidden transition transform group-hover:-translate-y-1 group-hover:shadow-md duration-200">
        <div class="aspect-[1/1] w-full overflow-hidden">
            <img src="{{ $image }}" alt="{{ $product->name }}"
                class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
        </div>

        <div class="p-4">
            <h3 class="font-semibold text-slate-800 truncate mb-2 group-hover:text-primary-700">
                {{ $product->name }}
            </h3>

            <p class="text-primary-700 font-semibold">
                Rp{{ number_format($product->price, 0, ',', '.') }}
            </p>
        </div>
    </div>
</a>
