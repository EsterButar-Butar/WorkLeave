<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - WorkLeave Starter Backend
|--------------------------------------------------------------------------
*/

// Rute Publik (Tamu / Belum Login)
Route::middleware('guest')->group(function () {
    // Halaman utama / form login
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');

    // Proses submit login akun
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // Halaman form register mitra baru
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    // Proses pendaftaran akun mitra baru
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    // Halaman bantuan lupa password
    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');
});

// Verifikasi Email Akun
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
    ->middleware(['signed'])
    ->name('verification.verify');

Route::post('/email/resend-verification', [AuthController::class, 'resendVerification'])
    ->name('verification.resend');

// Proses logout dan bersihkan sesi (hanya user login)
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Grup route khusus mitra/karyawan (Terautentikasi & Role Mitra Saja)
Route::middleware(['auth', 'role:mitra'])->group(function () {
    // Halaman dashboard ringkasan kuota mitra
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    // Halaman formulir pengajuan cuti
    Route::get('/leave/create', [LeaveRequestController::class, 'create'])->name('leave.create');

    // Proses submit permohonan cuti baru
    Route::post('/leave/store', [LeaveRequestController::class, 'store'])->name('leave.store');
    Route::post('/leave/create', [LeaveRequestController::class, 'store'])->name('leave.create.post');

    // Hitung otomatis hari kerja dan libur nasional via API internal
    Route::post('/leave/calculate-days', [LeaveRequestController::class, 'calculateDays'])->name('leave.calculate');

    // Halaman daftar riwayat pengajuan cuti mitra
    Route::get('/leave/history', [LeaveRequestController::class, 'history'])->name('leave.history');

    // Unduh lampiran pengajuan cuti
    Route::get('/leave/attachment/{leaveRequest}', [LeaveRequestController::class, 'downloadAttachment'])->name('leave.attachment');
});

// Grup route khusus halaman administrator (Terautentikasi & Role Admin)
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    // Redirect otomatis /admin ke halaman dashboard
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    // Halaman dashboard statistik admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/pending-notifications', [AdminDashboardController::class, 'pendingNotifications'])->name('admin.pending.notifications');

    // Proses persetujuan dan penolakan cuti mitra
    Route::post('/approvals/{leaveRequest}/approve', [\App\Http\Controllers\Admin\LeaveApprovalController::class, 'approve'])->name('admin.approvals.approve');
    Route::post('/approvals/{leaveRequest}/reject', [\App\Http\Controllers\Admin\LeaveApprovalController::class, 'reject'])->name('admin.approvals.reject');

    // Halaman daftar persetujuan (approval) cuti mitra
    Route::get('/approvals', function () {
        return view('admin.approvals.index');
    })->name('admin.approvals');

    // Halaman riwayat cuti per pegawai
    Route::get('/employee/{name?}', [AdminDashboardController::class, 'employeeHistory'])->name('admin.employee.history');
});