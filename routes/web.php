<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function () {
    return view('user.dashboard.index');
});

Route::get('/leave/create', function () {
    return view('user.leave.create'); 
});

Route::get('/leave/history', function () {
    return view('user.leave.history'); 
});

// Admin Routes
Route::prefix('admin')->group(function () {
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