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
            ['name'=>['en'=>'Electronics', 'ar'=>'الكترونيات'], 'status'=>1, 'parent'=>null,'icon'=>'icon.webp'],
            ['name'=>['en'=>'Fashion', 'ar'=>'موضة'], 'status'=>1, 'parent'=>null,'icon'=>'icon.webp'],
            ['name'=>['en'=>'Books', 'ar'=>'كتب'], 'status'=>1, 'parent'=>null,'icon'=>'icon.webp'],
            ['name'=>['en'=>'Home & Kitchen', 'ar'=>'المنزل والمطبخ'], 'status'=>1, 'parent'=>null,'icon'=>'icon.webp'],
            ['name'=>['en'=>'Beauty & Health', 'ar'=>'الجمال والصحة'], 'status'=>1, 'parent'=>null,'icon'=>'icon.webp'],
            ['name'=>['en'=>'Toys & Games', 'ar'=>'ألعاب'], 'status'=>1, 'parent'=>null,'icon'=>'icon.webp'],
            ['name'=>['en'=>'Sports', 'ar'=>'رياضة'], 'status'=>1, 'parent'=>null,'icon'=>'icon.webp'],
            ['name'=>['en'=>'Automotive', 'ar'=>'السيارات'], 'status'=>1, 'parent'=>null,'icon'=>'icon.webp'],
            ['name'=>['en'=>'Grocery', 'ar'=>'بقالة'], 'status'=>1, 'parent'=>null,'icon'=>'icon.webp'],
            ['name'=>['en'=>'Furniture', 'ar'=>'أثاث'], 'status'=>1, 'parent'=>null,'icon'=>'icon.webp'],
            ['name'=>['en'=>'Music', 'ar'=>'موسيقى'], 'status'=>1, 'parent'=>null,'icon'=>'icon.webp'],
            ['name'=>['en'=>'Pet Supplies', 'ar'=>'مستلزمات الحيوانات'], 'status'=>1, 'parent'=>null,'icon'=>'icon.webp'],
            ['name'=>['en'=>'Garden & Outdoors', 'ar'=>'الحديقة والخارج'], 'status'=>1, 'parent'=>null,'icon'=>'icon.webp'],
        ];


        foreach($data as $cat){
            Category::create($cat);
        }
    }
}
