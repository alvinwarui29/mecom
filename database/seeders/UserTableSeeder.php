<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("users")->insert([
            //admin
            [
                "name"=> "Admin",
                "email"=> "admin@gmail.com",
                "password"=> Hash::make("111"),
                "role"=> "admin",
                "status"=> "active",
            ],
            //user
            [
                "name"=> "user",
                "email"=> "user@gmail.com",
                "password"=> Hash::make("111"),
                "role"=> "user",
                "status"=> "active",
            ],
            //Vendor
            [
                "name"=> "vendor",
                "email"=> "vendor@gmail.com",
                "password"=> Hash::make("111"),
                "role"=> "vendor",
                "status"=> "active",
            ],

        ]);

    }
}
