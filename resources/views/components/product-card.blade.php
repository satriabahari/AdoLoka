@props(['product'])

@php
    $image = $product->getFirstMediaUrl('product_image') ?: $product->image_url;
    $url = route('products.show', $product);
@endphp

<a href="{{ $url }}" class="block group">
    <div
        class="bg-white rounded-lg shadow-sm ring-1 ring-gray-100 overflow-hidden transition transform group-hover:-translate-y-1 group-hover:shadow-md duration-200">
        {{-- IMAGE --}}
        <div class="aspect-[1/1] w-full overflow-hidden">
            <img src="{{ $image }}" alt="{{ $product->name }}"
                class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
        </div>

        {{-- CONTENT --}}
        <div class="p-4">
            {{-- Rating --}}
            <div class="flex items-center gap-1 mb-1">
                @for ($i = 0; $i < 5; $i++)
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="{{ $i < 4 ? '#f59e0b' : '#e5e7eb' }}" class="w-4 h-4">
                        <path
                            d="M12 .587l3.668 7.431 8.2 1.192-5.934 5.782 1.402 8.173L12 18.897l-7.336 3.848 1.402-8.173L.132 9.21l8.2-1.192L12 .587z" />
                    </svg>
                @endfor
                <span class="text-xs text-gray-500 ml-1">(738)</span>
            </div>

            {{-- Title --}}
            <h3 class="font-semibold text-slate-800 truncate mb-2 group-hover:text-sky-700">
                {{ $product->name }}
            </h3>

            {{-- Price --}}
            <p class="text-sky-700 font-semibold">
                Rp{{ number_format($product->price, 0, ',', '.') }}
            </p>
        </div>
    </div>
</a>
