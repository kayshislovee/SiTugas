<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'nis',
        'nip',
        'role',
        'kelas',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    // Helper: cek apakah user adalah guru
    public function isGuru(): bool
    {
        return $this->role === 'guru';
    }

    // Helper: cek apakah user adalah siswa
    public function isSiswa(): bool
    {
        return $this->role === 'siswa';
    }
}
