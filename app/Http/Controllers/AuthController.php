<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // ─── Tampilkan form login siswa ───────────────────────────────────
    public function showLoginSiswa()
    {
        return view('autentication.login');
    }

    // ─── Tampilkan form login guru ────────────────────────────────────
    public function showLoginGuru()
    {
        return view('autentication.login-guru');
    }

    // ─── Proses login siswa (pakai NIS) ──────────────────────────────
    public function loginSiswa(Request $request)
    {
        $request->validate([
            'nis'      => 'required|string',
            'password' => 'required|string',
        ], [
            'nis.required'      => 'NIS wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $credentials = [
            'nis'      => $request->nis,
            'password' => $request->password,
            'role'     => 'siswa',
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('siswa.dashboard')
                ->with('success', 'Selamat datang, ' . Auth::user()->name . '!');
        }

        return back()
            ->withInput($request->only('nis'))
            ->withErrors(['nis' => 'NIS atau kata sandi salah.']);
    }

    // ─── Proses login guru (pakai NIP) ───────────────────────────────
    public function loginGuru(Request $request)
    {
        $request->validate([
            'nip'      => 'required|string',
            'password' => 'required|string',
        ], [
            'nip.required'      => 'NIP wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $credentials = [
            'nip'      => $request->nip,
            'password' => $request->password,
            'role'     => 'guru',
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('guru.dashboard')
                ->with('success', 'Selamat datang, ' . Auth::user()->name . '!');
        }

        return back()
            ->withInput($request->only('nip'))
            ->withErrors(['nip' => 'NIP atau kata sandi salah.']);
    }

    // ─── Logout ──────────────────────────────────────────────────────
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Berhasil keluar.');
    }
}
