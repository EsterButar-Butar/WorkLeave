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
    /**
     * Dapatkan data rekapitulasi pengajuan cuti mitra kerja.
     */
    public function index(Request $request): JsonResponse
    {
        $year = (int) ($request->input('year', date('Y')));
        $month = $request->input('month');
        $department = $request->input('department');
        $leaveTypeId = $request->input('leave_type_id');
        $status = $request->input('status', LeaveStatus::APPROVED->value);

        $query = LeaveRequest::with([
            'user:id,name,email,nip,department,position',
            'leaveType:id,name,code',
            'approver:id,name,email',
        ])->whereYear('start_date', $year);

        if ($month) {
            $query->whereMonth('start_date', $month);
        }

        if ($department) {
            $query->whereHas('user', function ($q) use ($department) {
                $q->where('department', $department);
            });
        }

        if ($leaveTypeId) {
            $query->where('leave_type_id', $leaveTypeId);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $totalDays = (clone $query)->sum('total_days');
        $totalSubmissions = (clone $query)->count();

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
