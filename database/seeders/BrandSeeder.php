<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Brand::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            [
                'name' => ['en' => 'Nike', 'ar' => 'نايكي'],
                'logo' => 'nike.png',
            ],
            [
                'name' => ['en' => 'Adidas', 'ar' => 'أديداس'],
                'logo' => 'adidas.png',
            ],
            [
                'name' => ['en' => 'Puma', 'ar' => 'بوما'],
                'logo' => 'puma.png',
            ],
            [
                'name' => ['en' => 'Reebok', 'ar' => 'ريبوك'],
                'logo' => 'reebok.png',
            ],
            [
                'name' => ['en' => 'Zara', 'ar' => 'زارا'],
                'logo' => 'zara.png',
            ],
            [
                'name' => ['en' => 'H&M', 'ar' => 'إتش آند إم'],
                'logo' => 'hm.png',
            ],
            [
                'name' => ['en' => 'Levi’s', 'ar' => 'ليفايس'],
                'logo' => 'levis.png',
            ],
            [
                'name' => ['en' => 'Uniqlo', 'ar' => 'يونيكلو'],
                'logo' => 'uniqlo.png',
            ],
            [
                'name' => ['en' => 'Lacoste', 'ar' => 'لاكوست'],
                'logo' => 'lacoste.png',
            ],
            [
                'name' => ['en' => 'Calvin Klein', 'ar' => 'كالفن كلاين'],
                'logo' => 'calvin-klein.png',
            ],
        ];
        foreach ($data as $brand) {
            Brand::create($brand);
        }
    }
}
