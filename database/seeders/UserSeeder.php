<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    // Jalankan seeder akun pengguna (admin & mitra)
    public function run(): void
    {
        // 1. Akun Admin Utama
        User::updateOrCreate(
            ['email' => 'admin@workleave.test'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => UserRole::ADMIN,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Catatan: Tidak ada data dummy pegawai/mitra.
        // Data pegawai/mitra hanya akan terisi secara dinamis saat ada pengguna yang melakukan register.
    }
}
