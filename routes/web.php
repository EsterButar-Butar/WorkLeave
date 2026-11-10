<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| RUTE PUBLIK (TAMU / BELUM LOGIN)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    // Halaman utama / form login
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');

    // Proses login akun
    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.post');


    // Halaman registrasi mitra baru
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    // Proses registrasi mitra baru
    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.post');


    /*
    |--------------------------------------------------------------------------
    | FORGOT PASSWORD
    |--------------------------------------------------------------------------
    */

    // Menampilkan halaman Forgot Password
    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');

    // Memproses email dan mengirim tautan reset password
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])
        ->name('password.email');


    /*
    |--------------------------------------------------------------------------
    | RESET PASSWORD
    |--------------------------------------------------------------------------
    */

    // Menampilkan halaman Reset Password berdasarkan token email
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])
        ->name('password.reset');

    // Memvalidasi token dan menyimpan password baru
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])
        ->name('password.update');

});


/*
|--------------------------------------------------------------------------
| VERIFIKASI EMAIL AKUN
|--------------------------------------------------------------------------
*/

// Memverifikasi email melalui signed URL
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
    ->middleware(['signed'])
    ->name('verification.verify');

// Mengirim ulang email verifikasi
Route::post('/email/resend-verification', [AuthController::class, 'resendVerification'])
    ->name('verification.resend');


/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

// Proses logout dan membersihkan sesi pengguna
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| ROUTE MITRA / KARYAWAN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:mitra'])->group(function () {

    // Dashboard mitra
    Route::get('/dashboard', [UserDashboardController::class, 'index'])
        ->name('dashboard');


    // Formulir pengajuan cuti
    Route::get('/leave/create', [LeaveRequestController::class, 'create'])
        ->name('leave.create');

    // Proses pengajuan cuti
    Route::post('/leave/store', [LeaveRequestController::class, 'store'])
        ->name('leave.store');

    Route::post('/leave/create', [LeaveRequestController::class, 'store'])
        ->name('leave.create.post');

    Route::post('/leave', [LeaveRequestController::class, 'store'])
        ->name('leave.post');


    // Menghitung hari kerja dan hari libur
    Route::match(['get', 'post'], '/leave/calculate-days', [LeaveRequestController::class, 'calculateDays'])
        ->name('leave.calculate');


    // Riwayat pengajuan cuti
    Route::get('/leave/history', [LeaveRequestController::class, 'history'])
        ->name('leave.history');

});


/*
|--------------------------------------------------------------------------
| UNDUH LAMPIRAN PENGAJUAN CUTI
|--------------------------------------------------------------------------
*/

// Dapat diakses oleh pengguna yang sudah login
Route::middleware('auth')->get(
    '/leave/attachment/{leaveRequest}',
    [LeaveRequestController::class, 'downloadAttachment']
)->name('leave.attachment');


/*
|--------------------------------------------------------------------------
| ROUTE ADMINISTRATOR
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        // Redirect /admin ke dashboard admin
        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        });


        // Dashboard administrator
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('admin.dashboard');

        // Notifikasi pengajuan cuti
        Route::get('/pending-notifications', [AdminDashboardController::class, 'pendingNotifications'])
            ->name('admin.pending.notifications');


        // Persetujuan pengajuan cuti
        Route::post(
            '/approvals/{leaveRequest}/approve',
            [\App\Http\Controllers\Admin\LeaveApprovalController::class, 'approve']
        )->name('admin.approvals.approve');

        // Penolakan pengajuan cuti
        Route::post(
            '/approvals/{leaveRequest}/reject',
            [\App\Http\Controllers\Admin\LeaveApprovalController::class, 'reject']
        )->name('admin.approvals.reject');


        // Route tambahan persetujuan dan penolakan
        Route::post(
            '/leave/{leaveRequest}/approve',
            [\App\Http\Controllers\Admin\LeaveApprovalController::class, 'approve']
        );

        Route::post(
            '/leave/{leaveRequest}/reject',
            [\App\Http\Controllers\Admin\LeaveApprovalController::class, 'reject']
        );


        // Halaman daftar persetujuan cuti
        Route::get('/approvals', function () {
            return view('admin.approvals.index');
        })->name('admin.approvals');


        // Riwayat cuti per pegawai
        Route::get('/employee/{name?}', [AdminDashboardController::class, 'employeeHistory'])
            ->name('admin.employee.history');

    });
