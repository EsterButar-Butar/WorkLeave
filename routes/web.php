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

Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'service' => 'WorkLeave Backend',
        'database' => config('database.default'),
        'timestamp' => now()->toIso8601String(),
    ]);
});
