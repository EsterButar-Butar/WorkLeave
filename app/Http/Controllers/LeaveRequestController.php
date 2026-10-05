<?php

namespace App\Http\Controllers;

use App\Http\Requests\Leave\StoreLeaveRequest;
use App\Models\LeaveBalance;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Services\LeaveRequestService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    public function __construct(
        protected LeaveRequestService $leaveRequestService
    ) {}

    /**
     * Dapatkan daftar riwayat pengajuan cuti.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $query = LeaveRequest::with(['leaveType', 'approver:id,name,email']);

        if (!$user->isAdmin()) {
            $query->where('user_id', $user->id);
        } else {
            $query->with('user:id,name,email,nip,department,position');
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($year = $request->input('year')) {
            $query->whereYear('start_date', $year);
        }

        $requests = $query->latest()->paginate($request->integer('per_page', 15));

        return response()->json([
            'status' => 'success',
            'data' => $requests,
        ]);
    }

    /**
     * Dapatkan master data jenis cuti dan kuota aktif pemohon untuk form.
     */
    public function formInfo(Request $request): JsonResponse
    {
        $user = $request->user();
        $currentYear = (int) date('Y');

        $leaveTypes = LeaveType::all();
        $balances = LeaveBalance::with('leaveType')
            ->where('user_id', $user->id)
            ->where('year', $currentYear)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'leave_types' => $leaveTypes,
                'user_balances' => $balances,
                'year' => $currentYear,
            ],
        ]);
    }

    /**
     * Simpan pengajuan cuti baru dari mitra kerja.
     */
    public function store(StoreLeaveRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('attachment')) {
                $path = $request->file('attachment')->store('leave_attachments', 'public');
                $data['attachment_path'] = $path;
            }

            $leaveRequest = $this->leaveRequestService->createRequest($request->user(), $data);
            $leaveRequest->load('leaveType');

            return response()->json([
                'status' => 'success',
                'message' => 'Pengajuan cuti berhasil diajukan dan sedang menunggu persetujuan.',
                'data' => $leaveRequest,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Tampilkan detail permohonan cuti beserta log riwayat approval.
     */
    public function show(Request $request, LeaveRequest $leaveRequest): JsonResponse
    {
        $user = $request->user();

        if (!$user->isAdmin() && $leaveRequest->user_id !== $user->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak: Anda tidak memiliki izin melihat data ini.',
            ], 403);
        }

        $leaveRequest->load(['user:id,name,email,nip,department,position', 'leaveType', 'approver:id,name', 'approvals.admin:id,name']);

        return response()->json([
            'status' => 'success',
            'data' => $leaveRequest,
        ]);
    }

    /**
     * Batalkan pengajuan cuti oleh mitra.
     */
    public function cancel(Request $request, LeaveRequest $leaveRequest): JsonResponse
    {
        try {
            $updated = $this->leaveRequestService->cancelRequest($leaveRequest, $request->user());

            return response()->json([
                'status' => 'success',
                'message' => 'Pengajuan cuti berhasil dibatalkan.',
                'data' => $updated,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
