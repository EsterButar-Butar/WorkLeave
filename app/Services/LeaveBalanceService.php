<?php

namespace App\Services;

use App\Models\LeaveBalance;
use App\Models\LeaveType;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

    public function __construct(
        protected ?HolidayService $holidayService = null
    ) {
        $this->holidayService = $holidayService ?? new HolidayService();
    }

    /**
     * Hitung total hari kerja antara dua tanggal.
     * Khusus Cuti Tahunan (ANNUAL): Hari akhir pekan (Sabtu/Minggu) dan hari libur nasional Indonesia tidak dihitung.
     */
    public function calculateWorkingDays(string|Carbon $startDate, string|Carbon $endDate, string $leaveTypeCode = 'ANNUAL'): int
    {
        $result = $this->holidayService->calculateDays($startDate, $endDate, $leaveTypeCode);
        return $result['deducted_days'];
    }

    /**
     * Dapatkan rincian kalkulasi hari cuti secara lengkap (termasuk weekend & hari libur).
     */
    public function getDetailedCalculation(string|Carbon $startDate, string|Carbon $endDate, string $leaveTypeCode = 'ANNUAL'): array
    {
        return $this->holidayService->calculateDays($startDate, $endDate, $leaveTypeCode);
    }

    /**
     * Dapatkan atau buat data kuota cuti mitra di tahun tertentu.
     */
    public function getOrCreateBalance(User $user, LeaveType $leaveType, ?int $year = null): LeaveBalance
    {
        $year = $year ?? (int) date('Y');

        $balance = LeaveBalance::firstOrCreate(
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

        // Pastikan kuota Cuti Sakit yang belum terpakai tersinkron dengan batas ketentuan 7 hari kerja
        if ($leaveType->code === 'SICK' && $balance->initial_quota > 7 && $balance->used_quota === 0) {
            $balance->initial_quota = 7;
            $balance->remaining_quota = 7;
            $balance->save();
        }

        return $balance;
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
