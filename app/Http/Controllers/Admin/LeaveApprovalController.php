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

    // Ambil daftar permohonan cuti mitra yang masih menunggu persetujuan (status pending)
    public function index(Request $request): JsonResponse
    {
        // Query pengajuan berstatus pending dengan data user pemohon dan jenis cutinya
        $query = LeaveRequest::with([
            'user:id,name,email,nip,department,position',
            'leaveType:id,name,code,default_quota',
        ])->where('status', LeaveStatus::PENDING);

        // Filter pencarian berdasarkan nama pemohon atau NIP jika diisi
        if ($search = $request->input('search')) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        // Ambil data pengajuan pending dengan pagination 15 item per halaman
        $pendingRequests = $query->latest()->paginate($request->integer('per_page', 15));

        return response()->json([
            'status' => 'success',
            'data' => $pendingRequests,
        ]);
    }

    // Setujui permohonan cuti mitra oleh admin
    public function approve(Request $request, LeaveRequest $leaveRequest): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        try {
            $note = $request->input('note');
            // Panggil service untuk setujui cuti dan potong saldo kuota mitra
            $updated = $this->leaveRequestService->approveRequest($leaveRequest, $request->user(), $note);

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Pengajuan cuti mitra kerja berhasil disetujui.',
                    'data' => $updated,
                ]);
            }

            return back()->with('success', 'Pengajuan cuti mitra kerja berhasil disetujui.');
        } catch (Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ], 422);
            }

            return back()->withErrors(['approval_error' => $e->getMessage()]);
        }
    }

    // Tolak permohonan cuti mitra oleh admin beserta catatan alasannya
    public function reject(Request $request, LeaveRequest $leaveRequest): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        // Validasi wajib menyertakan alasan penolakan
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ], [
            'rejection_reason.required' => 'Wajib menyertakan alasan penolakan cuti.',
        ]);

        try {
            $reason = $request->input('rejection_reason');
            // Panggil service untuk tandai rejected dan simpan riwayat log
            $updated = $this->leaveRequestService->rejectRequest($leaveRequest, $request->user(), $reason);

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Pengajuan cuti telah ditolak.',
                    'data' => $updated,
                ]);
            }

            return back()->with('success', 'Pengajuan cuti telah ditolak.');
        } catch (Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ], 422);
            }

            return back()->withErrors(['approval_error' => $e->getMessage()]);
        }
    }
}
