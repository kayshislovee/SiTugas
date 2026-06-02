<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; // Pastikan Carbon di-import

class Tugas extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'mapel',
        'kelas',
        'tgl_pemberian',
        'tgl_pengumpulan',
        'guru_id',
        'file_path',
        'file_original_name',
    ];

    protected $casts = [
        'tgl_pemberian'    => 'date',
        'tgl_pengumpulan'  => 'date',
    ];

    // ─── Accessors untuk memastikan dates selalu sebagai Carbon ─
    public function getTglPemberianAttribute($value)
    {
        return $value instanceof \Carbon\Carbon ? $value : \Carbon\Carbon::parse($value);
    }

    public function getTglPengumpulanAttribute($value)
    {
        return $value instanceof \Carbon\Carbon ? $value : \Carbon\Carbon::parse($value);
    }

    // ─── Relasi ─────────────────────────────────────────────────

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function pengumpulan()
    {
        return $this->hasMany(Pengumpulan::class, 'tugas_id');
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'tugas_id');
    }

    // ─── Accessor / Helper ──────────────────────────────────────

    /**
     * Menghitung sisa hari sampai deadline.
     * Negatif = sudah lewat deadline.
     */
    public function getSisaHariAttribute(): int
    {
        $tgl = $this->tgl_pengumpulan instanceof \Carbon\Carbon 
            ? $this->tgl_pengumpulan 
            : \Carbon\Carbon::parse($this->tgl_pengumpulan);
        
        return (int) now()->startOfDay()->diffInDays(
            $tgl->startOfDay(),
            false
        );
    }

    /**
     * Label status deadline untuk tampilan.
     */
    public function getStatusDeadlineAttribute(): string
    {
        $sisa = $this->sisa_hari;

        if ($sisa < 0)  return 'Terlambat';
        if ($sisa === 0) return 'Hari ini';
        if ($sisa === 1) return 'Besok';

        return $sisa . ' hari lagi';
    }

    /**
     * Mengecek apakah tugas sudah melewati batas waktu (expired)
     */
    public function isExpired(): bool
    {
        if (!$this->tgl_pengumpulan) {
            return false;
        }

        return $this->sisa_hari < 0;
    }
}