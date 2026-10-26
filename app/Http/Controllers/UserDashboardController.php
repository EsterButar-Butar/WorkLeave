<?php

namespace App\Http\Controllers;

use App\Enums\LeaveStatus;
use App\Models\LeaveBalance;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserDashboardController extends Controller
{
    /**
     * Tampilkan halaman utama dashboard pegawai / mitra.
     */
    public function index(Request $request): View|\Illuminate\Http\RedirectResponse
    {
        $user = $request->user();

        // Admin tidak memiliki kuota cuti pribadi dan tidak mengajukan cuti; alihkan ke dashboard admin
        if ($user && $user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        $currentYear = (int) date('Y');

        // Pastikan kuota tahun berjalan sudah terinisialisasi
        $leaveTypes = LeaveType::all();
        foreach ($leaveTypes as $type) {
            LeaveBalance::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'leave_type_id' => $type->id,
                    'year' => $currentYear,
                ],
                [
                    'initial_quota' => $type->default_quota,
                    'used_quota' => 0,
                    'remaining_quota' => $type->default_quota,
                ]
            );
        }

        // Ambil saldo kuota per jenis cuti
        $balances = LeaveBalance::with('leaveType')
            ->where('user_id', $user->id)
            ->where('year', $currentYear)
            ->get()
            ->keyBy(fn ($b) => $b->leaveType->code ?? $b->leave_type_id);

        // Ambil 5 pengajuan cuti terbaru milik user ini
        $recentRequests = LeaveRequest::with('leaveType')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Hitung total pengajuan yang sedang menunggu persetujuan
        $pendingCount = LeaveRequest::where('user_id', $user->id)
            ->where('status', LeaveStatus::PENDING)
            ->count();

        return view('user.dashboard.index', compact('balances', 'recentRequests', 'pendingCount', 'user'));
    }
}
