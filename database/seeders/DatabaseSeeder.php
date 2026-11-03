<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    // Jalankan seluruh seeder database aplikasi
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            LeaveTypeSeeder::class,
            LeaveBalanceSeeder::class,
            LeaveRequestSeeder::class,
        ]);
    }
}
