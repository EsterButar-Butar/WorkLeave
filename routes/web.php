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

Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

// User Routes 
Route::group([], function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard.index');
    })->name('dashboard');

    Route::get('/leave/create', function () {
        return view('user.leave.create'); 
    })->name('leave.create');

    Route::post('/leave/calculate-days', [LeaveRequestController::class, 'calculateDays'])->name('leave.calculate');

    Route::get('/leave/history', function () {
        return view('user.leave.history'); 
    })->name('leave.history');
});

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/approvals', function () {
        return view('admin.approvals.index');
    })->name('admin.approvals');

    Route::get('/employee/{name?}', function ($name = 'Siti') {
        return view('admin.employee.history', ['name' => ucfirst($name)]);
    })->name('admin.employee.history');
});