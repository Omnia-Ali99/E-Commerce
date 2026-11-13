<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $country = Country::inRandomOrder()->first();
        $country_id = $country->id;
        $governorate = $country->governorates()->inRandomOrder()->first();
        $governorate_id = $governorate->id;

        for ($i = 0; $i < 10; $i++) {
            $user = User::create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'email_verified_at' => now(),
                'is_active' => 1,
                'country_id' => $country_id,
                'governorate_id' => $governorate_id,
                'city_id' => rand(1, 4),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ]);

            $user->cart()->firstOrCreate([]);
        }
    }
}
