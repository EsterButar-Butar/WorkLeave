<?php

namespace App\Services;

use App\Models\LeaveBalance;
use App\Models\LeaveType;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class LeaveBalanceService
{
    /**
     * Hitung total hari kerja antara dua tanggal (melewati hari Sabtu dan Minggu).
     */
    public function calculateWorkingDays(string|Carbon $startDate, string|Carbon $endDate): int
    {
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->startOfDay();

        if ($end->lt($start)) {
            return 0;
        }

        $period = CarbonPeriod::create($start, $end);
        $workingDays = 0;

        foreach ($period as $date) {
            // Hari kerja: Senin (1) s/d Jumat (5)
            if (!$date->isWeekend()) {
                $workingDays++;
            }
        }

        return $workingDays;
    }

    /**
     * Dapatkan atau buat data kuota cuti mitra di tahun tertentu.
     */
    public function getOrCreateBalance(User $user, LeaveType $leaveType, ?int $year = null): LeaveBalance
    {
        $year = $year ?? (int) date('Y');

        return LeaveBalance::firstOrCreate(
            [
                'user_id' => $user->id,
                'leave_type_id' => $leaveType->id,
                'year' => $year,
            ],
            [
                'initial_quota' => $leaveType->default_quota,
                'used_quota' => 0,
                'remaining_quota' => $leaveType->default_quota,
            ]
        );
    }

    /**
     * Periksa apakah sisa kuota mitra mencukupi untuk jumlah hari pengajuan.
     */
    public function hasEnoughBalance(User $user, LeaveType $leaveType, int $days, ?int $year = null): bool
    {
        // Jika jenis cuti tidak memiliki kuota default (misal izin darurat/khusus), anggap selalu cukup
        if ($leaveType->default_quota <= 0) {
            return true;
        }

        $balance = $this->getOrCreateBalance($user, $leaveType, $year);

        return $balance->remaining_quota >= $days;
    }

    /**
     * Potong kuota cuti saat permohonan disetujui.
     */
    public function deductBalance(User $user, LeaveType $leaveType, int $days, ?int $year = null): bool
    {
        if ($leaveType->default_quota <= 0) {
            return true;
        }

        $balance = $this->getOrCreateBalance($user, $leaveType, $year);

        $balance->used_quota += $days;
        $balance->remaining_quota = max(0, $balance->initial_quota - $balance->used_quota);
        return $balance->save();
    }

    /**
     * Kembalikan kuota cuti (misal saat dibatalkan).
     */
    public function restoreBalance(User $user, LeaveType $leaveType, int $days, ?int $year = null): bool
    {
        if ($leaveType->default_quota <= 0) {
            return true;
        }

        $balance = $this->getOrCreateBalance($user, $leaveType, $year);

        $balance->used_quota = max(0, $balance->used_quota - $days);
        $balance->remaining_quota = min($balance->initial_quota, $balance->initial_quota - $balance->used_quota);
        return $balance->save();
    }

    /**
     * Inisialisasi kuota tahunan untuk semua mitra aktif.
     */
    public function initializeYearlyBalancesForMitra(int $year): int
    {
        $mitras = User::where('role', 'mitra')->where('is_active', true)->get();
        $leaveTypes = LeaveType::all();
        $count = 0;

        foreach ($mitras as $mitra) {
            foreach ($leaveTypes as $type) {
                LeaveBalance::firstOrCreate(
                    [
                        'user_id' => $mitra->id,
                        'leave_type_id' => $type->id,
                        'year' => $year,
                    ],
                    [
                        'initial_quota' => $type->default_quota,
                        'used_quota' => 0,
                        'remaining_quota' => $type->default_quota,
                    ]
                );
                $count++;
            }
        }

        return $count;
    }
}
