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
    return view('user.leave.create'); // Halaman form ajukan cuti
});
