<?php

namespace App\Http\Controllers\Admin;

use App\Enums\LeaveStatus;
use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    /**
     * Tampilkan halaman utama dashboard admin beserta data pegawai & cuti.
     */
    public function index(): View
    {
        // 1. Data Pegawai Aktif (dari database)
        $dbEmployees = User::where('role', 'mitra')
            ->where('is_active', true)
            ->get();

        // 2. Data Cuti Disetujui
        $dbApproved = LeaveRequest::with(['user', 'leaveType'])
            ->where('status', LeaveStatus::APPROVED)
            ->latest()
            ->get();

        // 3. Data Pengajuan Cuti Pending (Menunggu)
        $dbPending = LeaveRequest::with(['user', 'leaveType'])
            ->where('status', LeaveStatus::PENDING)
            ->latest()
            ->get();

        // 4. Data Cuti Ditolak
        $dbRejected = LeaveRequest::with(['user', 'leaveType'])
            ->where('status', LeaveStatus::REJECTED)
            ->latest()
            ->get();

        return view('admin.dashboard.index', compact(
            'dbEmployees',
            'dbApproved',
            'dbPending',
            'dbRejected'
        ));
    }
}
