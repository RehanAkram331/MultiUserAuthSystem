<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create an admin user
        User::create([
            'name' => 'AdminUser',
            'email' => 'admin123@example.com',
            'password' => Hash::make('Admin@1234'), // Remember to hash the password
            'bio' => 'Admin bio',
            'profile_picture' => null,
        ]);
    }
}
