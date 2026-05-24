<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * PERBAIKAN LOGIN GURU:
 *
 * Bug sebelumnya: tidak ada kolom 'nip' di tabel users (hanya 'email'),
 * dan model User tidak menyertakan 'nis'/'nip'/'kelas' di $fillable.
 * Solusi: tambahkan kolom di migrasi + perbaiki model User.
 */
class AuthController extends Controller
{
    // ─── Tampilkan form login siswa ──────────────────────────────
    public function showLoginSiswa()
    {
        return view('autentication.login');
    }

    // ─── Tampilkan form login guru ───────────────────────────────
    public function showLoginGuru()
    {
        return view('autentication.login-guru');
    }

    // ─── Proses login siswa (pakai NIS) ──────────────────────────
    public function loginSiswa(Request $request)
    {
        $request->validate([
            'nis'      => 'required|string',
            'password' => 'required|string',
        ], [
            'nis.required'      => 'NIS wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        // PENTING: cari berdasarkan kolom 'nis' bukan 'email'
        $user = User::where('nis', $request->nis)
                    ->where('role', 'siswa')
                    ->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return back()
                ->withInput($request->only('nis'))
                ->withErrors(['nis' => 'NIS atau kata sandi salah.']);
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->route('siswa.dashboard')
                         ->with('success', 'Selamat datang, ' . $user->name . '!');
    }

    // ─── Proses login guru (pakai NIP) ───────────────────────────
    public function loginGuru(Request $request)
    {
        $request->validate([
            'nip'      => 'required|string',
            'password' => 'required|string',
        ], [
            'nip.required'      => 'NIP wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        // PENTING: cari berdasarkan kolom 'nip' bukan 'email'
        $user = User::where('nip', $request->nip)
                    ->where('role', 'guru')
                    ->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return back()
                ->withInput($request->only('nip'))
                ->withErrors(['nip' => 'NIP atau kata sandi salah.']);
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->route('guru.dashboard')
                         ->with('success', 'Selamat datang, ' . $user->name . '!');
    }

    // ─── Logout ──────────────────────────────────────────────────
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Berhasil keluar.');
    }
}