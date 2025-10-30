<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            EventAndUmkmCategorySeeder::class,
            UmkmSeeder::class,
            EventSeeder::class,
            EventRegistrationSeeder::class,
            ProductCategorySeeder::class,
            ProductSeeder::class,
            ServiceCategorySeeder::class,
            ServiceSeeder::class,
        ]);
    }
}
