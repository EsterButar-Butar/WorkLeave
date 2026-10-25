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

    // Ambil daftar riwayat pengajuan cuti (mitra hanya melihat miliknya, admin melihat semua)
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        // Siapkan query dasar dengan relasi jenis cuti dan approver
        $query = LeaveRequest::with(['leaveType', 'approver:id,name,email']);

        // Jika bukan admin, batasi data hanya milik user yang sedang login
        if (!$user->isAdmin()) {
            $query->where('user_id', $user->id);
        } else {
            // Jika admin, sertakan juga identitas pemohon cuti
            $query->with('user:id,name,email,nip,department,position');
        }

        // Filter berdasarkan status jika ada parameter pencarian
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // Filter berdasarkan tahun tanggal mulai cuti
        if ($year = $request->input('year')) {
            $query->whereYear('start_date', $year);
        }

        // Ambil data terbaru dengan pembagian halaman (pagination 15 per halaman)
        $requests = $query->latest()->paginate($request->integer('per_page', 15));

        return response()->json([
            'status' => 'success',
            'data' => $requests,
        ]);
    }

    // Ambil data jenis cuti dan saldo kuota aktif untuk kebutuhan form pengajuan
    public function formInfo(Request $request): JsonResponse
    {
        $user = $request->user();
        $currentYear = (int) date('Y');

        // Ambil semua master jenis cuti yang tersedia di sistem
        $leaveTypes = LeaveType::all();

        // Ambil saldo kuota cuti milik user untuk tahun berjalan
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

    // Simpan data pengajuan cuti baru dari mitra
    public function store(StoreLeaveRequest $request): JsonResponse
    {
        try {
            // Validasi input data dari form
            $data = $request->validated();

            // Jika ada upload file bukti lampiran, simpan ke storage public
            if ($request->hasFile('attachment')) {
                $path = $request->file('attachment')->store('leave_attachments', 'public');
                $data['attachment_path'] = $path;
            }

            // Panggil service untuk memproses validasi hari & buat data permohonan
            $leaveRequest = $this->leaveRequestService->createRequest($request->user(), $data);
            $leaveRequest->load('leaveType');

            return response()->json([
                'status' => 'success',
                'message' => 'Pengajuan cuti berhasil diajukan dan sedang menunggu persetujuan.',
                'data' => $leaveRequest,
            ], 201);
        } catch (Exception $e) {
            // Kembalikan pesan error jika kuota tidak cukup atau tanggal tidak valid
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    // Tampilkan detail satu permohonan cuti beserta log riwayat keputusannya
    public function show(Request $request, LeaveRequest $leaveRequest): JsonResponse
    {
        $user = $request->user();

        // Cegah akses jika user bukan pemilik cuti dan bukan admin
        if (!$user->isAdmin() && $leaveRequest->user_id !== $user->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak: Anda tidak memiliki izin melihat data ini.',
            ], 403);
        }

        // Muat relasi lengkap data user, jenis cuti, dan riwayat approval admin
        $leaveRequest->load(['user:id,name,email,nip,department,position', 'leaveType', 'approver:id,name', 'approvals.admin:id,name']);

        return response()->json([
            'status' => 'success',
            'data' => $leaveRequest,
        ]);
    }

    // Batalkan pengajuan cuti yang diajukan oleh mitra
    public function cancel(Request $request, LeaveRequest $leaveRequest): JsonResponse
    {
        try {
            // Panggil service pembatalan (mengembalikan kuota jika sebelumnya sudah approved)
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

    // Hitung otomatis durasi hari kerja efektif, tanggal merah, dan akhir pekan
    public function calculateDays(Request $request, \App\Services\HolidayService $holidayService): JsonResponse
    {
        // Validasi input tanggal mulai dan tanggal selesai
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'leave_type_code' => 'nullable|string',
            'leave_type_id' => 'nullable',
        ]);

        // Tentukan kode jenis cuti (default ANNUAL/Cuti Tahunan)
        $leaveTypeCode = $request->input('leave_type_code', 'ANNUAL');
        if ($leaveTypeId = $request->input('leave_type_id')) {
            $type = LeaveType::find($leaveTypeId);
            if ($type) {
                $leaveTypeCode = $type->code;
            }
        }

        // Panggil service tanggal libur untuk hitung hari kerja aktif
        $result = $holidayService->calculateDays(
            $request->input('start_date'),
            $request->input('end_date'),
            $leaveTypeCode
        );

        return response()->json([
            'status' => 'success',
            'data' => $result,
        ]);
    }
}
