<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumpulan extends Model
{
    use HasFactory;
    
    // Sesuaikan nama tabel jika perlu
    protected $table = 'pengumpulan'; 

    // Sesuaikan dengan kolom yang ada di database kamu
    protected $fillable = [
        'tugas_id',
        'siswa_id',
        'status',
        'dikumpulkan_at',
        'file_path',
        'file_original_name',
        'catatan',
    ];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class, 'tugas_id');
    }

    public function user() // atau siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }
}