<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel pengumpulan mencatat status pengerjaan per siswa per tugas.
 * Dibuat otomatis saat guru membuat tugas baru (lihat TugasController@store).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengumpulan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tugas_id')->constrained('tugas')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['belum', 'proses', 'sudah'])->default('belum');
            $table->timestamp('dikumpulkan_at')->nullable();
            $table->timestamps();

            // Satu siswa hanya bisa punya satu record per tugas
            $table->unique(['tugas_id', 'siswa_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengumpulan');
    }
};