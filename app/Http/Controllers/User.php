<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'nis',
        'nip',
        'password',
        'role',
        'kelas',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    // ─── Relasi ─────────────────────────────────────────────────

    public function tugasSebagaiGuru()
    {
        return $this->hasMany(Tugas::class, 'guru_id');
    }

    public function pengumpulan()
    {
        return $this->hasMany(Pengumpulan::class, 'siswa_id');
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'user_id');
    }

    // ─── Helper ─────────────────────────────────────────────────

    public function isGuru(): bool
    {
        return $this->role === 'guru';
    }

    public function isSiswa(): bool
    {
        return $this->role === 'siswa';
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }
}