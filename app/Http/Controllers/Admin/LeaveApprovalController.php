<?php

namespace App\Http\Controllers\Admin;

use App\Enums\LeaveStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Leave\ApprovalActionRequest;
use App\Models\LeaveRequest;
use App\Services\LeaveRequestService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LeaveApprovalController extends Controller
{
    public function __construct(
        protected LeaveRequestService $leaveRequestService
    ) {}

    /**
     * Dapatkan daftar antrean pengajuan cuti yang berstatus pending.
     */
    public function index(Request $request): JsonResponse
    {
        $query = LeaveRequest::with([
            'user:id,name,email,nip,department,position',
            'leaveType:id,name,code,default_quota',
        ])->where('status', LeaveStatus::PENDING);

        if ($search = $request->input('search')) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        $pendingRequests = $query->latest()->paginate($request->integer('per_page', 15));

        return response()->json([
            'status' => 'success',
            'data' => $pendingRequests,
        ]);
    }

    /**
     * Setujui pengajuan cuti oleh admin.
     */
    public function approve(Request $request, LeaveRequest $leaveRequest): JsonResponse
    {
        try {
            $note = $request->input('note');
            $updated = $this->leaveRequestService->approveRequest($leaveRequest, $request->user(), $note);

            return response()->json([
                'status' => 'success',
                'message' => 'Pengajuan cuti mitra kerja berhasil disetujui.',
                'data' => $updated,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Tolak pengajuan cuti oleh admin.
     */
    public function reject(Request $request, LeaveRequest $leaveRequest): JsonResponse
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ], [
            'rejection_reason.required' => 'Wajib menyertakan alasan penolakan cuti.',
        ]);

        try {
            $reason = $request->input('rejection_reason');
            $updated = $this->leaveRequestService->rejectRequest($leaveRequest, $request->user(), $reason);

            return response()->json([
                'status' => 'success',
                'message' => 'Pengajuan cuti telah ditolak.',
                'data' => $updated,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}
