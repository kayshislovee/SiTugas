<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'notifikasi';

    protected $fillable = [
        'user_id',
        'tugas_id',
        'judul',
        'pesan',
        'tipe',
        'dibaca',
        'tersimpan',
    ];

    protected $casts = [
        'dibaca'    => 'boolean',
        'tersimpan' => 'boolean',
    ];

    // ─── Relasi ─────────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tugas()
{
    return $this->belongsTo(Tugas::class)->withTrashed(); 
}

    // ─── Helper scope ───────────────────────────────────────────

    public function scopeBelumDibaca($query)
    {
        return $query->where('dibaca', false);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // ─── Icon & warna berdasarkan tipe ──────────────────────────

    public function getIconColorAttribute(): string
    {
        return match($this->tipe) {
            'tugas_baru'          => 'blue',
            'deadline'            => str_contains($this->judul, '❌') ? 'red' : 'orange',
            'diperbarui'          => 'purple',
            'nilai'               => 'green',
            'pengumpulan_siswa'   => 'green',
            'pengumpulan_update'  => 'orange',
            default               => 'gray',
        };
    }

    public function getTipeIconAttribute(): string
    {
        return match($this->tipe) {
            'tugas_baru'         => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>',
            'deadline'           => '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>',
            'diperbarui'         => '<path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>',
            'nilai'              => '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>',
            'pengumpulan_siswa'  => '<path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>',
            'pengumpulan_update' => '<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>',
            default              => '<path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>',
        };
    }
}
