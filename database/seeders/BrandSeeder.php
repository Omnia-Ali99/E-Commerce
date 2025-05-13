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
                'name' => ['en' => 'Apple', 'ar' => 'ابل'],
                'logo' => 'https://logos-world.net/wp-content/uploads/2020/04/Apple-Logo.png',
            ],
            [
                'name' => ['en' => 'Google', 'ar' => 'جوجل'],
                'logo' => 'https://logos-world.net/wp-content/uploads/2020/09/Google-Logo.png',
            ],
            [
                'name' => ['en' => 'Xiaomi', 'ar' => 'شاومي'],
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/2/29/Xiaomi_logo.png',
            ],
            [
                'name' => ['en' => 'OnePlus', 'ar' => 'وان بلس'],
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/a/ab/OnePlus_logo.png',
            ],
            [
                'name' => ['en' => 'Oppo', 'ar' => 'أوبو'],
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/6/6e/OPPO_LOGO.png',
            ],
            [
                'name' => ['en' => 'Vivo', 'ar' => 'فيفو'],
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/0/0c/Vivo_logo.png',
            ],
            [
                'name' => ['en' => 'Realme', 'ar' => 'ريال ميل'],
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/7/70/Realme_logo.png',
            ],
            [
                'name' => ['en' => 'Samsung', 'ar' => 'سامسونج'],
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/2/24/Samsung_Logo.png',
            ],
            [
                'name' => ['en' => 'Huawei', 'ar' => 'هواوي'],
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/e/e0/Huawei_Logo.png',
            ],
            [
                'name' => ['en' => 'Sony', 'ar' => 'سوني'],
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/0/01/Sony_logo.png',
            ],
            [
                'name' => ['en' => 'Nokia', 'ar' => 'نوكيا'],
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/8/89/Nokia_logo.png',
            ],
            [
                'name' => ['en' => 'Lenovo', 'ar' => 'لينوفو'],
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/c/c8/Lenovo_logo.png',
            ],
            [
                'name' => ['en' => 'LG', 'ar' => 'إل جي'],
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/e/e8/LG_logo.png',
            ],
            [
                'name' => ['en' => 'Asus', 'ar' => 'أسوس'],
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/2/26/Asus_Logo.png',
            ],
            [
                'name' => ['en' => 'Dell', 'ar' => 'ديل'],
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/c/cd/Dell_Logo.png',
            ],
            [
                'name' => ['en' => 'HP', 'ar' => 'إتش بي'],
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/0/0d/HP_logo.png',
            ],
            [
                'name' => ['en' => 'Acer', 'ar' => 'أيسر'],
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/4/4c/Acer_Logo.png',
            ],
            [
                'name' => ['en' => 'Microsoft', 'ar' => 'مايكروسوفت'],
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/3/33/Microsoft_logo.png',
            ],
            [
                'name' => ['en' => 'Intel', 'ar' => 'إنتل'],
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/7/70/Intel_Logo.png',
            ],
            [
                'name' => ['en' => 'AMD', 'ar' => 'إيه إم دي'],
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/e/eb/AMD_Logo.png',
            ],
            [
                'name' => ['en' => 'Nike', 'ar' => 'نايكي'],
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/a/a6/Nike_logo.png',
            ],
            [
                'name' => ['en' => 'Adidas', 'ar' => 'أديداس'],
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/6/6a/Adidas_logo.png',
            ],
            [
                'name' => ['en' => 'Puma', 'ar' => 'بوما'],
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/8/89/Puma_logo.png',
            ],
            [
                'name' => ['en' => 'Reebok', 'ar' => 'ريبوك'],
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/2/20/Reebok_logo.png',
            ],
            [
                'name' => ['en' => 'Zara', 'ar' => 'زارا'],
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/d/da/Zara_logo.png',
            ],
            [
                'name' => ['en' => 'H&M', 'ar' => 'إتش أند إم'],
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/7/75/H%26M_Logo.png',
            ],
        ];

        foreach ($data as $brand) {
            Brand::create($brand);
        }
    }
}
