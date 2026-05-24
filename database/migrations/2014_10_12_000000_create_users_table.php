<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * MASALAH: Tabel users bawaan Laravel hanya punya kolom 'email'.
 * SiTugas butuh kolom 'nis' (untuk siswa), 'nip' (untuk guru), dan 'kelas'.
 * Ini menyebabkan login guru/siswa gagal karena kolom tidak ditemukan.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->nullable();

            // Siswa menggunakan NIS, Guru menggunakan NIP
            $table->string('nis')->unique()->nullable();   // untuk siswa
            $table->string('nip')->unique()->nullable();   // untuk guru

            $table->string('password');
            $table->enum('role', ['siswa', 'guru']);
            $table->string('kelas')->nullable(); // hanya untuk siswa (misal: XI RPL 2)

            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};