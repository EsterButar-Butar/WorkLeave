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

    /**
     * Mengajukan permohonan cuti baru oleh mitra.
     */
    public function createRequest(User $user, array $data): LeaveRequest
    {
        $leaveType = LeaveType::findOrFail($data['leave_type_id']);
        $startDate = Carbon::parse($data['start_date']);
        $endDate = Carbon::parse($data['end_date']);

        if ($endDate->lt($startDate)) {
            throw new InvalidArgumentException('Tanggal selesai tidak boleh lebih awal dari tanggal mulai.');
        }

        // Hitung total hari kerja (tanpa weekend)
        $totalDays = $this->balanceService->calculateWorkingDays($startDate, $endDate);
        if ($totalDays <= 0) {
            throw new InvalidArgumentException('Pengajuan harus mencakup minimal 1 hari kerja aktif.');
        }

        // Validasi ketersediaan kuota cuti
        $requestYear = (int) $startDate->format('Y');
        if (!$this->balanceService->hasEnoughBalance($user, $leaveType, $totalDays, $requestYear)) {
            throw new InvalidArgumentException('Sisa kuota cuti Anda tidak mencukupi untuk jumlah hari pengajuan ini.');
        }

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

    /**
     * Persetujuan pengajuan cuti oleh Admin.
     */
    public function approveRequest(LeaveRequest $request, User $admin, ?string $note = null): LeaveRequest
    {
        if ($request->status !== LeaveStatus::PENDING) {
            throw new InvalidArgumentException('Hanya pengajuan dengan status pending yang dapat disetujui.');
        }

        return DB::transaction(function () use ($request, $admin, $note) {
            $year = (int) Carbon::parse($request->start_date)->format('Y');

            // Potong kuota cuti
            $this->balanceService->deductBalance(
                $request->user,
                $request->leaveType,
                $request->total_days,
                $year
            );

            // Update status pengajuan
            $request->update([
                'status' => LeaveStatus::APPROVED,
                'approved_by' => $admin->id,
                'action_at' => now(),
            ]);

            // Catat log persetujuan
            LeaveApproval::create([
                'leave_request_id' => $request->id,
                'action_by' => $admin->id,
                'action' => 'approved',
                'notes' => $note,
            ]);

            return $request->fresh(['leaveType', 'approver', 'approvals']);
        });
    }

    /**
     * Penolakan pengajuan cuti oleh Admin.
     */
    public function rejectRequest(LeaveRequest $request, User $admin, string $reason): LeaveRequest
    {
        if ($request->status !== LeaveStatus::PENDING) {
            throw new InvalidArgumentException('Hanya pengajuan dengan status pending yang dapat ditolak.');
        }

        return DB::transaction(function () use ($request, $admin, $reason) {
            $request->update([
                'status' => LeaveStatus::REJECTED,
                'approved_by' => $admin->id,
                'action_at' => now(),
                'rejection_reason' => $reason,
            ]);

            LeaveApproval::create([
                'leave_request_id' => $request->id,
                'action_by' => $admin->id,
                'action' => 'rejected',
                'notes' => $reason,
            ]);

            return $request->fresh(['leaveType', 'approver', 'approvals']);
        });
    }

    /**
     * Pembatalan cuti oleh Mitra.
     */
    public function cancelRequest(LeaveRequest $request, User $user): LeaveRequest
    {
        if ($request->user_id !== $user->id && !$user->isAdmin()) {
            throw new InvalidArgumentException('Anda tidak memiliki izin membatalkan pengajuan ini.');
        }

        return DB::transaction(function () use ($request) {
            // Jika sebelumnya sudah disetujui, kembalikan kuota cutinya
            if ($request->status === LeaveStatus::APPROVED) {
                $year = (int) Carbon::parse($request->start_date)->format('Y');
                $this->balanceService->restoreBalance(
                    $request->user,
                    $request->leaveType,
                    $request->total_days,
                    $year
                );
            }

            $request->update([
                'status' => LeaveStatus::CANCELLED,
            ]);

            return $request->fresh();
        });
    }
}
