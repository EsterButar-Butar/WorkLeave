<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LeaveRequestSeeder extends Seeder
{
    // Jalankan seeder data pengajuan cuti
    public function run(): void
    {
        // Default bersih: Tidak ada permohonan cuti dummy.
        // Seluruh permohonan cuti dan notifikasi admin akan murni berasal dari pengajuan pengguna/mitra yang terdaftar.
    }
}
