<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Admin::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        
        $first_role_id = Role::first()->id;
        Admin::create([
            'name' =>'admin',
            'email' => 'admin@gmail.com',
            'password' =>bcrypt('password'),
            'role_id'=>$first_role_id,
        ]);
    }
}
