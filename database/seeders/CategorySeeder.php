<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            'Kuliner',
            'Kerajinan',
            'Kesehatan dan kecantikan',
            'Jasa',
            'Fashion dan Aksesoris',
            'Perkebunan',
        ];

        foreach ($items as $item) {
            Category::updateOrCreate(
                ['slug' => Str::slug($item)],
                ['name' => $item]
            );
        }
    }
}
