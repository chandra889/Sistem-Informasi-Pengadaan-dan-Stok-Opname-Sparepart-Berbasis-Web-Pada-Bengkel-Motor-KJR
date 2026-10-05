<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Akun Admin
        User::updateOrCreate(
            ['email' => 'admin@bengkel.com'],
            [
                'name'     => 'Admin Bengkel',
                'password' => Hash::make('password123'),
                'role'     => 'admin',
            ]
        );

        // Buat Akun Owner
        User::updateOrCreate(
            ['email' => 'owner@bengkel.com'],
            [
                'name'     => 'Owner Bengkel',
                'password' => Hash::make('password123'),
                'role'     => 'owner',
            ]
        );
    }
}
