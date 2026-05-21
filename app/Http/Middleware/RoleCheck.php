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
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Belum login → arahkan ke halaman login sesuai role
        if (!Auth::check()) {
            $loginRoute = $role === 'guru' ? 'login.guru' : 'login';
            return redirect()->route($loginRoute)
                ->withErrors(['auth' => 'Silakan login terlebih dahulu.']);
        }

        // Sudah login tapi role tidak sesuai
        if (Auth::user()->role !== $role) {
            Auth::logout();
            $loginRoute = $role === 'guru' ? 'login.guru' : 'login';
            return redirect()->route($loginRoute)
                ->withErrors(['auth' => 'Akses ditolak. Silakan login dengan akun yang sesuai.']);
        }

        return $next($request);
    }
}
