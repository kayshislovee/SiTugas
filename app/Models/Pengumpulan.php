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
    ];

    protected $casts = [
        'dikumpulkan_at' => 'datetime',
    ];

    // ─── Relasi ───────────────────────────────────────
    public function tugas()
    {
        return $this->belongsTo(Tugas::class, 'tugas_id');
    }

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }
}
