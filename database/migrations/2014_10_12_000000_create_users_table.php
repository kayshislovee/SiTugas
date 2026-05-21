<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nis')->unique()->nullable();   // untuk siswa
            $table->string('nip')->unique()->nullable();   // untuk guru
            $table->enum('role', ['siswa', 'guru']);
            $table->string('kelas')->nullable();           // hanya siswa
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
