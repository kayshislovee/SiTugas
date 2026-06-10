<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleCheck
{
    /**
     * Cek apakah user yang login sesuai role yang diizinkan.
     * Contoh pemakaian di route: ->middleware('role:guru')
     * Superadmin bisa mengakses semua role.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            $loginRoute = match($role) {
                'guru'       => 'login.guru',
                'superadmin' => 'login.superadmin',
                default      => 'login',
            };
            return redirect()->route($loginRoute)
                ->withErrors(['auth' => 'Silakan login terlebih dahulu.']);
        }

        $userRole = Auth::user()->role;

        // Superadmin dapat mengakses semua halaman
        if ($userRole === 'superadmin') {
            return $next($request);
        }

        if ($userRole !== $role) {
            Auth::logout();
            $loginRoute = match($role) {
                'guru'       => 'login.guru',
                'superadmin' => 'login.superadmin',
                default      => 'login',
            };
            return redirect()->route($loginRoute)
                ->withErrors(['auth' => 'Akses ditolak. Silakan login dengan akun yang sesuai.']);
        }

        return $next($request);
    }
}