<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 1 Akun Admin (Hanya ini satu-satunya admin)
        User::create([
            'name' => 'Administrator IKPP',
            'email' => 'admin@ikpp.com',
            'password' => Hash::make('passwordadmin'), // Password Admin
            'role' => 'admin',
            'email_verified_at' => now(), // Admin otomatis terverifikasi (tidak perlu cek email)
        ]);
    }
}