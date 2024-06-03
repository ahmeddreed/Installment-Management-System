<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Manager extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
           "name"=>"ahmed dreed",
            "email"=>"ahmed@gmail.com",
            "password"=>'$2y$10$bUHdXatIi7DFJDwhXMraA.lcHeoe.Li7OxSfB.bZfI0Be4gM9q1Pu',
            "role_id"=>1,
            "img"=>"img/staff.png",
            "created_at"=>now(),
        ]);
    }
}
