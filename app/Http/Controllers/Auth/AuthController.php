<?php


namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\LeaveBalance;
use App\Models\LeaveType;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
/**
* Registrasi akun mitra dan inisialisasi saldo cuti.
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
'email_verified_at' => null,
]);

$year = (int) date('Y');

foreach (LeaveType::all() as $type) {
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

$user->sendEmailVerificationNotification();

if ($request->wantsJson()) {
return response()->json([
'status' => 'success',
'message' => 'Pendaftaran berhasil. Silakan verifikasi email sebelum login.',
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

return redirect()
->route('login')
->with(
'success',
'Pendaftaran berhasil. Tautan verifikasi telah dikirim ke email Anda.'
)
->with('unverified_email', $user->email);
}

/**
* Login pengguna.
*/
public function login(LoginRequest $request): JsonResponse|RedirectResponse
{
$credentials = $request->only('email', 'password');
$remember = $request->boolean('remember');

if (!Auth::attempt($credentials, $remember)) {
if ($request->wantsJson()) {
return response()->json([
'status' => 'error',
'message' => 'Email atau password salah.',
], 401);
}

return back()
->withErrors([
'email' => 'Email atau password salah.',
])
->withInput($request->only('email'));
}

$user = Auth::user();

if (!$user->hasVerifiedEmail()) {
$email = $user->email;

Auth::logout();
$request->session()->invalidate();
$request->session()->regenerateToken();

if ($request->wantsJson()) {
return response()->json([
'status' => 'error',
'message' => 'Email belum diverifikasi.',
'needs_verification' => true,
'email' => $email,
], 403);
}

return back()
->withErrors([
'email' => 'Email belum diverifikasi. Periksa kotak masuk atau folder spam.',
])
->withInput($request->only('email'))
->with('unverified_email', $email);
}

if (!$user->is_active) {
Auth::logout();
$request->session()->invalidate();
$request->session()->regenerateToken();

if ($request->wantsJson()) {
return response()->json([
'status' => 'error',
'message' => 'Akun dinonaktifkan. Silakan hubungi admin.',
], 403);
}

return back()
->withErrors([
'email' => 'Akun dinonaktifkan. Silakan hubungi admin.',
])
->withInput($request->only('email'));
}

$request->session()->regenerate();

if ($request->wantsJson()) {
return response()->json([
'status' => 'success',
'message' => 'Login berhasil.',
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

return redirect()->route('dashboard');
}

/**
* Mengirim tautan reset password ke email pengguna.
*/
public function sendResetLinkEmail(Request $request): JsonResponse|RedirectResponse
{
$request->validate([
'email' => ['required', 'email'],
], [
'email.required' => 'Alamat email wajib diisi.',
'email.email' => 'Format email tidak valid.',
]);

$status = Password::sendResetLink(
$request->only('email')
);

if ($request->wantsJson()) {
$success = $status === Password::RESET_LINK_SENT;

return response()->json([
'status' => $success ? 'success' : 'error',
'message' => __($status),
], $success ? 200 : 422);
}

if ($status === Password::RESET_LINK_SENT) {
return back()->with('status', __($status));
}

return back()
->withErrors(['email' => __($status)])
->withInput($request->only('email'));
}

/**
* Menampilkan formulir reset password.
*/
public function showResetForm(Request $request, string $token): View
{
return view('auth.reset-password', [
'token' => $token,
'email' => $request->query('email', ''),
]);
}

/**
* Memvalidasi token dan menyimpan password baru.
*/
public function resetPassword(Request $request): JsonResponse|RedirectResponse
{
$request->validate([
'token' => ['required', 'string'],
'email' => ['required', 'email'],
'password' => [
'required',
'string',
'min:8',
'confirmed',
],
], [
'token.required' => 'Token reset password tidak ditemukan.',
'email.required' => 'Alamat email wajib diisi.',
'email.email' => 'Format email tidak valid.',
'password.required' => 'Password baru wajib diisi.',
'password.min' => 'Password minimal 8 karakter.',
'password.confirmed' => 'Konfirmasi password tidak cocok.',
]);

$status = Password::reset(
$request->only(
'email',
'password',
'password_confirmation',
'token'
),
function ($user, $password) {
$user->forceFill([
'password' => Hash::make($password),
'remember_token' => Str::random(60),
])->save();
}
);

if ($request->wantsJson()) {
$success = $status === Password::PASSWORD_RESET;

return response()->json([
'status' => $success ? 'success' : 'error',
'message' => __($status),
], $success ? 200 : 422);
}

if ($status === Password::PASSWORD_RESET) {
return redirect()
->route('login')
->with(
'success',
'Password berhasil diubah. Silakan login dengan password baru.'
);
}

return back()
->withErrors(['email' => __($status)])
->withInput($request->only('email'));
}

/**
* Memverifikasi email pengguna.
*/
public function verifyEmail(
Request $request,
$id,
$hash
): RedirectResponse|JsonResponse {
$user = User::findOrFail($id);

if (!hash_equals(
(string) $hash,
sha1($user->getEmailForVerification())
)) {
if ($request->wantsJson()) {
return response()->json([
'status' => 'error',
'message' => 'Tautan verifikasi tidak valid.',
], 403);
}

return redirect()
->route('login')
->withErrors([
'email' => 'Tautan verifikasi tidak valid.',
]);
}

if ($user->hasVerifiedEmail()) {
if ($request->wantsJson()) {
return response()->json([
'status' => 'info',
'message' => 'Email sudah diverifikasi. Silakan login.',
]);
}

return redirect()
->route('login')
->with('info', 'Email sudah diverifikasi. Silakan login.');
}

$user->markEmailAsVerified();

if ($request->wantsJson()) {
return response()->json([
'status' => 'success',
'message' => 'Email berhasil diverifikasi. Silakan login.',
]);
}

return redirect()
->route('login')
->with('success', 'Email berhasil diverifikasi. Silakan login.');
}

/**
* Mengirim ulang email verifikasi.
*/
public function resendVerification(Request $request): JsonResponse|RedirectResponse
{
$request->validate([
'email' => ['required', 'email', 'exists:users,email'],
], [
'email.required' => 'Alamat email wajib diisi.',
'email.email' => 'Format email tidak valid.',
'email.exists' => 'Alamat email tidak ditemukan.',
]);

$user = User::where('email', $request->email)->firstOrFail();

if ($user->hasVerifiedEmail()) {
if ($request->wantsJson()) {
return response()->json([
'status' => 'info',
'message' => 'Email sudah diverifikasi.',
]);
}

return redirect()
->route('login')
->with('info', 'Email sudah diverifikasi. Silakan login.');
}

$user->sendEmailVerificationNotification();

if ($request->wantsJson()) {
return response()->json([
'status' => 'success',
'message' => 'Tautan verifikasi baru telah dikirim.',
]);
}

return redirect()
->route('login')
->with(
'success',
'Tautan verifikasi baru telah dikirim. Periksa kotak masuk atau folder spam.'
)
->with('unverified_email', $user->email);
}

/**
* Mengambil profil pengguna yang sedang login.
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
* Logout dan membersihkan sesi.
*/
public function logout(Request $request): JsonResponse|RedirectResponse
{
Auth::logout();

$request->session()->invalidate();
$request->session()->regenerateToken();

if ($request->wantsJson()) {
return response()->json([
'status' => 'success',
'message' => 'Anda berhasil logout.',
]);
}

return redirect()
->route('login')
->with('success', 'Anda berhasil logout.');
}
}