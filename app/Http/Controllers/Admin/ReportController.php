<?php

namespace App\Http\Controllers\Admin;

use App\Enums\LeaveStatus;
use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // Ambil rekapitulasi laporan data cuti mitra kerja berdasarkan filter
    public function index(Request $request): JsonResponse
    {
        $year = (int) ($request->input('year', date('Y')));
        $month = $request->input('month');
        $department = $request->input('department');
        $leaveTypeId = $request->input('leave_type_id');
        $status = $request->input('status', LeaveStatus::APPROVED->value);

        // Siapkan query data cuti tahun berjalan beserta relasi user dan jenis cuti
        $query = LeaveRequest::with([
            'user:id,name,email,nip,department,position',
            'leaveType:id,name,code',
            'approver:id,name,email',
        ])->whereYear('start_date', $year);

        // Filter berdasarkan bulan jika dipilih
        if ($month) {
            $query->whereMonth('start_date', $month);
        }

        // Filter berdasarkan departemen / divisi karyawan
        if ($department) {
            $query->whereHas('user', function ($q) use ($department) {
                $q->where('department', $department);
            });
        }

        // Filter berdasarkan kategori jenis cuti
        if ($leaveTypeId) {
            $query->where('leave_type_id', $leaveTypeId);
        }

        // Filter berdasarkan status pengajuan cuti
        if ($status) {
            $query->where('status', $status);
        }

        // Hitung total akumulasi hari cuti yang diambil dan total frekuensi pengajuan
        $totalDays = (clone $query)->sum('total_days');
        $totalSubmissions = (clone $query)->count();

        // Ambil data laporan terurut terbaru dengan pagination 25 item
        $reports = $query->latest('start_date')->paginate($request->integer('per_page', 25));

        return response()->json([
            'status' => 'success',
            'filters' => [
                'year' => $year,
                'month' => $month,
                'department' => $department,
                'leave_type_id' => $leaveTypeId,
                'status' => $status,
            ],
            'summary' => [
                'total_submissions' => $totalSubmissions,
                'total_days_taken' => (int) $totalDays,
            ],
            'data' => $reports,
        ]);
    }
}
