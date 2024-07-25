<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123'),
            'roles' => 'ADMIN'
        ] );
        DB::table('users')->insert([
            'name' => 'User1',
            'email' => 'user@gmail.com',
            'password' => bcrypt('123'),
            'roles' => 'USER'
        ] );
    }
}
