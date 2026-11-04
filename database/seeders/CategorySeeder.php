<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Category::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            // Main Categories
            [
                'name' => ['en' => 'Men Fashion', 'ar' => 'ملابس رجالي'],
                'status' => 1,
                'parent' => null,
                'icon' => 'men.webp',
            ],
            [
                'name' => ['en' => 'Women Fashion', 'ar' => 'ملابس حريمي'],
                'status' => 1,
                'parent' => null,
                'icon' => 'women.webp',
            ],
            [
                'name' => ['en' => 'Kids Fashion', 'ar' => 'ملابس أطفال'],
                'status' => 1,
                'parent' => null,
                'icon' => 'kids.webp',
            ],
            [
                'name' => ['en' => 'Shoes', 'ar' => 'أحذية'],
                'status' => 1,
                'parent' => null,
                'icon' => 'shoes.webp',
            ],
            [
                'name' => ['en' => 'Bags', 'ar' => 'شنط'],
                'status' => 1,
                'parent' => null,
                'icon' => 'bags.webp',
            ],
            [
                'name' => ['en' => 'Accessories', 'ar' => 'إكسسوارات'],
                'status' => 1,
                'parent' => null,
                'icon' => 'accessories.webp',
            ],

            // Men Subcategories
            [
                'name' => ['en' => 'T-Shirts', 'ar' => 'تيشيرتات'],
                'status' => 1,
                'parent' => 1,
                'icon' => 'tshirts.webp',
            ],
            [
                'name' => ['en' => 'Shirts', 'ar' => 'قمصان'],
                'status' => 1,
                'parent' => 1,
                'icon' => 'shirts.webp',
            ],
            [
                'name' => ['en' => 'Jeans', 'ar' => 'جينز'],
                'status' => 1,
                'parent' => 1,
                'icon' => 'jeans.webp',
            ],
            [
                'name' => ['en' => 'Jackets', 'ar' => 'جاكيتات'],
                'status' => 1,
                'parent' => 1,
                'icon' => 'jackets.webp',
            ],

            // Women Subcategories
            [
                'name' => ['en' => 'Dresses', 'ar' => 'فساتين'],
                'status' => 1,
                'parent' => 2,
                'icon' => 'dresses.webp',
            ],
            [
                'name' => ['en' => 'Blouses', 'ar' => 'بلوزات'],
                'status' => 1,
                'parent' => 2,
                'icon' => 'blouses.webp',
            ],
            [
                'name' => ['en' => 'Skirts', 'ar' => 'جيبات'],
                'status' => 1,
                'parent' => 2,
                'icon' => 'skirts.webp',
            ],

            // Kids Subcategories
            [
                'name' => ['en' => 'Boys Clothing', 'ar' => 'ملابس أولاد'],
                'status' => 1,
                'parent' => 3,
                'icon' => 'boys.webp',
            ],
            [
                'name' => ['en' => 'Girls Clothing', 'ar' => 'ملابس بنات'],
                'status' => 1,
                'parent' => 3,
                'icon' => 'girls.webp',
            ],

            // Shoes Subcategories
            [
                'name' => ['en' => 'Sneakers', 'ar' => 'كوتشي'],
                'status' => 1,
                'parent' => 4,
                'icon' => 'sneakers.webp',
            ],
            [
                'name' => ['en' => 'Formal Shoes', 'ar' => 'أحذية كلاسيك'],
                'status' => 1,
                'parent' => 4,
                'icon' => 'formal-shoes.webp',
            ],
            [
                'name' => ['en' => 'Sandals', 'ar' => 'صنادل'],
                'status' => 1,
                'parent' => 4,
                'icon' => 'sandals.webp',
            ],

            // Bags Subcategories
            [
                'name' => ['en' => 'Backpacks', 'ar' => 'حقائب ظهر'],
                'status' => 1,
                'parent' => 5,
                'icon' => 'backpacks.webp',
            ],
            [
                'name' => ['en' => 'Handbags', 'ar' => 'حقائب يد'],
                'status' => 1,
                'parent' => 5,
                'icon' => 'handbags.webp',
            ],

            // Accessories Subcategories
            [
                'name' => ['en' => 'Watches', 'ar' => 'ساعات'],
                'status' => 1,
                'parent' => 6,
                'icon' => 'watches.webp',
            ],
            [
                'name' => ['en' => 'Belts', 'ar' => 'أحزمة'],
                'status' => 1,
                'parent' => 6,
                'icon' => 'belts.webp',
            ],
            [
                'name' => ['en' => 'Caps', 'ar' => 'كابات'],
                'status' => 1,
                'parent' => 6,
                'icon' => 'caps.webp',
            ],
        ];



        foreach ($data as $cat) {
            Category::create($cat);
        }
    }
}
