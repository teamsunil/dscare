<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin User',
            'username' => 'Dots123',
            'password' => Hash::make('admin123'),  // hash the password!
            'email' => "admin@example.com",  // hash the password!
            // 'role' => 'admin',  // if you have a role column
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
