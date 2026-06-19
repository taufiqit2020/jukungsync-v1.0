<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat akun admin jika belum ada
        User::firstOrCreate(
            ['email' => 'admin@umar.com'],
            [
                'name' => 'Owner / Admin UMAR',
                'password' => Hash::make('password123'),
                'role' => 'superadmin'
            ]
        );
    }
}
