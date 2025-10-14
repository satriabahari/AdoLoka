<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'satria@gmail.com'],
            [
                'first_name'   => 'Satria',
                'last_name'    => 'Bahari',
                'phone_number' => '082183340920',
                'password'     => Hash::make('satria'),
            ]
        );

        $datas = [
            // ====== KULINER ======
            [
                'name' => 'Batik By Butik bu Revi',
                'description' => 'Batik motif khas, kualitas premium.',
                'price' => 275000,
                'stock' => 50,
                'category' => 'Kerajinan',
                'image' => 'batik-by-butik-bu-revi.png',
            ],
            [
                'name' => 'Tempoyak wangi buk nessi',
                'description' => 'Tempoyak durian fermentasi, cita rasa khas.',
                'price' => 20000,
                'stock' => 100,
                'category' => 'Kuliner',
                'image' => 'batik-by-butik-bu-revi.png',
            ],
            [
                'name' => 'Es Jagung Pak banil',
                'description' => 'Minuman segar dari jagung manis.',
                'price' => 7000,
                'stock' => 120,
                'category' => 'Kuliner',
                'image' => 'batik-by-butik-bu-revi.png',
            ],
            [
                'name' => 'Buah potong pak andre',
                'description' => 'Aneka buah potong segar.',
                'price' => 15000,
                'stock' => 80,
                'category' => 'Kuliner',
                'image' => 'batik-by-butik-bu-revi.png',
            ],
            [
                'name' => 'Jasa Reparasi Baterai',
                'description' => 'Servis baterai perangkat elektronik.',
                'price' => 20000, // rentang di gambar 20k–100k, ambil harga bawah
                'stock' => 999,
                'category' => 'Jasa',
                'image' => 'batik-by-butik-bu-revi.png',
            ],
            [
                'name' => 'Es kelapa Kopyor bang Jalil',
                'description' => 'Es kopyor segar, cocok siang hari.',
                'price' => 10000,
                'stock' => 140,
                'category' => 'Kuliner',
                'image' => 'batik-by-butik-bu-revi.png',
            ],
            [
                'name' => 'Ramen Sangat gembira',
                'description' => 'Ramen kuah gurih hangat.',
                'price' => 25000,
                'stock' => 60,
                'category' => 'Kuliner',
                'image' => 'batik-by-butik-bu-revi.png',
            ],
            [
                'name' => 'Risol mayo mbak anne',
                'description' => 'Risol isi mayones, gurih lembut.',
                'price' => 5500,
                'stock' => 200,
                'category' => 'Kuliner',
                'image' => 'batik-by-butik-bu-revi.png',
            ],
            [
                'name' => 'Parfum bu Fira',
                'description' => 'Parfum lokal wangi tahan lama.',
                'price' => 75000,
                'stock' => 70,
                'category' => 'Kesehatan dan kecantikan',
                'image' => 'batik-by-butik-bu-revi.png',
            ],
            [
                'name' => 'Baju batik Pria',
                'description' => 'Batik pria modern.',
                'price' => 375000,
                'stock' => 40,
                'category' => 'Fashion dan Aksesoris',
                'image' => 'batik-by-butik-bu-revi.png',
            ],
            [
                'name' => 'Kebab khas Turki',
                'description' => 'Kebab lezat dengan saus spesial.',
                'price' => 18000,
                'stock' => 90,
                'category' => 'Kuliner',
                'image' => 'batik-by-butik-bu-revi.png',
            ],
        ];

        foreach ($datas as $data) {
            // Buat slug dari nama produk
            $data['slug'] = Str::slug($data['name']);

            // Buat kategori kalau belum ada
            $category = Category::firstOrCreate(
                ['slug' => Str::slug($data['category'])],
                ['name' => $data['category']]
            );

            // Ambil file image dan hapus dari array agar tidak disimpan ke DB
            $imageFile = $data['image'];
            unset($data['image']);

            // Simpan ke database
            $product = Product::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'slug' => $data['slug'],
                    'price' => $data['price'],
                    'stock' => $data['stock'],
                    'is_active' => true,
                    'category_id' => $category->id,
                    'user_id' => $user->id,
                ]
            );

            // Bersihkan media lama biar tidak duplikat
            $product->clearMediaCollection('product');

            // Path ke folder public/images/products/
            $imagePath = public_path('/images/products/' . $imageFile);

            // Tambahkan gambar jika ada
            if (file_exists($imagePath)) {
                $product->addMedia($imagePath)
                    ->preservingOriginal()
                    ->toMediaCollection('product');
            }
        }
    }
}
