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
        return $this->belongsTo(Tugas::class);
    }
}
