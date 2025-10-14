<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'title' => 'Pasar Buah Jambi',
                'description' => 'Jadikan usahamu terkenal pada event tersebut.',
                'location' => 'Kota Jambi',
                'start_date' => '2026-08-10',
                'end_date'   => '2026-08-10',
                'type' => 'tahunan',
                'category' => 'UMKM Perkebunan',
                'is_strategic_location' => true,
                'image' => 'pasar-buah-jambi.png',
            ],
            [
                'title' => 'Car Free Night',
                'description' => 'Ramaikan malam bebas kendaraan sambil berjualan.',
                'location' => 'Lapangan Kantor Gubernur',
                'start_date' => '2026-09-23',
                'end_date'   => '2026-09-23',
                'type' => 'mingguan',
                'category' => 'UMKM Kuliner',
                'is_strategic_location' => true,
                'image' => 'car-free-night.png',
            ],
            [
                'title' => 'Car Free Day',
                'description' => 'Kesempatan branding usahamu di CFD.',
                'location' => 'Jl. Jend. Sudirman',
                'start_date' => '2026-09-28',
                'end_date'   => '2026-09-28',
                'type' => 'mingguan',
                'category' => 'UMKM Kuliner',
                'is_strategic_location' => true,
                'image' => 'car-free-day.png',
            ],
        ];

        foreach ($datas as $data) {
            $data['slug'] = Str::slug($data['title']);

            // Ambil nama file gambar & hapus dari array supaya tidak disimpan ke DB
            $imageFile = $data['image'];
            unset($data['image']); // ❗ ini kuncinya

            // Simpan event ke database (tanpa kolom image)
            $event = Event::updateOrCreate(['slug' => $data['slug']], $data);

            // Bersihkan media lama biar tidak dobel saat seeding ulang
            $event->clearMediaCollection('event');

            // Path ke gambar di folder public/images/events
            $imagePath = public_path('/images/events/' . $imageFile);

            // Cek apakah file gambar ada
            if (file_exists($imagePath)) {
                $event->addMedia($imagePath)
                    ->preservingOriginal()
                    ->toMediaCollection('event');
            }
        }
    }
}
