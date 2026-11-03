<?php

namespace Database\Seeders;

use App\Models\LeaveType;
use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    // Jalankan seeder kategori jenis cuti (tahunan, bersalin, sakit)
    public function run(): void
    {
        $types = [
            [
                'name' => 'Cuti Tahunan',
                'code' => 'ANNUAL',
                'default_quota' => 12,
            ],
            [
                'name' => 'Cuti Bersalin',
                'code' => 'MATERNITY',
                'default_quota' => 90,
            ],
            [
                'name' => 'Cuti Sakit',
                'code' => 'SICK',
                'default_quota' => 7,
            ],
        ];

        foreach ($types as $type) {
            LeaveType::updateOrCreate(
                ['code' => $type['code']],
                $type
            );
        }
    }
}
