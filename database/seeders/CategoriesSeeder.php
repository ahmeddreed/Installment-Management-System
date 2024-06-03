<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Categories::create([
            'name'=> "هواتف",
            'user_id'=> 1,
            'created_at'=>now(),
        ]);
        Categories::create([
            'name'=> "اجهزة كهربائية",
            'user_id'=> 1,
            'created_at'=>now(),
        ]);
        Categories::create([
            'name'=> "اشياء اخرة",
            'user_id'=> 1,
            'created_at'=>now(),
        ]);
    }
}
