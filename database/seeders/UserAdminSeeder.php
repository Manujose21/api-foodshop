<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'OuVY4@example.com',
            'address' => '123 Main St',
            'phone' => '1234567890',
            'password' => bcrypt('12345678'),
            'role' => 'admin',
        ]);

    }
}
