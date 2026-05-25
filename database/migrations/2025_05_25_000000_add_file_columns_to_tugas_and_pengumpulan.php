<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tambah kolom file ke tabel tugas untuk guru upload file tugas
        Schema::table('tugas', function (Blueprint $table) {
            $table->string('file_path')->nullable()->after('deskripsi')->comment('Path file tugas yang diupload guru');
            $table->string('file_original_name')->nullable()->after('file_path')->comment('Nama asli file tugas');
        });

        // Tambah kolom file ke tabel pengumpulan untuk siswa upload jawaban
        Schema::table('pengumpulan', function (Blueprint $table) {
            $table->string('file_path')->nullable()->after('dikumpulkan_at')->comment('Path file jawaban siswa');
            $table->string('file_original_name')->nullable()->after('file_path')->comment('Nama asli file jawaban');
            $table->text('catatan')->nullable()->after('file_original_name')->comment('Catatan/keterangan dari siswa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tugas', function (Blueprint $table) {
            $table->dropColumn(['file_path', 'file_original_name']);
        });

        Schema::table('pengumpulan', function (Blueprint $table) {
            $table->dropColumn(['file_path', 'file_original_name', 'catatan']);
        });
    }
};
