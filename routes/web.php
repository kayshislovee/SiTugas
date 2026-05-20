<?php

use Illuminate\Support\Facades\Route;

// ===== Halaman Utama =====
Route::get('/', function () {
    return view('welcome');
});

// ===== Autentikasi =====
Route::get('/login', function () {
    return view('autentication.login');
})->name('login');

Route::get('/login-guru', function () {
    return view('autentication.login-guru');
})->name('login.guru');

// ===== Halaman Guru =====
Route::get('/guru/dashboard', function () {
    return view('guru.dashboard');
})->name('guru.dashboard');

Route::get('/guru/kelola-tugas', function () {
    return view('guru.kelola-tugas');
})->name('guru.kelola-tugas');

Route::get('/guru/buat-tugas', function () {
    return view('guru.buat-tugas');
})->name('guru.buat-tugas');

Route::get('/guru/edit-tugas', function () {
    return view('guru.edit-tugas');
})->name('guru.edit-tugas');

Route::get('/guru/notifikasi', function () {
    return view('guru.notifikasi');
})->name('guru.notifikasi');

// ===== Halaman Siswa =====
Route::get('/siswa/dashboard', function () {
    return view('siswa.dashboard');
})->name('siswa.dashboard');

Route::get('/siswa/tugas', function () {
    return view('siswa.tugas');
})->name('siswa.tugas');

Route::get('/siswa/notifikasi', function () {
    return view('siswa.notifikasi-siswa');
})->name('siswa.notifikasi');
