<?php

namespace Database\Seeders;

use App\Models\LeaveType;
use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'name' => 'Cuti Tahunan',
                'code' => 'ANNUAL',
                'default_quota' => 12,
                'is_paid' => true,
                'requires_attachment' => false,
                'description' => 'Hak cuti tahunan mitra kerja sebanyak 12 hari kerja per tahun kalender.',
            ],
            [
                'name' => 'Cuti Bersalin',
                'code' => 'MATERNITY',
                'default_quota' => 90,
                'is_paid' => true,
                'requires_attachment' => true,
                'description' => 'Hak cuti persalinan bagi mitra wanita dengan masa 90 hari kalender penuh.',
            ],
            [
                'name' => 'Cuti Sakit',
                'code' => 'SICK',
                'default_quota' => 7,
                'is_paid' => true,
                'requires_attachment' => true,
                'description' => 'Izin tidak masuk kerja karena sakit dengan melampirkan surat dokter (maksimal 7 hari kerja).',
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
