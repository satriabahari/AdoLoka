<?php

namespace Database\Seeders;

use App\Models\EventAndUmkmCategory;
use App\Models\EventUmkmCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventAndUmkmCategorySeeder extends Seeder
{
    public function run(): void
    {
        foreach (['UMKM Kuliner', 'UMKM Perkebunan'] as $name) {
            EventAndUmkmCategory::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }
    }
}
