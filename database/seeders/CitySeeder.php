<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        City::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $cities = [

            [
                'governorate_id' => 1,
                'name' => [
                    'ar' => 'المندرة',
                    'en' => 'El Mandara',
                ],
            ],
            [
                'governorate_id' => 1,
                'name' => [
                    'ar' => 'برج العرب',
                    'en' => 'Borg El Arab',
                ],
            ],
            [
                'governorate_id' => 1,
                'name' => [
                    'ar' => 'المنتزه',
                    'en' => 'El Montaza',
                ],
            ],

            // Cairo Governorate (ID: 2)
            [
                'governorate_id' => 2,
                'name' => [
                    'ar' => 'مدينة نصر',
                    'en' => 'Nasr City',
                ],
            ],
            [
                'governorate_id' => 2,
                'name' => [
                    'ar' => 'مصر الجديدة',
                    'en' => 'Heliopolis',
                ],
            ],
            [
                'governorate_id' => 2,
                'name' => [
                    'ar' => 'المعادي',
                    'en' => 'Maadi',
                ],
            ],
        ];

        // Seed cities
        foreach ($cities as $city) {
            City::create($city);
        }
    }
}
