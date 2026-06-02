<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // MySQL: ubah enum langsung via raw query agar data lama tidak hilang
        DB::statement("ALTER TABLE notifikasi MODIFY COLUMN tipe ENUM(
            'tugas_baru',
            'deadline',
            'diperbarui',
            'nilai',
            'pengumpulan_siswa',
            'pengumpulan_update'
        ) NOT NULL DEFAULT 'tugas_baru'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE notifikasi MODIFY COLUMN tipe ENUM(
            'tugas_baru',
            'deadline',
            'diperbarui',
            'nilai'
        ) NOT NULL DEFAULT 'tugas_baru'");
    }
};
