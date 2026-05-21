<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;

    protected $table = 'tugas';

    protected $fillable = [
        'guru_id',
        'judul',
        'deskripsi',
        'mapel',
        'kelas',
        'tgl_pemberian',
        'tgl_pengumpulan',
    ];

    protected $casts = [
        'tgl_pemberian'   => 'date',
        'tgl_pengumpulan' => 'date',
    ];

    // ─── Relasi ───────────────────────────────────────
    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function pengumpulan()
    {
        return $this->hasMany(Pengumpulan::class, 'tugas_id');
    }

    // Siswa yang sudah mengumpulkan
    public function siswaSudah()
    {
        return $this->pengumpulan()->where('status', '!=', 'belum');
    }

    // ─── Helper ───────────────────────────────────────
    public function isExpired(): bool
    {
        return now()->startOfDay()->gt($this->tgl_pengumpulan);
    }

    public function statusLabel(): string
    {
        return $this->isExpired() ? 'terlambat' : 'aktif';
    }
}
