<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Akun Admin / HR
        User::firstOrCreate(
            ['email' => 'admin@workleave.test'],
            [
                'name' => 'HR Administrator',
                'password' => Hash::make('password'),
                'role' => UserRole::ADMIN,
                'nip' => 'ADM-001',
                'phone' => '081234567890',
                'department' => 'Human Capital',
                'position' => 'HR Manager',
                'join_date' => '2022-01-01',
                'is_active' => true,
            ]
        );

        // 2. Akun Mitra Kerja 1
        User::firstOrCreate(
            ['email' => 'budi@workleave.test'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role' => UserRole::MITRA,
                'nip' => 'MTR-2024-001',
                'phone' => '081298765432',
                'department' => 'Technology & IT',
                'position' => 'Senior Frontend Developer',
                'join_date' => '2024-01-15',
                'is_active' => true,
            ]
        );

        // 3. Akun Mitra Kerja 2
        User::firstOrCreate(
            ['email' => 'siti@workleave.test'],
            [
                'name' => 'Siti Rahmawati',
                'password' => Hash::make('password'),
                'role' => UserRole::MITRA,
                'nip' => 'MTR-2024-002',
                'phone' => '081345678901',
                'department' => 'Digital Marketing',
                'position' => 'Content Specialist',
                'join_date' => '2024-03-01',
                'is_active' => true,
            ]
        );

        // 4. Akun Mitra Kerja 3
        User::firstOrCreate(
            ['email' => 'dimas@workleave.test'],
            [
                'name' => 'Dimas Prasetyo',
                'password' => Hash::make('password'),
                'role' => UserRole::MITRA,
                'nip' => 'MTR-2024-003',
                'phone' => '081456789012',
                'department' => 'Product & Design',
                'position' => 'UI/UX Designer',
                'join_date' => '2024-06-10',
                'is_active' => true,
            ]
        );
    }
}
