<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Roles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            "id"=>1,
            "name"=>"manager",
        ]);
        Role::create([
            "id"=>2,
            "name"=>"staff",
        ]);

    }
}
