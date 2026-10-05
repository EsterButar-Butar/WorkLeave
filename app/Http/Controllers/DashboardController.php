<?php

namespace App\Http\Controllers;

use App\Enums\LeaveStatus;
use App\Models\LeaveBalance;
use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Tampilkan data metrik dashboard pemantauan kuota dan cuti.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $currentYear = (int) ($request->input('year', date('Y')));

        if ($user->isAdmin()) {
            $stats = [
                'total_mitra' => User::where('role', 'mitra')->where('is_active', true)->count(),
                'pending_requests' => LeaveRequest::where('status', LeaveStatus::PENDING)->count(),
                'approved_this_month' => LeaveRequest::where('status', LeaveStatus::APPROVED)
                    ->whereMonth('start_date', now()->month)
                    ->whereYear('start_date', now()->year)
                    ->count(),
                'total_days_taken_this_month' => (int) LeaveRequest::where('status', LeaveStatus::APPROVED)
                    ->whereMonth('start_date', now()->month)
                    ->whereYear('start_date', now()->year)
                    ->sum('total_days'),
            ];

            $recentRequests = LeaveRequest::with(['user:id,name,email,nip,department', 'leaveType:id,name,code'])
                ->latest()
                ->take(5)
                ->get();

            $pendingList = LeaveRequest::with(['user:id,name,email,nip,department', 'leaveType:id,name,code'])
                ->where('status', LeaveStatus::PENDING)
                ->latest()
                ->take(5)
                ->get();

            return response()->json([
                'status' => 'success',
                'role' => 'admin',
                'year' => $currentYear,
                'data' => [
                    'statistics' => $stats,
                    'pending_approvals' => $pendingList,
                    'recent_requests' => $recentRequests,
                ],
            ]);
        }

        // Dashboard Mitra
        $balances = LeaveBalance::with('leaveType:id,name,code,default_quota,is_paid,requires_attachment')
            ->where('user_id', $user->id)
            ->where('year', $currentYear)
            ->get();

        $stats = [
            'initial_quota' => (int) $balances->sum('initial_quota'),
            'used_quota' => (int) $balances->sum('used_quota'),
            'remaining_quota' => (int) $balances->sum('remaining_quota'),
            'pending_count' => LeaveRequest::where('user_id', $user->id)
                ->where('status', LeaveStatus::PENDING)
                ->count(),
            'approved_count' => LeaveRequest::where('user_id', $user->id)
                ->where('status', LeaveStatus::APPROVED)
                ->count(),
        ];

        $myRecentRequests = LeaveRequest::with('leaveType:id,name,code')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return response()->json([
            'status' => 'success',
            'role' => 'mitra',
            'year' => $currentYear,
            'data' => [
                'statistics' => $stats,
                'balances' => $balances,
                'recent_requests' => $myRecentRequests,
            ],
        ]);
    }
}
