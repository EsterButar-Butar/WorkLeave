<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Autentikasi pengguna (Login).
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if (!$user->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return response()->json([
                    'status' => 'error',
                    'message' => 'Akun Anda dinonaktifkan. Silakan hubungi admin.',
                ], 403);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Login berhasil. Selamat datang, ' . $user->name,
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $user->role->value,
                        'role_label' => $user->role->label(),
                        'nip' => $user->nip,
                        'department' => $user->department,
                        'position' => $user->position,
                    ],
                ],
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Email atau kata sandi yang Anda masukkan salah.',
        ], 401);
    }

    /**
     * Dapatkan data profil pengguna yang sedang login.
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role->value,
                'role_label' => $user->role->label(),
                'nip' => $user->nip,
                'department' => $user->department,
                'position' => $user->position,
                'join_date' => $user->join_date?->toDateString(),
            ],
        ]);
    }

    /**
     * Keluar dari akun (Logout).
     */
    public function logout(Request $request): JsonResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'status' => 'success',
            'message' => 'Anda telah berhasil keluar.',
        ]);
    }
}
