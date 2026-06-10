<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\GuruController;

// ───────────────────────────────────────────────
// Halaman Utama
// ───────────────────────────────────────────────
Route::get('/', function () {
    if (auth()->check()) {
        return match(auth()->user()->role) {
            'guru'       => redirect()->route('guru.dashboard'),
            'superadmin' => redirect()->route('superadmin.dashboard'),
            default      => redirect()->route('siswa.dashboard'),
        };
    }
    return view('welcome');
});

// ───────────────────────────────────────────────
// Autentikasi — Guest Only
// ───────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',       [AuthController::class, 'showLoginSiswa'])->name('login');
    Route::post('/login',      [AuthController::class, 'loginSiswa'])->name('login.post');

    Route::get('/login-guru',  [AuthController::class, 'showLoginGuru'])->name('login.guru');
    Route::post('/login-guru', [AuthController::class, 'loginGuru'])->name('login.guru.post');

    Route::get('/login-admin',  [AuthController::class, 'showLoginSuperAdmin'])->name('login.superadmin');
    Route::post('/login-admin', [AuthController::class, 'loginSuperAdmin'])->name('login.superadmin.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ───────────────────────────────────────────────
// SUPER ADMIN
// ───────────────────────────────────────────────
Route::middleware(['auth', 'role:superadmin'])->prefix('admin')->name('superadmin.')->group(function () {

    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/guru',              [SuperAdminController::class, 'indexGuru'])->name('kelola-guru');
    Route::get('/guru/tambah',       [SuperAdminController::class, 'createGuru'])->name('tambah-guru');
    Route::post('/guru',             [SuperAdminController::class, 'storeGuru'])->name('store-guru');
    Route::get('/guru/{user}/edit',  [SuperAdminController::class, 'editGuru'])->name('edit-guru');
    Route::put('/guru/{user}',       [SuperAdminController::class, 'updateGuru'])->name('update-guru');
    Route::delete('/guru/{user}',    [SuperAdminController::class, 'destroyGuru'])->name('destroy-guru');

    Route::get('/siswa',             [SuperAdminController::class, 'indexSiswa'])->name('kelola-siswa');
    Route::get('/siswa/tambah',      [SuperAdminController::class, 'createSiswa'])->name('tambah-siswa');
    Route::post('/siswa',            [SuperAdminController::class, 'storeSiswa'])->name('store-siswa');
    Route::get('/siswa/{user}/edit', [SuperAdminController::class, 'editSiswa'])->name('edit-siswa');
    Route::put('/siswa/{user}',      [SuperAdminController::class, 'updateSiswa'])->name('update-siswa');
    Route::delete('/siswa/{user}',   [SuperAdminController::class, 'destroySiswa'])->name('destroy-siswa');

    Route::get('/tugas',             [SuperAdminController::class, 'indexTugas'])->name('kelola-tugas');
    Route::get('/tugas/{tugas}',     [SuperAdminController::class, 'showTugas'])->name('detail-tugas');
});

// ───────────────────────────────────────────────
// GURU
// ───────────────────────────────────────────────
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {

    Route::get('/dashboard', [TugasController::class, 'dashboardGuru'])->name('dashboard');

    // Tugas
    Route::get('/kelola-tugas',               [TugasController::class, 'indexGuru'])->name('kelola-tugas');
    Route::get('/kelola-tugas/{tugas}',       [TugasController::class, 'show'])->name('show-tugas');
    Route::get('/kelola-tugas/{tugas}/edit',  [TugasController::class, 'edit'])->name('edit-tugas');
    Route::post('/kelola-tugas',              [TugasController::class, 'store'])->name('store-tugas');
    Route::put('/kelola-tugas/{tugas}',       [TugasController::class, 'update'])->name('update-tugas');
    Route::delete('/kelola-tugas/{tugas}',    [TugasController::class, 'destroy'])->name('destroy-tugas');
    Route::post('/toggle-status/{pengumpulan}',   [TugasController::class, 'toggleStatus'])->name('toggle-status');
    Route::post('/beri-nilai/{pengumpulan}',       [TugasController::class, 'beriNilai'])->name('beri-nilai');
    Route::get('/preview-jawaban/{pengumpulan}',   [TugasController::class, 'previewJawaban'])->name('preview-jawaban');
    Route::get('/buat-tugas', [TugasController::class, 'create'])->name('buat-tugas');

    // Kelola Siswa
    Route::get('/siswa',             [GuruController::class, 'indexSiswa'])->name('kelola-siswa');
    Route::get('/siswa/tambah',      [GuruController::class, 'createSiswa'])->name('tambah-siswa');
    Route::post('/siswa',            [GuruController::class, 'storeSiswa'])->name('store-siswa');
    Route::get('/siswa/{user}/edit', [GuruController::class, 'editSiswa'])->name('edit-siswa');
    Route::put('/siswa/{user}',      [GuruController::class, 'updateSiswa'])->name('update-siswa');
    Route::delete('/siswa/{user}',   [GuruController::class, 'destroySiswa'])->name('destroy-siswa');

    // Notifikasi Guru
    Route::get('/notifikasi',                          [NotifikasiController::class, 'indexGuru'])->name('notifikasi');
    Route::post('/notifikasi/{id}/read',               [NotifikasiController::class, 'markAsRead'])->name('notifikasi.read');
    Route::post('/notifikasi/read-all',                [NotifikasiController::class, 'markAllAsRead'])->name('notifikasi.readAll');
    Route::delete('/notifikasi/{id}',                  [NotifikasiController::class, 'destroy'])->name('notifikasi.destroy');
});

// ───────────────────────────────────────────────
// SISWA
// ───────────────────────────────────────────────
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {

    Route::get('/dashboard', [TugasController::class, 'dashboardSiswa'])->name('dashboard');
    Route::get('/tugas',     [TugasController::class, 'tugasSiswa'])->name('tugas');

    // Upload & Submission
    Route::get('/tugas/{tugas}',                    [TugasController::class, 'detailTugasSiswa'])->name('detail-tugas');
    Route::post('/tugas/{tugas}/submit',            [TugasController::class, 'submitTugas'])->name('submit-tugas');
    Route::get('/tugas/{tugas}/edit-pengumpulan',   [TugasController::class, 'editPengumpulanSiswa'])->name('edit-pengumpulan');
    Route::put('/tugas/{tugas}/update-pengumpulan', [TugasController::class, 'updatePengumpulanSiswa'])->name('update-pengumpulan');

    // Notifikasi Siswa
    Route::get('/notifikasi',                [NotifikasiController::class, 'index'])->name('notifikasi');
    Route::post('/notifikasi/{id}/read',     [NotifikasiController::class, 'markAsRead'])->name('notifikasi.read');
    Route::post('/notifikasi/read-all',      [NotifikasiController::class, 'markAllAsRead'])->name('notifikasi.readAll');
    Route::delete('/notifikasi/{id}',        [NotifikasiController::class, 'destroy'])->name('notifikasi.destroy');
});
