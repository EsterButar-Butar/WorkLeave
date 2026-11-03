<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    // Registrasi service aplikasi jika diperlukan
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Pastikan nama akun admin bawaan konsisten sebagai 'Admin'
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('users')) {
                \App\Models\User::where('email', 'admin@workleave.test')
                    ->where('name', '!=', 'Admin')
                    ->update(['name' => 'Admin']);
            }
        } catch (\Throwable $e) {
            // Abaikan saat setup CLI atau migrasi
        }
    }
}
