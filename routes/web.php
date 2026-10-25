<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\LeaveRequestController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes - WorkLeave Starter Backend
|--------------------------------------------------------------------------
*/

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

// Proses logout dan bersihkan sesi
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Halaman bantuan lupa password
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

// Grup route khusus mitra/karyawan
Route::group([], function () {
    // Halaman dashboard ringkasan kuota mitra
    Route::get('/dashboard', function () {
        return view('user.dashboard.index');
    })->name('dashboard');

    // Halaman formulir pengajuan cuti
    Route::get('/leave/create', function () {
        return view('user.leave.create'); 
    })->name('leave.create');

    // Hitung otomatis hari kerja dan libur nasional via API internal
    Route::post('/leave/calculate-days', [LeaveRequestController::class, 'calculateDays'])->name('leave.calculate');

    // Halaman daftar riwayat pengajuan cuti mitra
    Route::get('/leave/history', function () {
        return view('user.leave.history'); 
    })->name('leave.history');
});

// Grup route khusus halaman administrator
Route::prefix('admin')->group(function () {
    // Redirect otomatis /admin ke halaman dashboard
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    // Halaman dashboard statistik admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Halaman daftar persetujuan (approval) cuti mitra
    Route::get('/approvals', function () {
        return view('admin.approvals.index');
    })->name('admin.approvals');

    // Halaman riwayat cuti per pegawai
    Route::get('/employee/{name?}', function ($name = 'Siti') {
        return view('admin.employee.history', ['name' => ucfirst($name)]);
    })->name('admin.employee.history');
});