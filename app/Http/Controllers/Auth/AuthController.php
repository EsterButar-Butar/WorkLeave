<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\LeaveBalance;
use App\Models\LeaveType;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Pendaftaran pengguna baru (Register).
     */
    public function register(RegisterRequest $request): JsonResponse|RedirectResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => UserRole::MITRA,
            'is_active' => true,
            'join_date' => now()->toDateString(),
        ]);

        // Berikan kuota cuti default tahun berjalan jika data jenis cuti sudah tersedia
        $year = (int) date('Y');
        $leaveTypes = LeaveType::all();
        foreach ($leaveTypes as $type) {
            LeaveBalance::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'leave_type_id' => $type->id,
                    'year' => $year,
                ],
                [
                    'initial_quota' => $type->default_quota,
                    'used_quota' => 0,
                    'remaining_quota' => $type->default_quota,
                ]
            );
        }

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Pendaftaran akun berhasil. Silakan masuk.',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $user->role->value,
                        'role_label' => $user->role->label(),
                    ],
                ],
            ], 201);
        }

        return redirect()->route('login')->with('success', 'Pendaftaran akun berhasil! Silakan masuk menggunakan akun baru Anda.');
    }

    /**
     * Autentikasi pengguna (Login).
     */
    public function login(LoginRequest $request): JsonResponse|RedirectResponse
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

                if ($request->wantsJson()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Akun Anda dinonaktifkan. Silakan hubungi admin.',
                    ], 403);
                }

                return back()->withErrors(['email' => 'Akun Anda dinonaktifkan. Silakan hubungi admin.'])->withInput();
            }

            if ($request->wantsJson()) {
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

            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            return redirect('/dashboard');
        }

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email atau kata sandi yang Anda masukkan salah.',
            ], 401);
        }

        return back()->withErrors(['email' => 'Email atau kata sandi yang Anda masukkan salah.'])->withInput();
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
    public function logout(Request $request): JsonResponse|RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Anda telah berhasil keluar.',
            ]);
        }

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar.');
    }
}
