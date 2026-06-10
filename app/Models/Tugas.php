<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Pengumpulan;
use App\Models\Notifikasi;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tugas extends Model
{
     use HasFactory, SoftDeletes;

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
        'tgl_pemberian'   => 'date',
        'tgl_pengumpulan' => 'date',
    ];

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

    public function getTglPemberianAttribute($value)
    {
        return $value instanceof Carbon ? $value : Carbon::parse($value);
    }

    public function getTglPengumpulanAttribute($value)
    {
        return $value instanceof Carbon ? $value : Carbon::parse($value);
    }

    public function getSisaHariAttribute(): int
    {
        if (!$this->tgl_pengumpulan) {
            return 0;
        }

        $tgl = $this->tgl_pengumpulan instanceof Carbon
            ? $this->tgl_pengumpulan
            : Carbon::parse($this->tgl_pengumpulan);

        return (int) now()->startOfDay()->diffInDays($tgl->startOfDay(), false);
    }

    public function getStatusDeadlineAttribute(): string
    {
        $sisa = $this->sisa_hari;

        if ($sisa < 0) {
            return 'Terlambat';
        }

        if ($sisa === 0) {
            return 'Hari ini';
        }

        if ($sisa === 1) {
            return 'Besok';
        }

        return $sisa . ' hari lagi';
    }

    public function isExpired(): bool
    {
        if (!$this->tgl_pengumpulan) {
            return false;
        }

        return $this->sisa_hari < 0;
    }
}
