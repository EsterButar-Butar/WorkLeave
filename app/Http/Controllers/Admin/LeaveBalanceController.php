<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveBalance;
use App\Models\LeaveType;
use App\Services\LeaveBalanceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LeaveBalanceController extends Controller
{
    public function __construct(
        protected LeaveBalanceService $balanceService
    ) {}

    // Ambil daftar kuota dan sisa saldo cuti seluruh mitra kerja
    public function index(Request $request): JsonResponse
    {
        $year = (int) ($request->input('year', date('Y')));
        $search = $request->input('search');

        // Query data kuota per tahun dengan relasi data mitra dan jenis cuti
        $query = LeaveBalance::with([
            'user:id,name,email,nip,department,position',
            'leaveType:id,name,code',
        ])->where('year', $year);

        // Filter pencarian berdasarkan nama, NIP, atau departemen
        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%");
            });
        }

        // Ambil data kuota dengan pagination 20 item per halaman
        $balances = $query->paginate($request->integer('per_page', 20));

        return response()->json([
            'status' => 'success',
            'year' => $year,
            'data' => $balances,
        ]);
    }

    // Perbarui kuota awal mitra dan hitung ulang sisa kuota aktifnya
    public function update(Request $request, LeaveBalance $leaveBalance): JsonResponse
    {
        // Validasi input angka kuota awal baru
        $validated = $request->validate([
            'initial_quota' => ['required', 'integer', 'min:0', 'max:100'],
        ]);

        // Hitung ulang sisa kuota (kuota awal baru dikurangi yang sudah terpakai)
        $initial = $validated['initial_quota'];
        $remaining = max(0, $initial - $leaveBalance->used_quota);

        // Simpan pembaruan kuota ke database
        $leaveBalance->update([
            'initial_quota' => $initial,
            'remaining_quota' => $remaining,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Kuota cuti mitra berhasil diperbarui.',
            'data' => $leaveBalance->fresh(['user', 'leaveType']),
        ]);
    }

    // Inisialisasi kuota tahunan baru secara serentak untuk semua mitra aktif
    public function generateYearly(Request $request): JsonResponse
    {
        $year = (int) ($request->input('year', date('Y')));
        // Panggil service untuk generate baris kuota baru
        $count = $this->balanceService->initializeYearlyBalancesForMitra($year);

        return response()->json([
            'status' => 'success',
            'message' => "Berhasil menginisialisasi {$count} entri kuota cuti mitra untuk tahun {$year}.",
            'year' => $year,
            'created_entries' => $count,
        ]);
    }
}
