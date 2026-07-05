<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin user
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // Analyst user
        User::updateOrCreate(
            ['email' => 'analyst@example.com'],
            [
                'name' => 'Analyst',
                'password' => Hash::make('password123'),
                'role' => 'analyst',
            ]
        );
    }
}