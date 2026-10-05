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
                'name' => 'Cuti Sakit',
                'code' => 'SICK',
                'default_quota' => 14,
                'is_paid' => true,
                'requires_attachment' => true,
                'description' => 'Izin tidak masuk kerja karena sakit dengan melampirkan surat keterangan dokter.',
            ],
            [
                'name' => 'Cuti Alasan Penting',
                'code' => 'IMPORTANT',
                'default_quota' => 5,
                'is_paid' => true,
                'requires_attachment' => false,
                'description' => 'Cuti untuk keperluan darurat keluarga, pernikahan, atau kedukaan.',
            ],
            [
                'name' => 'Cuti Melahirkan',
                'code' => 'MATERNITY',
                'default_quota' => 90,
                'is_paid' => true,
                'requires_attachment' => true,
                'description' => 'Hak cuti persalinan bagi mitra wanita dengan masa 3 bulan.',
            ],
            [
                'name' => 'Izin Non-Cuti / Khusus',
                'code' => 'SPECIAL',
                'default_quota' => 0,
                'is_paid' => false,
                'requires_attachment' => false,
                'description' => 'Izin dispensasi khusus atau keperluan mendadak di luar kuota cuti tahunan.',
            ],
        ];

        foreach ($types as $type) {
            LeaveType::firstOrCreate(
                ['code' => $type['code']],
                $type
            );
        }
    }
}
