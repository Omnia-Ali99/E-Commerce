<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use App\Models\ProductPreview;
use App\Models\ProductVariant;
use App\Models\VariantAttribute;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ProductVariant::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        VariantAttribute::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = Factory::create();

        $categoryIds = DB::table('categories')->pluck('id')->toArray();
        $brandIds = DB::table('brands')->pluck('id')->toArray();
        $userIds = DB::table('users')->pluck('id')->toArray();

        foreach (range(1, 30) as $i) {
            $name = $faker->words(3, true);
            $hasVariants = rand(0, 1);
            $hasDiscount = $faker->boolean;
            $manageStock = $faker->boolean;

            if($hasVariants){
                $product = Product::create([
                    'name' => [
                        'en'=>$name,
                        'ar'=>$name
                    ],
                    'slug' => Str::slug($name) . '-' . Str::random(5),
                    'small_desc' =>[
                        'en'=> $faker->sentence,
                        'ar'=> $faker->sentence
                    ],
                    'desc' => [
                        'en'=>$faker->paragraph(5),
                        'ar'=>$faker->paragraph(5)
                    ],
                    'status' => 1,
                    'sku' => strtoupper(Str::random(10)),
                    'available_for' => $faker->optional()->dateTimeBetween('now', '+1 year'),
                    'views' => $faker->numberBetween(0, 1000),

                    'has_variants' =>1,
                    'price' => null,
                    'has_discount' =>0,
                    'discount' =>  null,
                    'start_discount' => null,
                    'end_discount' => null,

                    'manage_stock' => 1,
                    'quantity' =>0 ,
                    'available_in_stock' =>1,

                    'category_id' => $faker->randomElement($categoryIds),
                    'brand_id' => $faker->randomElement($brandIds),
                ]);
                // create variants
                for ($i = 0; $i < 3; $i++) {
                    $variant = $product->variants()->create([
                        'price' => $faker->numberBetween(100, 1000),
                        'stock' => $faker->numberBetween(0, 1000),
                    ]);
                    // create varant attributes
                    $value_id = 1;
                    for ($j = 0; $j < 2; $j++) {
                        $variant->variantAttributes()->create([
                            'attribute_value_id' => $value_id,
                            'product_variant_id' => $variant->id,
                        ]);
                        $value_id+=5;
                    }
                }

            }else{
                $product = Product::create([
                    'name' => [
                        'en'=>$name,
                        'ar'=>$name
                    ],
                    'slug' => Str::slug($name) . '-' . Str::random(5),
                    'small_desc' =>[
                        'en'=> $faker->sentence,
                        'ar'=> $faker->sentence
                    ],
                    'desc' => [
                        'en'=>$faker->paragraph(5),
                        'ar'=>$faker->paragraph(5)
                    ],
                    'status' => 1,
                    'sku' => strtoupper(Str::random(10)),
                    'available_for' => $faker->optional()->dateTimeBetween('now', '+1 year'),
                    'views' => $faker->numberBetween(0, 1000),

                    'has_variants' => 0,
                    'price' => $hasVariants ? null : $faker->randomFloat(0, 70, 1000),
                    'has_discount' => $hasDiscount,
                    'discount' => $hasDiscount ? $faker->randomFloat(0 ,1, 50) : null,
                    'start_discount' => $hasDiscount ? now() : null,
                    'end_discount' => $hasDiscount ? now()->addDays(rand(5, 30)) : null,

                    'manage_stock' => $manageStock,
                    'quantity' => $hasVariants && $manageStock == 0 ? null : $faker->numberBetween(10, 200),
                    'available_in_stock' => $faker->boolean,

                    'category_id' => $faker->randomElement($categoryIds),
                    'brand_id' => $faker->randomElement($brandIds),
                ]);

            }

            // Attach 2 images
            foreach (range(1, 2) as $j) {
                ProductImage::create([
                    'file_name' => 'fake_image_' .rand(1,6) . '.jpg',
                    'file_size' => $faker->numberBetween(100, 500) . 'KB',
                    'file_type' => 'image/jpeg',
                    'product_id' => $product->id,
                ]);
            }

            // Attach 4 to 6 previews
            foreach (range(1, rand(4, 6)) as $k) {
                ProductPreview::create([
                    'comment' => $faker->sentence,
                    'product_id' => $product->id,
                    'user_id' => $faker->randomElement($userIds),
                ]);
            }
        }
    }
}