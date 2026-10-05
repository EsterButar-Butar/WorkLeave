<?php

use App\Http\Controllers\Admin\LeaveApprovalController;
use App\Http\Controllers\Admin\LeaveBalanceController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeaveRequestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - WorkLeave Backend
|--------------------------------------------------------------------------
*/

// Public Authentication
Route::post('/login', [AuthController::class, 'login'])->name('api.login');

// Protected Routes (Terautentikasi)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');
    Route::get('/me', [AuthController::class, 'me'])->name('api.me');

    // Dashboard Pemantauan Kuota & Status
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('api.dashboard');

    // Pengajuan & Riwayat Cuti (Mitra & Admin)
    Route::prefix('leave-requests')->name('api.leave.')->group(function () {
        Route::get('/', [LeaveRequestController::class, 'index'])->name('index');
        Route::get('/form-info', [LeaveRequestController::class, 'formInfo'])->name('form_info');
        Route::post('/', [LeaveRequestController::class, 'store'])->name('store');
        Route::get('/{leaveRequest}', [LeaveRequestController::class, 'show'])->name('show');
        Route::post('/{leaveRequest}/cancel', [LeaveRequestController::class, 'cancel'])->name('cancel');
    });

    // Endpoint Khusus Administrator / HR
    Route::prefix('admin')->name('api.admin.')->middleware('role:admin')->group(function () {
        // Persetujuan & Penolakan Cuti
        Route::get('/approvals', [LeaveApprovalController::class, 'index'])->name('approvals.index');
        Route::post('/approvals/{leaveRequest}/approve', [LeaveApprovalController::class, 'approve'])->name('approvals.approve');
        Route::post('/approvals/{leaveRequest}/reject', [LeaveApprovalController::class, 'reject'])->name('approvals.reject');

        // Monitoring & Penyesuaian Kuota Mitra
        Route::get('/balances', [LeaveBalanceController::class, 'index'])->name('balances.index');
        Route::put('/balances/{leaveBalance}', [LeaveBalanceController::class, 'update'])->name('balances.update');
        Route::post('/balances/generate', [LeaveBalanceController::class, 'generateYearly'])->name('balances.generate');

        // Rekapitulasi Cuti
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    });
});
