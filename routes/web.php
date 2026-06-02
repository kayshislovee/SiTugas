<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\Siswa\PengumpulanController; // Sesuaikan path controller-nya


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
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {

    Route::get('/dashboard', [TugasController::class, 'dashboardGuru'])->name('dashboard');

    // CRUD Tugas Guru (Mengarah ke TugasController agar logika simpan database & kirim notif berjalan)
    Route::get('/kelola-tugas', [TugasController::class, 'indexGuru'])->name('kelola-tugas');
    Route::get('/kelola-tugas/{tugas}', [TugasController::class, 'show'])->name('show-tugas');
    Route::get('/kelola-tugas/{tugas}/edit', [TugasController::class, 'edit'])->name('edit-tugas');
    Route::post('/kelola-tugas', [TugasController::class, 'store'])->name('store-tugas');
    Route::put('/kelola-tugas/{tugas}', [TugasController::class, 'update'])->name('update-tugas');
    Route::delete('/kelola-tugas/{tugas}', [TugasController::class, 'destroy'])->name('destroy-tugas');
    Route::post('/toggle-status/{pengumpulan}', [TugasController::class, 'toggleStatus'])->name('toggle-status');

    // Form buat tugas (melalui controller)
    Route::get('/buat-tugas', [TugasController::class, 'create'])->name('buat-tugas');

    Route::get('/notifikasi', function () {
        return view('guru.notifikasi');
    })->name('notifikasi');
});

// ───────────────────────────────────────────────
// Halaman Siswa (harus login & role = siswa)
// ───────────────────────────────────────────────
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {

    Route::get('/dashboard', [TugasController::class, 'dashboardSiswa'])->name('dashboard');

    Route::get('/tugas', [TugasController::class, 'tugasSiswa'])->name('tugas');

    // Student Task Upload & Submission Routes
    Route::get('/tugas/{tugas}', [TugasController::class, 'detailTugasSiswa'])->name('detail-tugas');
    Route::post('/tugas/{tugas}/submit', [TugasController::class, 'submitTugas'])->name('submit-tugas');
    Route::get('/tugas/{tugas}/edit-pengumpulan', [TugasController::class, 'editPengumpulanSiswa'])->name('edit-pengumpulan');
    Route::put('/tugas/{tugas}/update-pengumpulan', [TugasController::class, 'updatePengumpulanSiswa'])->name('update-pengumpulan');

    // Notifikasi Routes
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi');
    Route::post('/notifikasi/{id}/read', [NotifikasiController::class, 'markAsRead'])->name('notifikasi.read');
    Route::post('/notifikasi/read-all', [NotifikasiController::class, 'markAllAsRead'])->name('notifikasi.readAll');
});



    