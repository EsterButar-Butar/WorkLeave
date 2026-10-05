<?php

namespace Database\Seeders;

use App\Enums\LeaveStatus;
use App\Models\LeaveApproval;
use App\Models\LeaveBalance;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class LeaveRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $budi = User::where('email', 'budi@workleave.test')->first();
        $siti = User::where('email', 'siti@workleave.test')->first();
        $dimas = User::where('email', 'dimas@workleave.test')->first();

        $annualLeave = LeaveType::where('code', 'ANNUAL')->first();
        $sickLeave = LeaveType::where('code', 'SICK')->first();
        $importantLeave = LeaveType::where('code', 'IMPORTANT')->first();

        $year = (int) date('Y');

        if (!$admin || !$budi || !$siti || !$dimas || !$annualLeave) {
            return;
        }

        // 1. Pengajuan Cuti Disetujui (Budi Santoso) - 3 hari
        $budiReq = LeaveRequest::firstOrCreate(
            [
                'user_id' => $budi->id,
                'reason' => 'Keperluan keluarga di luar kota',
            ],
            [
                'leave_type_id' => $annualLeave->id,
                'start_date' => Carbon::now()->subDays(10)->toDateString(),
                'end_date' => Carbon::now()->subDays(8)->toDateString(),
                'total_days' => 3,
                'emergency_contact' => '081299990001',
                'status' => LeaveStatus::APPROVED,
                'approved_by' => $admin->id,
                'action_at' => Carbon::now()->subDays(11),
            ]
        );

        LeaveApproval::firstOrCreate(
            ['leave_request_id' => $budiReq->id],
            [
                'action_by' => $admin->id,
                'action' => 'approved',
                'notes' => 'Disetujui. Pastikan serah terima tugas sudah selesai sebelum cuti.',
            ]
        );

        // Update sisa cuti Budi
        $budiBalance = LeaveBalance::where('user_id', $budi->id)
            ->where('leave_type_id', $annualLeave->id)
            ->where('year', $year)
            ->first();

        if ($budiBalance) {
            $budiBalance->update([
                'used_quota' => 3,
                'remaining_quota' => max(0, $budiBalance->initial_quota - 3),
            ]);
        }

        // 2. Pengajuan Cuti Menunggu Persetujuan / Pending (Siti Rahmawati) - 2 hari
        LeaveRequest::firstOrCreate(
            [
                'user_id' => $siti->id,
                'reason' => 'Perpanjangan dokumen kependudukan dan urusan administrasi keluarga',
            ],
            [
                'leave_type_id' => $annualLeave->id,
                'start_date' => Carbon::now()->addDays(3)->toDateString(),
                'end_date' => Carbon::now()->addDays(4)->toDateString(),
                'total_days' => 2,
                'emergency_contact' => '081388880002',
                'status' => LeaveStatus::PENDING,
            ]
        );

        // 3. Pengajuan Cuti Sakit Disetujui (Dimas Prasetyo) - 2 hari
        $dimasReq = LeaveRequest::firstOrCreate(
            [
                'user_id' => $dimas->id,
                'reason' => 'Demam dan flu berat, istirahat atas saran dokter',
            ],
            [
                'leave_type_id' => $sickLeave->id,
                'start_date' => Carbon::now()->subDays(4)->toDateString(),
                'end_date' => Carbon::now()->subDays(3)->toDateString(),
                'total_days' => 2,
                'emergency_contact' => '081477770003',
                'status' => LeaveStatus::APPROVED,
                'approved_by' => $admin->id,
                'action_at' => Carbon::now()->subDays(4),
            ]
        );

        LeaveApproval::firstOrCreate(
            ['leave_request_id' => $dimasReq->id],
            [
                'action_by' => $admin->id,
                'action' => 'approved',
                'notes' => 'Surat dokter terverifikasi. Semoga lekas sembuh.',
            ]
        );

        $dimasBalance = LeaveBalance::where('user_id', $dimas->id)
            ->where('leave_type_id', $sickLeave->id)
            ->where('year', $year)
            ->first();

        if ($dimasBalance) {
            $dimasBalance->update([
                'used_quota' => 2,
                'remaining_quota' => max(0, $dimasBalance->initial_quota - 2),
            ]);
        }

        // 4. Pengajuan Ditolak (Dimas Prasetyo)
        $dimasReject = LeaveRequest::firstOrCreate(
            [
                'user_id' => $dimas->id,
                'reason' => 'Liburan ke pantai bersama teman',
            ],
            [
                'leave_type_id' => $annualLeave->id,
                'start_date' => Carbon::now()->subDays(20)->toDateString(),
                'end_date' => Carbon::now()->subDays(18)->toDateString(),
                'total_days' => 3,
                'emergency_contact' => '081477770003',
                'status' => LeaveStatus::REJECTED,
                'approved_by' => $admin->id,
                'action_at' => Carbon::now()->subDays(21),
                'rejection_reason' => 'Jadwal bertepatan dengan masa rilis sprint project MBKM.',
            ]
        );

        LeaveApproval::firstOrCreate(
            ['leave_request_id' => $dimasReject->id],
            [
                'action_by' => $admin->id,
                'action' => 'rejected',
                'notes' => 'Jadwal bertepatan dengan masa rilis sprint project MBKM.',
            ]
        );
    }
}
