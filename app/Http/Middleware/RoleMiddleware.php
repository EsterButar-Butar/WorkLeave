<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $userRoleValue = is_string($user->role) ? $user->role : $user->role->value;

        if (!in_array($userRoleValue, $roles, true)) {
            // Jika admin mencoba mengakses halaman mitra, alihkan langsung ke Dashboard Admin
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            // Jika mitra mencoba mengakses halaman admin, kembalikan ke dashboard mitra
            return redirect()->route('dashboard')->with('error', 'Akses ditolak: Anda tidak memiliki izin untuk halaman tersebut.');
        }

        return $next($request);
    }
}
