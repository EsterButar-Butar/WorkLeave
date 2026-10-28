
<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - WorkLeave
|--------------------------------------------------------------------------
*/

// =====================================================
// ROUTE PUBLIK: PENGGUNA YANG BELUM LOGIN
// =====================================================
Route::middleware('guest')->group(function () {

    // Halaman login
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');

    // Proses login
    Route::post('/login', [
        AuthController::class,
        'login',
    ])->name('login.post');

    // Halaman registrasi mitra
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    // Proses registrasi
    Route::post('/register', [
        AuthController::class,
        'register',
    ])->name('register.post');

    // -----------------------------------------------
    // FITUR LUPA PASSWORD
    // -----------------------------------------------

    // Menampilkan halaman lupa password
    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');

    // Mengirim tautan reset password ke email
    Route::post('/forgot-password', [
        AuthController::class,
        'sendResetLinkEmail',
    ])->name('password.email');

    // Menampilkan formulir untuk membuat password baru
    Route::get('/reset-password/{token}', [
        AuthController::class,
        'showResetForm',
    ])->name('password.reset');

    // Menyimpan password baru
    Route::post('/reset-password', [
        AuthController::class,
        'resetPassword',
    ])->name('password.update');
});


// =====================================================
// VERIFIKASI EMAIL
// =====================================================

// Verifikasi email melalui signed URL
Route::get('/email/verify/{id}/{hash}', [
    AuthController::class,
    'verifyEmail',
])->middleware(['signed'])->name('verification.verify');

// Mengirim ulang email verifikasi
Route::post('/email/resend-verification', [
    AuthController::class,
    'resendVerification',
])->name('verification.resend');


// =====================================================
// LOGOUT
// =====================================================

Route::post('/logout', [
    AuthController::class,
    'logout',
])->middleware('auth')->name('logout');


// =====================================================
// ROUTE MITRA
// =====================================================

Route::middleware(['auth', 'role:mitra'])->group(function () {

    // Dashboard mitra
    Route::get('/dashboard', [
        UserDashboardController::class,
        'index',
    ])->name('dashboard');

    // Form pengajuan cuti
    Route::get('/leave/create', [
        LeaveRequestController::class,
        'create',
    ])->name('leave.create');

    // Proses pengajuan cuti
    Route::post('/leave/store', [
        LeaveRequestController::class,
        'store',
    ])->name('leave.store');

    Route::post('/leave/create', [
        LeaveRequestController::class,
        'store',
    ])->name('leave.create.post');

    // Menghitung hari cuti
    Route::post('/leave/calculate-days', [
        LeaveRequestController::class,
        'calculateDays',
    ])->name('leave.calculate');

    // Riwayat pengajuan cuti
    Route::get('/leave/history', [
        LeaveRequestController::class,
        'history',
    ])->name('leave.history');

    // Mengunduh lampiran pengajuan
    Route::get('/leave/attachment/{leaveRequest}', [
        LeaveRequestController::class,
        'downloadAttachment',
    ])->name('leave.attachment');
});


// =====================================================
// ROUTE ADMIN
// =====================================================

Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        // Redirect /admin ke dashboard
        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        });

        // Dashboard admin
        Route::get('/dashboard', [
            AdminDashboardController::class,
            'index',
        ])->name('admin.dashboard');

        // Notifikasi tertunda
        Route::get('/pending-notifications', [
            AdminDashboardController::class,
            'pendingNotifications',
        ])->name('admin.pending.notifications');

        // Menyetujui pengajuan cuti
        Route::post('/approvals/{leaveRequest}/approve', [
            \App\Http\Controllers\Admin\LeaveApprovalController::class,
            'approve',
        ])->name('admin.approvals.approve');

        // Menolak pengajuan cuti
        Route::post('/approvals/{leaveRequest}/reject', [
            \App\Http\Controllers\Admin\LeaveApprovalController::class,
            'reject',
        ])->name('admin.approvals.reject');

        // Halaman persetujuan cuti
        Route::get('/approvals', function () {
            return view('admin.approvals.index');
        })->name('admin.approvals');

        // Riwayat cuti pegawai
        Route::get('/employee/{name?}', [
            AdminDashboardController::class,
            'employeeHistory',
        ])->name('admin.employee.history');
    });
