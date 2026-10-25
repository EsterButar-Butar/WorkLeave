<?php

namespace App\Services;

use App\Enums\LeaveStatus;
use App\Models\LeaveApproval;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class LeaveRequestService
{
    public function __construct(
        protected LeaveBalanceService $balanceService
    ) {}

    // Buat data permohonan cuti baru setelah validasi tanggal dan saldo kuota
    public function createRequest(User $user, array $data): LeaveRequest
    {
        // Cari jenis cuti yang dipilih berdasarkan ID
        $leaveType = LeaveType::findOrFail($data['leave_type_id']);
        $startDate = Carbon::parse($data['start_date']);
        $endDate = Carbon::parse($data['end_date']);

        // Pastikan tanggal selesai tidak mendahului tanggal mulai
        if ($endDate->lt($startDate)) {
            throw new InvalidArgumentException('Tanggal selesai tidak boleh lebih awal dari tanggal mulai.');
        }

        // Hitung total hari kerja yang memotong kuota (melewati weekend & libur nasional)
        $totalDays = $this->balanceService->calculateWorkingDays($startDate, $endDate, $leaveType->code);
        if ($totalDays <= 0) {
            throw new InvalidArgumentException('Pengajuan harus mencakup minimal 1 hari kerja aktif.');
        }

        // Periksa apakah sisa kuota cuti pemohon masih mencukupi
        $requestYear = (int) $startDate->format('Y');
        if (!$this->balanceService->hasEnoughBalance($user, $leaveType, $totalDays, $requestYear)) {
            throw new InvalidArgumentException('Sisa kuota cuti Anda tidak mencukupi untuk jumlah hari pengajuan ini.');
        }

        // Simpan data pengajuan cuti baru dengan status pending
        return LeaveRequest::create([
            'user_id' => $user->id,
            'leave_type_id' => $leaveType->id,
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
            'total_days' => $totalDays,
            'reason' => $data['reason'],
            'attachment_path' => $data['attachment_path'] ?? null,
            'emergency_contact' => $data['emergency_contact'] ?? null,
            'status' => LeaveStatus::PENDING,
        ]);
    }

    // Proses persetujuan (approve) cuti oleh admin dan potong saldo kuota mitra
    public function approveRequest(LeaveRequest $request, User $admin, ?string $note = null): LeaveRequest
    {
        // Pastikan hanya cuti yang berstatus pending yang dapat disetujui
        if ($request->status !== LeaveStatus::PENDING) {
            throw new InvalidArgumentException('Hanya pengajuan dengan status pending yang dapat disetujui.');
        }

        // Jalankan transaksi database agar pemotongan kuota dan update status berjalan aman
        return DB::transaction(function () use ($request, $admin, $note) {
            $year = (int) Carbon::parse($request->start_date)->format('Y');

            // Kurangi saldo kuota cuti mitra sesuai jumlah hari cuti
            $this->balanceService->deductBalance(
                $request->user,
                $request->leaveType,
                $request->total_days,
                $year
            );

            // Ubah status pengajuan menjadi approved dan catat admin yang menyetujui
            $request->update([
                'status' => LeaveStatus::APPROVED,
                'approved_by' => $admin->id,
                'action_at' => now(),
            ]);

            // Buat catatan audit trail di tabel riwayat approval
            LeaveApproval::create([
                'leave_request_id' => $request->id,
                'action_by' => $admin->id,
                'action' => 'approved',
                'notes' => $note,
            ]);

            return $request->fresh(['leaveType', 'approver', 'approvals']);
        });
    }

    // Proses penolakan (reject) cuti oleh admin beserta pencatatan alasannya
    public function rejectRequest(LeaveRequest $request, User $admin, string $reason): LeaveRequest
    {
        // Pastikan hanya pengajuan pending yang bisa ditolak
        if ($request->status !== LeaveStatus::PENDING) {
            throw new InvalidArgumentException('Hanya pengajuan dengan status pending yang dapat ditolak.');
        }

        // Jalankan transaksi database untuk simpan status ditolak dan riwayat log
        return DB::transaction(function () use ($request, $admin, $reason) {
            // Ubah status menjadi rejected dan simpan alasan penolakan
            $request->update([
                'status' => LeaveStatus::REJECTED,
                'approved_by' => $admin->id,
                'action_at' => now(),
                'rejection_reason' => $reason,
            ]);

            // Catat log aksi penolakan ke tabel riwayat persetujuan
            LeaveApproval::create([
                'leave_request_id' => $request->id,
                'action_by' => $admin->id,
                'action' => 'rejected',
                'notes' => $reason,
            ]);

            return $request->fresh(['leaveType', 'approver', 'approvals']);
        });
    }

    // Batalkan permohonan cuti oleh pemilik atau admin
    public function cancelRequest(LeaveRequest $request, User $user): LeaveRequest
    {
        // Pastikan yang membatalkan adalah pemilik pengajuan atau admin
        if ($request->user_id !== $user->id && !$user->isAdmin()) {
            throw new InvalidArgumentException('Anda tidak memiliki izin membatalkan pengajuan ini.');
        }

        return DB::transaction(function () use ($request) {
            // Jika cuti yang dibatalkan sebelumnya sudah approved, kembalikan kuota cutinya
            if ($request->status === LeaveStatus::APPROVED) {
                $year = (int) Carbon::parse($request->start_date)->format('Y');
                $this->balanceService->restoreBalance(
                    $request->user,
                    $request->leaveType,
                    $request->total_days,
                    $year
                );
            }

            // Tandai status pengajuan menjadi cancelled
            $request->update([
                'status' => LeaveStatus::CANCELLED,
            ]);

            return $request->fresh();
        });
    }
}
