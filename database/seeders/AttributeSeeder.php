<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Attribute::truncate();
        AttributeValue::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $size_attribute = Attribute::create([
            'name' => [
                'en' => 'Size',
                'ar' => 'الحجم',
            ],
        ]);
        $size_attribute->attributeValues()->createMany([
            [
                'value' => [
                    'en' => 'Small',
                    'ar' => 'صغير',
                ],
            ],
            [
                'value' =>[
                    'en' => 'Medium',
                    'ar' => 'متوسط',
                ],
            ],
            [
                'value' => [
                    'en' => 'Large',
                    'ar' => 'كبير',
                ],
            ],
        ]);

        $color_attribute = Attribute::create([
            'name' => [
                'en' => 'color',
                'ar' => 'اللون',
            ],
        ]);
        $color_attribute->attributeValues()->createMany([
            [
                'value' => [
                    'en' => 'Red',
                    'ar' => 'أحمر',
                ],
            ],
            [
                'value' => [
                    'en' => 'Blue',
                    'ar' => 'أزرق',
                ],
            ],
            [
                'value' => [
                    'en' => 'Green',
                    'ar' => 'أخضر',
                ],
            ],
            [
                'value' =>[
                    'en' => 'Black',
                    'ar' => 'أسود',
                ],
            ],
            [
                'value' =>[
                    'en' => 'White',
                    'ar' => 'أبيض',
                ],
            ]

        ]);
    }
}
