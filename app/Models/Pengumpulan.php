<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumpulan extends Model
{
    use HasFactory;

    protected $table = 'pengumpulan';

    protected $fillable = [
        'tugas_id',
        'siswa_id',
        'status',
        'dikumpulkan_at',
        'file_path',
        'file_original_name',
        'catatan',
        'nilai',
        'feedback_guru',
    ];

    protected $casts = [
        'dikumpulkan_at' => 'datetime',
    ];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class, 'tugas_id');
    }

    // Dua alias agar bisa dipanggil $p->siswa ATAU $p->user
    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    // Helper: apakah dikumpulkan terlambat?
    public function getTerlambatAttribute(): bool
    {
        if (! $this->dikumpulkan_at || ! $this->tugas) return false;
        return $this->dikumpulkan_at->gt(\Carbon\Carbon::parse($this->tugas->tgl_pengumpulan)->endOfDay());
    }
}
