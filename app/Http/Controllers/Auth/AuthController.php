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
    // Registrasi akun mitra baru dan otomatis inisialisasi saldo kuota cuti awal
    public function register(RegisterRequest $request): JsonResponse|RedirectResponse
    {
        // Simpan data akun pengguna baru ke tabel users dengan role mitra
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => UserRole::MITRA,
            'is_active' => true,
            'join_date' => now()->toDateString(),
        ]);

        // Buat saldo kuota cuti default tahun berjalan untuk akun baru
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

        // Kembalikan respons JSON jika request berasal dari API client
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

        // Redirect ke halaman login dengan pesan sukses untuk request web biasa
        return redirect()->route('login')->with('success', 'Pendaftaran akun berhasil! Silakan masuk menggunakan akun baru Anda.');
    }

    // Proses autentikasi login pengguna dan redirect sesuai role
    public function login(LoginRequest $request): JsonResponse|RedirectResponse
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        // Cek kecocokan email dan kata sandi pengguna
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Tolak login jika akun pengguna dinonaktifkan oleh administrator
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

            // Alihkan admin ke halaman admin dashboard
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            // Alihkan mitra ke halaman user dashboard
            return redirect('/dashboard');
        }

        // Kembalikan error jika kredensial salah
        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email atau kata sandi yang Anda masukkan salah.',
            ], 401);
        }

        return back()->withErrors(['email' => 'Email atau kata sandi yang Anda masukkan salah.'])->withInput();
    }

    // Ambil data profil user yang sedang login saat ini
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

    // Proses keluar akun, bersihkan sesi login, dan redirect ke halaman login
    public function logout(Request $request): JsonResponse|RedirectResponse
    {
        // Logout user dari sistem autentikasi
        Auth::logout();

        // Bersihkan dan perbarui token sesi keamanan
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Anda telah berhasil keluar.',
            ]);
        }

        // Arahkan kembali ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar.');
    }
}
