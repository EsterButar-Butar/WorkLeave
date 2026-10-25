<?php

namespace App\Services;

use App\Models\LeaveBalance;
use App\Models\LeaveType;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class LeaveBalanceService
{
    public function __construct(
        protected ?HolidayService $holidayService = null
    ) {
        $this->holidayService = $holidayService ?? new HolidayService();
    }

    // Hitung total hari kerja (weekend dan libur nasional dilewati khusus cuti tahunan)
    public function calculateWorkingDays(string|Carbon $startDate, string|Carbon $endDate, string $leaveTypeCode = 'ANNUAL'): int
    {
        $result = $this->holidayService->calculateDays($startDate, $endDate, $leaveTypeCode);
        return $result['deducted_days'];
    }

    // Ambil rincian detail hari kalender, akhir pekan, dan tanggal merah
    public function getDetailedCalculation(string|Carbon $startDate, string|Carbon $endDate, string $leaveTypeCode = 'ANNUAL'): array
    {
        return $this->holidayService->calculateDays($startDate, $endDate, $leaveTypeCode);
    }

    // Ambil saldo kuota cuti mitra tahun ini atau buat data baru jika belum ada
    public function getOrCreateBalance(User $user, LeaveType $leaveType, ?int $year = null): LeaveBalance
    {
        // Tentukan tahun periode (default tahun berjalan)
        $year = $year ?? (int) date('Y');

        // Cari atau buat baris saldo kuota awal mitra
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

        // Batasi batas kuota cuti sakit maksimal 7 hari kerja per tahun
        if ($leaveType->code === 'SICK' && $balance->initial_quota > 7 && $balance->used_quota === 0) {
            $balance->initial_quota = 7;
            $balance->remaining_quota = 7;
            $balance->save();
        }

        return $balance;
    }

    // Periksa apakah sisa kuota cuti masih cukup untuk durasi hari yang diminta
    public function hasEnoughBalance(User $user, LeaveType $leaveType, int $days, ?int $year = null): bool
    {
        // Jika jenis cuti tanpa batas kuota bawaan, anggap kuota selalu cukup
        if ($leaveType->default_quota <= 0) {
            return true;
        }

        // Ambil data saldo cuti aktif pemohon
        $balance = $this->getOrCreateBalance($user, $leaveType, $year);

        // Validasi sisa kuota harus lebih besar atau sama dengan hari yang diminta
        return $balance->remaining_quota >= $days;
    }

    // Kurangi sisa kuota cuti mitra saat pengajuan disetujui admin
    public function deductBalance(User $user, LeaveType $leaveType, int $days, ?int $year = null): bool
    {
        if ($leaveType->default_quota <= 0) {
            return true;
        }

        $balance = $this->getOrCreateBalance($user, $leaveType, $year);

        // Tambah kuota terpakai dan kurangi sisa kuota aktif
        $balance->used_quota += $days;
        $balance->remaining_quota = max(0, $balance->initial_quota - $balance->used_quota);
        return $balance->save();
    }

    // Kembalikan saldo kuota cuti saat permohonan dibatalkan
    public function restoreBalance(User $user, LeaveType $leaveType, int $days, ?int $year = null): bool
    {
        if ($leaveType->default_quota <= 0) {
            return true;
        }

        $balance = $this->getOrCreateBalance($user, $leaveType, $year);

        // Kurangi jumlah terpakai dan kembalikan sisa saldo
        $balance->used_quota = max(0, $balance->used_quota - $days);
        $balance->remaining_quota = min($balance->initial_quota, $balance->initial_quota - $balance->used_quota);
        return $balance->save();
    }

    // Buat saldo kuota cuti tahunan baru secara serentak untuk semua mitra aktif
    public function initializeYearlyBalancesForMitra(int $year): int
    {
        // Ambil semua akun mitra yang sedang berstatus aktif
        $mitras = User::where('role', 'mitra')->where('is_active', true)->get();
        $leaveTypes = LeaveType::all();
        $count = 0;

        // Loop setiap mitra dan pasang kuota default per jenis cuti
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
