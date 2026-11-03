<?php

namespace App\Http\Controllers\Admin;

use App\Enums\LeaveStatus;
use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    // Tampilkan halaman utama dashboard admin beserta data pegawai & cuti
    public function index(): View
    {
        // 0. Otomatis bersihkan akun mitra dummy bawaan (Siti, Ayu, Putri, Yanto, dll) agar database murni default
        try {
            $dummyEmails = [
                'siti@workleave.test',
                'ayu@workleave.test',
                'putri@workleave.test',
                'yanto@workleave.test',
                'yanti@workleave.test',
                'putra@workleave.test',
                'dani@workleave.test',
                'budi@workleave.test',
                'dimas@workleave.test',
            ];
            $dummyUsers = User::whereIn('email', $dummyEmails)->get();
            if ($dummyUsers->isNotEmpty()) {
                $dummyIds = $dummyUsers->pluck('id');
                $dummyRequestIds = \App\Models\LeaveRequest::whereIn('user_id', $dummyIds)->pluck('id');

                if ($dummyRequestIds->isNotEmpty()) {
                    \App\Models\LeaveApproval::whereIn('leave_request_id', $dummyRequestIds)->delete();
                    \App\Models\LeaveRequest::whereIn('id', $dummyRequestIds)->delete();
                }

                \App\Models\LeaveBalance::whereIn('user_id', $dummyIds)->delete();
                User::whereIn('id', $dummyIds)->delete();
            }
        } catch (\Throwable $e) {
            // Abaikan kesalahan jika pembersihan sudah selesai sebelumnya
        }

        // 1. Data Pegawai Aktif (dari database - role mitra)
        $dbEmployees = User::where('role', 'mitra')
            ->where('is_active', true)
            ->orderBy('name', 'asc')
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

        // 5. Data Pegawai yang Cuti Saat Ini (berdasarkan tanggal hari ini dan status disetujui)
        $todayDate = now()->toDateString();
        $dbTodayLeaves = LeaveRequest::with(['user', 'leaveType'])
            ->where('status', LeaveStatus::APPROVED)
            ->whereDate('start_date', '<=', $todayDate)
            ->whereDate('end_date', '>=', $todayDate)
            ->orderBy('start_date', 'asc')
            ->get();

        return view('admin.dashboard.index', compact(
            'dbEmployees',
            'dbApproved',
            'dbPending',
            'dbRejected',
            'dbTodayLeaves'
        ));
    }

    // Endpoint API polling untuk notifikasi real-time pengajuan cuti baru mitra
    public function pendingNotifications(): \Illuminate\Http\JsonResponse
    {
        $pending = LeaveRequest::with(['user', 'leaveType'])
            ->where('status', LeaveStatus::PENDING)
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'count' => $pending->count(),
            'data' => $pending,
        ]);
    }

    // Tampilkan riwayat pengajuan cuti pegawai / mitra untuk modal detail admin
    public function employeeHistory(?string $identifier = null): View
    {
        \Carbon\Carbon::setLocale('id');

        // 1. Cari pegawai berdasarkan ID atau Nama di database (case-insensitive aman untuk PostgreSQL)
        $employee = null;
        if ($identifier) {
            if (is_numeric($identifier)) {
                $employee = User::find($identifier);
            }
            if (!$employee) {
                $employee = User::whereRaw('LOWER(name) LIKE ?', ['%' . strtolower(trim($identifier)) . '%'])
                    ->orWhereRaw('LOWER(email) LIKE ?', ['%' . strtolower(trim($identifier)) . '%'])
                    ->first();
            }
        }

        // Jika tidak dispesifikasikan, ambil mitra pertama yang terdaftar
        if (!$employee) {
            $employee = User::where('role', 'mitra')->orderBy('name', 'asc')->first();
        }

        $employeeName = $employee ? $employee->name : ($identifier ? ucfirst($identifier) : 'Pegawai');

        // 2. Ambil permohonan cuti asli pegawai tersebut jika ada di database
        $records = [];
        if ($employee) {
            $dbReqs = LeaveRequest::with('leaveType')
                ->where('user_id', $employee->id)
                ->latest()
                ->get();

            foreach ($dbReqs as $r) {
                $startCarbon = \Carbon\Carbon::parse($r->start_date)->locale('id');
                $endCarbon = \Carbon\Carbon::parse($r->end_date)->locale('id');
                $appliedCarbon = ($r->created_at ? \Carbon\Carbon::parse($r->created_at) : $startCarbon)->locale('id');

                $startDayName = $startCarbon->translatedFormat('l');
                $endDayName = $endCarbon->translatedFormat('l');
                $appliedDay = $appliedCarbon->translatedFormat('l, d/m/Y');

                $daysLabel = ($r->start_date === $r->end_date)
                    ? $startDayName
                    : "{$startDayName} – {$endDayName}";

                $periodStr = ($r->start_date === $r->end_date)
                    ? $startCarbon->format('d/m/Y')
                    : $startCarbon->format('d/m/Y') . ' – ' . $endCarbon->format('d/m/Y');

                $statusVal = $r->status->value ?? $r->status;
                $statusBadge = match($statusVal) {
                    'approved' => ['label' => 'Disetujui', 'bg' => 'bg-[#E6F8F0]', 'text' => 'text-[#10B981]'],
                    'rejected' => ['label' => 'Ditolak', 'bg' => 'bg-[#FDECEC]', 'text' => 'text-[#DC2626]'],
                    default => ['label' => 'Menunggu', 'bg' => 'bg-[#FEF9E7]', 'text' => 'text-[#D97706]'],
                };

                $records[] = [
                    'id' => $r->id,
                    'type' => $r->leaveType->name ?? 'Cuti Tahunan',
                    'accent' => ($r->leaveType && str_contains(strtolower($r->leaveType->name), 'sakit')) ? 'bg-rose-500' : 'bg-blue-500',
                    'start' => $startCarbon->format('d/m/Y'),
                    'end' => $endCarbon->format('d/m/Y'),
                    'days_name' => $daysLabel,
                    'period' => $periodStr,
                    'duration' => ($r->total_days ?? 1) . ' hari',
                    'applied' => $appliedDay,
                    'status' => $statusBadge['label'],
                    'status_bg' => $statusBadge['bg'],
                    'status_text' => $statusBadge['text'],
                    'note' => $r->reason ?? '-',
                    'file' => $r->attachment_path ? basename($r->attachment_path) : null,
                    'file_url' => $r->attachment_path ? route('leave.attachment', $r->id) : null,
                    'is_real' => true,
                ];
            }
        }

        // 3. Hitung ringkasan kuota cuti pegawai murni dari database
        $currentYear = (int) date('Y');
        $annualBalance = $employee
            ? \App\Models\LeaveBalance::where('user_id', $employee->id)
                ->where('year', $currentYear)
                ->whereHas('leaveType', fn($q) => $q->where('code', 'ANNUAL'))
                ->first()
            : null;

        $hakCuti = $annualBalance->initial_quota ?? 12;
        $cutiTerpakai = $annualBalance->used_quota ?? ($employee 
            ? LeaveRequest::where('user_id', $employee->id)
                ->where('status', LeaveStatus::APPROVED)
                ->whereYear('start_date', $currentYear)
                ->whereHas('leaveType', fn($q) => $q->where('code', 'ANNUAL'))
                ->sum('total_days')
            : 0);
        $sisaCuti = $annualBalance->remaining_quota ?? max(0, $hakCuti - $cutiTerpakai);
        $cutiSakit = $employee 
            ? LeaveRequest::where('user_id', $employee->id)
                ->where('status', LeaveStatus::APPROVED)
                ->whereYear('start_date', $currentYear)
                ->whereHas('leaveType', fn($q) => $q->where('code', 'SICK'))
                ->sum('total_days')
            : 0;

        $hasMaternity = $employee
            ? LeaveRequest::where('user_id', $employee->id)
                ->whereHas('leaveType', fn($q) => $q->where('code', 'MATERNITY'))
                ->exists()
            : false;

        $maternityBalance = $employee
            ? \App\Models\LeaveBalance::where('user_id', $employee->id)
                ->where('year', $currentYear)
                ->whereHas('leaveType', fn($q) => $q->where('code', 'MATERNITY'))
                ->first()
            : null;

        $jatahBersalin = $hasMaternity ? ($maternityBalance->initial_quota ?? 90) : '-';

        return view('admin.employee.history', [
            'name' => $employeeName,
            'employee' => $employee,
            'records' => $records,
            'quota' => [
                'hak' => $hakCuti,
                'terpakai' => $cutiTerpakai,
                'sisa' => $sisaCuti,
                'sakit' => $cutiSakit,
                'bersalin' => $jatahBersalin,
            ]
        ]);
    }
}
