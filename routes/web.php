<?php

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
});

Route::get('/register', function () {
    return view('auth.register');
});

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
});

// Route untuk Proses Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
})->name('logout');

// User Routes 
Route::group([], function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard.index');
    })->name('dashboard');

    Route::get('/leave/create', function () {
        return view('user.leave.create'); 
    })->name('leave.create');

    Route::get('/leave/history', function () {
        return view('user.leave.history'); 
    })->name('leave.history');
});

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/dashboard', function () {
        return view('admin.dashboard.index');
    })->name('admin.dashboard');

    Route::get('/approvals', function () {
        return view('admin.approvals.index');
    })->name('admin.approvals');

    Route::get('/employee/{name?}', function ($name = 'Siti') {
        return view('admin.employee.history', ['name' => ucfirst($name)]);
    })->name('admin.employee.history');
});