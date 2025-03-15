<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserstableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'username' => 'john_doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password123'),
                'created_at' => now()
            ],
            [
                'username' => 'jane_smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password456'),
                'created_at' => now()
            ],
            [
                'username' => 'alex_wilson',
                'email' => 'alex@example.com',
                'password' => Hash::make('password789'),
                'created_at' => now()
            ]
        ]);
    }
}
