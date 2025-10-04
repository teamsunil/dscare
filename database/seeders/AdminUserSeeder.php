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
<<<<<<< HEAD
=======
            'email' => "admin@example.com",  // hash the password!
>>>>>>> ec031a190c7dd3a7601fa865f2938e0b916bb5b3
            // 'role' => 'admin',  // if you have a role column
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
