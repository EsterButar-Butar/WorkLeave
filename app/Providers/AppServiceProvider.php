<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
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
                    ->where(function ($query) {
                        $query->where('name', '!=', 'Admin')
                              ->orWhere('position', '!=', 'Admin');
                    })
                    ->update(['name' => 'Admin', 'position' => 'Admin']);
            }
        } catch (\Throwable $e) {
            // Abaikan saat setup CLI atau migrasi
        }
    }
}
