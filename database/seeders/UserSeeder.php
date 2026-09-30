<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'username' => 'developer',
                'email' => 'developer@example.com',
                'name' => 'Developer',
                'password' => bcrypt('password'),
                'created_at' => now(),
            ]
        ]);
    }
}
