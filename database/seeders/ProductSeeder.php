<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // User untuk relasi
        $user = User::firstOrCreate(
            ['email' => 'satria@gmail.com'],
            [
                'first_name'   => 'Satria',
                'last_name'    => 'Bahari',
                'phone_number' => '082183340920',
                'password'     => Hash::make('satria'),
            ]
        );

        // UMKM untuk relasi
        $umkm = Umkm::firstOrCreate(
            ['user_id' => $user->id],
            [
                'business_name' => 'Pisang Melet',
                'business_type' => 'Kuliner',
                'city'          => 'Jambi',
                'latitude'      => -1.6101223,
                'longitude'     => 103.6148452,
                'address'       => 'Jl. Sultan Thaha No.45, Jambi',
                'description'   => 'Menjual pisang nugget dengan berbagai topping kekinian dan harga terjangkau.',
            ]
        );

        $datas = [
            [
                'name'        => 'Batik By Butik bu Revi',
                'description' => 'Batik motif khas, kualitas premium.',
                'price'       => 275000,
                'stock'       => 50,
                'category'    => 'Kerajinan',
                'image'       => 'batik-by-butik-bu-revi.png',
            ],
            [
                'name'        => 'Es kelapa Kopyor bang Jalil',
                'description' => 'Es kopyor segar, cocok siang hari.',
                'price'       => 10000,
                'stock'       => 140,
                'category'    => 'Kuliner',
                'image'       => 'es-kelapa.png',
            ],
            [
                'name'        => 'Kebab khas Turki',
                'description' => 'Kebab lezat dengan saus spesial.',
                'price'       => 18000,
                'stock'       => 90,
                'category'    => 'Kuliner',
                'image'       => 'kebab.png',
            ],
            [
                'name'        => 'Ramen Sangat gembira',
                'description' => 'Ramen kuah gurih hangat.',
                'price'       => 25000,
                'stock'       => 60,
                'category'    => 'Kuliner',
                'image'       => 'ramen.png',
            ],
            [
                'name'        => 'Risol mayo mbak anne',
                'description' => 'Risol isi mayones, gurih lembut.',
                'price'       => 5500,
                'stock'       => 200,
                'category'    => 'Kuliner',
                'image'       => 'risol.png',
            ],
            [
                'name'        => 'Tempoyak wangi buk nessi',
                'description' => 'Tempoyak durian fermentasi, cita rasa khas.',
                'price'       => 20000,
                'stock'       => 100,
                'category'    => 'Kuliner',
                'image'       => 'batik-by-butik-bu-revi.png',
            ],
            [
                'name'        => 'Es Jagung Pak banil',
                'description' => 'Minuman segar dari jagung manis.',
                'price'       => 7000,
                'stock'       => 120,
                'category'    => 'Kuliner',
                'image'       => 'es-kelapa.png',
            ],
            [
                'name'        => 'Buah potong pak andre',
                'description' => 'Aneka buah potong segar.',
                'price'       => 15000,
                'stock'       => 80,
                'category'    => 'Kuliner',
                'image'       => 'kebab.png',
            ],
            [
                'name'        => 'Jasa Reparasi Baterai',
                'description' => 'Servis baterai perangkat elektronik.',
                'price'       => 20000,
                'stock'       => 999,
                'category'    => 'Jasa',
                'image'       => 'ramen.png',
            ],
            [
                'name'        => 'Parfum bu Fira',
                'description' => 'Parfum lokal wangi tahan lama.',
                'price'       => 75000,
                'stock'       => 70,
                'category'    => 'Kesehatan dan kecantikan',
                'image'       => 'risol.png',
            ],
            [
                'name'        => 'Baju batik Pria',
                'description' => 'Batik pria modern.',
                'price'       => 375000,
                'stock'       => 40,
                'category'    => 'Fashion dan Aksesoris',
                'image'       => 'es-kelapa.png',
            ],
        ];

        foreach ($datas as $data) {
            // Kategori (buat jika belum ada)
            $category = Category::firstOrCreate(
                ['slug' => Str::slug($data['category'])],
                ['name' => $data['category']]
            );

            // Siapkan slug unik dari nama
            $base = Str::slug($data['name']);
            $slug = $base;
            $i = 2;
            while (Product::where('slug', $slug)->exists()) {
                $slug = "{$base}-{$i}";
                $i++;
            }

            $imageFile = $data['image'];
            unset($data['image']);

            // Simpan / update product
            $product = Product::updateOrCreate(
                ['slug' => $slug],
                [
                    'name'        => $data['name'],
                    'description' => $data['description'] ?? null,
                    'slug'        => $slug,              // eksplisit
                    'price'       => $data['price'] ?? 0,
                    'stock'       => $data['stock'] ?? 0,
                    'is_active'   => true,
                    'category_id' => $category->id,
                    'user_id'     => $user->id,
                    'umkm_id'     => $umkm->id,
                ]
            );

            // Bersihkan media lama agar tidak duplikat tiap seed
            $product->clearMediaCollection('product');

            // Tambahkan media jika file ada
            $imagePath = public_path('images/products/' . $imageFile);
            if (file_exists($imagePath)) {
                $product
                    ->addMedia($imagePath)
                    ->preservingOriginal()
                    ->toMediaCollection('product');
            }
        }
    }
}
