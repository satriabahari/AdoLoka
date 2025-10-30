<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Umkm;
use App\Models\ServiceCategory;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        // --- 1. Buat user ---
        $user = User::firstOrCreate(
            ['email' => 'satria@gmail.com'],
            [
                'first_name' => 'Satria',
                'last_name' => 'Bahari',
                'phone_number' => '082183340920',
                'password' => Hash::make('satria'),
            ]
        );

        // --- 2. Buat UMKM ---
        $umkm = Umkm::firstOrCreate(
            ['user_id' => $user->id],
            [
                'name' => 'Pisang Melet',
                'type' => 'Kuliner',
                'city' => 'Jambi',
                'latitude' => -1.6101223,
                'longitude' => 103.6148452,
                'address' => 'Jl. Sultan Thaha No.45, Jambi',
                'description' => 'Menjual pisang nugget dengan berbagai topping kekinian dan harga terjangkau.',
            ]
        );

        // --- 3. Buat kategori layanan ---
        $categories = [
            'Branding',
            'Promosi',
        ];

        foreach ($categories as $name) {
            ServiceCategory::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }

        // --- 4. Data layanan ---
        $services = [
            [
                'name' => 'Desain Logo Profesional',
                'description' => 'Desain logo modern dengan 2x revisi dan file master (AI/PSD/SVG).',
                'image' => 'service-1.jpg',
                'price' => 100000,
                'category' => 'Branding',
                'revision_max' => 2,
                'delivery_days_min' => 3,
                'delivery_days_max' => 5,
            ],
            [
                'name' => 'Brand Guidelines Mini',
                'description' => 'Panduan dasar logo usage, warna, tipografi, dan contoh aplikasi.',
                'image' => 'service-2.jpg',
                'price' => 150000,
                'category' => 'Branding',
                'revision_max' => 2,
                'delivery_days_min' => 3,
                'delivery_days_max' => 5,
                'has_brand_identity' => true,
            ],
            [
                'name' => 'Foto Katalog Produk',
                'description' => 'Paket foto studio profesional untuk katalog produk UMKM.',
                'price' => 100000,
                'category' => 'Promosi',
                'image' => 'service-3.jpg',
                'unit' => '/10 Foto',
                'revision_max' => 1,
                'delivery_days_min' => 2,
                'delivery_days_max' => 3,
            ],
            [
                'name' => 'Desain Poster Promosi',
                'description' => 'Poster A3/A4 untuk promo offline/online siap cetak & upload.',
                'price' => 75000,
                'category' => 'Promosi',
                'image' => 'service-4.jpg',
                'unit' => '/Poster',
                'revision_max' => 2,
                'delivery_days_min' => 1,
                'delivery_days_max' => 2,
                'has_brand_identity' => true,
            ],
            [
                'name' => 'Fotografer Profesional',
                'description' => 'Fotografer profesional untuk katalog produk UMKM.',
                'price' => 100000,
                'category' => 'Promosi',
                'image' => 'service-1.jpg',
                'revision_max' => 2,
                'delivery_days_min' => 1,
                'delivery_days_max' => 2,
                'has_brand_identity' => true,
            ],
            [
                'name' => 'Writer Profesional',
                'description' => 'Writer profesional untuk katalog produk UMKM.',
                'price' => 50000,
                'category' => 'Promosi',
                'image' => 'service-2.jpg',
                'revision_max' => 4,
                'delivery_days_min' => 1,
                'delivery_days_max' => 4,
                'has_brand_identity' => true,
            ],
        ];

        // --- 5. Simpan layanan branding ---
        foreach ($services as $data) {
            $category = ServiceCategory::where('name', $data['category'])->first();

            $slug = Str::slug($data['name']);
            $imagePath = public_path('images/services/' . $data['image']);

            $service = Service::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'price' => $data['price'],
                    'unit' => $data['unit'] ?? null,
                    'slug' => Str::slug($data['name']),
                    'category_id' => $category->id,
                    'has_brand_identity' => $data['has_brand_identity'] ?? false,
                    'revision_max' => $data['revision_max'],
                    'delivery_days_min' => $data['delivery_days_min'],
                    'delivery_days_max' => $data['delivery_days_max'],
                    'user_id' => $user->id,
                    'umkm_id' => $umkm->id,
                    'consultation_link' => 'https://wa.me/6281234567890',
                    'is_active' => true,
                ]
            );

            // Bersihkan media lama biar tidak double
            $service->clearMediaCollection('service');

            // Upload gambar jika file ada
            if (file_exists($imagePath)) {
                $service
                    ->addMedia($imagePath)
                    ->preservingOriginal()
                    ->toMediaCollection('service');
            }
        }
    }
}
