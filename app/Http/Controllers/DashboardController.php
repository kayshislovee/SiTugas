<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\Pengumpulan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // ─── [GURU] Dashboard ─────────────────────────────────────────────
    public function guru()
    {
        $guru = Auth::user();

        $totalTugas = Tugas::where('guru_id', $guru->id)->count();

        $tugasTerbaru = Tugas::where('guru_id', $guru->id)
            ->withCount([
                'pengumpulan as pengumpulan_count',
                'pengumpulan as sudah_count' => fn($q) => $q->where('status', '!=', 'belum'),
            ])
            ->latest()
            ->take(5)
            ->get();

        // Total siswa unik di semua kelas yang pernah diberi tugas
        $kelasDiajar = Tugas::where('guru_id', $guru->id)
            ->distinct()
            ->pluck('kelas');

        $totalSiswa = User::where('role', 'siswa')
            ->whereIn('kelas', $kelasDiajar)
            ->count();

        return view('guru.dashboard', compact('totalTugas', 'tugasTerbaru', 'totalSiswa'));
    }

    // ─── [SISWA] Dashboard ────────────────────────────────────────────
    public function siswa()
    {
        $siswa = Auth::user();

        $semuaTugas = Tugas::where('kelas', $siswa->kelas)->count();

        $sudahCount = \DB::table('pengumpulan')
            ->where('siswa_id', $siswa->id)
            ->where('status', '!=', 'belum')
            ->count();

        $belumCount = $semuaTugas - $sudahCount;

        $tugasTerbaru = Tugas::where('kelas', $siswa->kelas)
            ->with(['pengumpulan' => fn($q) => $q->where('siswa_id', $siswa->id)])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($t) use ($siswa) {
                $p = $t->pengumpulan->first();
                $t->status_siswa = $p ? $p->status : 'belum';
                return $t;
            });

        return view('siswa.dashboard', compact('semuaTugas', 'sudahCount', 'belumCount', 'tugasTerbaru'));
    }
}
