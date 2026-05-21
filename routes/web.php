<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// ───────────────────────────────────────────────
// Halaman Utama
// ───────────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
});

// ───────────────────────────────────────────────
// Autentikasi — Guest Only (sudah login redirect)
// ───────────────────────────────────────────────
Route::middleware('guest')->group(function () {

    // Login Siswa
    Route::get('/login', [AuthController::class, 'showLoginSiswa'])->name('login');
    Route::post('/login', [AuthController::class, 'loginSiswa'])->name('login.post');

    // Login Guru
    Route::get('/login-guru', [AuthController::class, 'showLoginGuru'])->name('login.guru');
    Route::post('/login-guru', [AuthController::class, 'loginGuru'])->name('login.guru.post');
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ───────────────────────────────────────────────
// Halaman Guru (harus login & role = guru)
// ───────────────────────────────────────────────
Route::middleware(['role:guru'])->prefix('guru')->name('guru.')->group(function () {

    Route::get('/dashboard', function () {
        return view('guru.dashboard');
    })->name('dashboard');

    Route::get('/kelola-tugas', function () {
        return view('guru.kelola-tugas');
    })->name('kelola-tugas');

    Route::get('/buat-tugas', function () {
        return view('guru.buat-tugas');
    })->name('buat-tugas');

    Route::get('/edit-tugas', function () {
        return view('guru.edit-tugas');
    })->name('edit-tugas');

    Route::get('/notifikasi', function () {
        return view('guru.notifikasi');
    })->name('notifikasi');
});

// ───────────────────────────────────────────────
// Halaman Siswa (harus login & role = siswa)
// ───────────────────────────────────────────────
Route::middleware(['role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {

    Route::get('/dashboard', function () {
        return view('siswa.dashboard');
    })->name('dashboard');

    Route::get('/tugas', function () {
        return view('siswa.tugas');
    })->name('tugas');

    Route::get('/notifikasi', function () {
        return view('siswa.notifikasi-siswa');
    })->name('notifikasi');
});
