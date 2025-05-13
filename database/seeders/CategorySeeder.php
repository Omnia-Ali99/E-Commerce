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
            [
                'name'=>['en'=>'elctronics' , 'ar'=>'الكترونيات'],
                'status'=>1,
                'parent'=>null,
            ],
            [
                'name'=>['en'=>'category2' , 'ar'=>'التصنيف الثاني'],
                'status'=>1,
                'parent'=>null,
            ],
            [
                'name'=>['en'=>'category3' , 'ar'=>'التصنيف الثالث'],
                'status'=>1,
                'parent'=>null,
            ],
            [
                'name'=>['en'=>'category4' , 'ar'=>'التصنيف الرابع'],
                'status'=>1,
                'parent'=>null,
            ],
        ];

        foreach($data as $cat){
            Category::create($cat);
        }
    }
}
