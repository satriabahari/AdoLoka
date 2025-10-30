<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\EventAndUmkmCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EventRegistrationSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            // Pastikan event dan kategori tersedia
            if (Event::count() === 0) {
                $this->call(EventSeeder::class);
            }
            if (EventAndUmkmCategory::count() === 0) {
                $this->call(EventAndUmkmCategorySeeder::class);
            }

            $faker = fake('id_ID');
            $categories = EventAndUmkmCategory::pluck('id')->toArray();

            // File dummy opsional
            $brandPhoto   = public_path('images/seed/brand_photo.jpg');
            $productPhoto = public_path('images/seed/product_photo.jpg');
            $ktpPhoto     = public_path('images/seed/ktp_photo.jpg');

            Event::query()->each(function (Event $event) use ($faker, $categories, $brandPhoto, $productPhoto, $ktpPhoto) {
                $registrantCount = $faker->numberBetween(2, 5);

                for ($i = 0; $i < $registrantCount; $i++) {
                    $brandName = Str::headline($faker->unique()->words($faker->numberBetween(1, 3), true));

                    $registration = EventRegistration::create([
                        'event_id'                => $event->id,
                        'umkm_brand_name'         => $brandName,
                        'partner_address'         => $faker->streetAddress() . ', ' . $faker->city(),
                        'event_category_id'       => $faker->randomElement($categories), // ganti business_type
                        'owner_name'              => $faker->name(),
                        'whatsapp_number'         => $this->indoWhatsapp($faker->numerify('08##########')),
                        'instagram_name'          => Str::lower(Str::slug($brandName, '_')),
                        'business_license_number' => strtoupper($faker->bothify('NIB-##########')),
                    ]);

                    // Tambah media ke koleksi 'event_registration'
                    $this->attachReplaceByKind($registration, 'brand', $brandPhoto);
                    $this->attachReplaceByKind($registration, 'product', $productPhoto);
                    $this->attachReplaceByKind($registration, 'ktp', $ktpPhoto);
                }
            });
        });
    }

    private function indoWhatsapp(string $number): string
    {
        $n = preg_replace('/\D+/', '', $number);
        if (Str::startsWith($n, '62')) {
            $n = '0' . substr($n, 2);
        }
        if (!Str::startsWith($n, '0')) {
            $n = '0' . $n;
        }
        return $n;
    }

    private function attachReplaceByKind(EventRegistration $registration, string $kind, string $path): void
    {
        $registration->getMedia('event_registration')
            ->filter(fn($m) => $m->getCustomProperty('kind') === $kind)
            ->each->delete();

        if (is_file($path)) {
            $registration
                ->addMedia($path)
                ->withCustomProperties(['kind' => $kind])
                ->preservingOriginal()
                ->toMediaCollection('event_registration');
        }
    }
}
