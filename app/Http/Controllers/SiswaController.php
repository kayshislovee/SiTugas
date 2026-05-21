<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\Pengumpulan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    // ─── [SISWA] Dashboard ────────────────────────────────────────────
    public function dashboard()
    {
        $siswa = Auth::user();

        // Tugas untuk kelas siswa
        $semuaTugas = Tugas::where('kelas', $siswa->kelas)->get();

        // Status pengumpulan milik siswa ini
        $idSudah = Pengumpulan::where('siswa_id', $siswa->id)
            ->where('status', '!=', 'belum')
            ->pluck('tugas_id')
            ->toArray();

        $sudahCount  = count($idSudah);
        $belumCount  = $semuaTugas->count() - $sudahCount;
        $totalCount  = $semuaTugas->count();

        return view('siswa.dashboard', compact('sudahCount', 'belumCount', 'totalCount'));
    }

    // ─── [SISWA] Daftar tugas ─────────────────────────────────────────
    public function tugasList()
    {
        $siswa = Auth::user();

        $tugas = Tugas::where('kelas', $siswa->kelas)
            ->with(['pengumpulan' => fn($q) => $q->where('siswa_id', $siswa->id)])
            ->latest()
            ->get()
            ->map(function ($t) use ($siswa) {
                $p = $t->pengumpulan->first();
                $t->status_siswa = $p ? $p->status : 'belum';
                return $t;
            });

        return view('siswa.tugas', compact('tugas'));
    }

    // ─── [SISWA] Tandai tugas sudah dikerjakan (self-report) ──────────
    public function tandaiSudah(Tugas $tugas)
    {
        $siswa = Auth::user();

        // Pastikan tugas ini untuk kelas siswa
        if ($tugas->kelas !== $siswa->kelas) {
            abort(403, 'Tugas ini bukan untuk kelas kamu.');
        }

        Pengumpulan::updateOrCreate(
            ['tugas_id' => $tugas->id, 'siswa_id' => $siswa->id],
            ['status' => 'sudah', 'dikumpulkan_at' => now()]
        );

        return back()->with('success', 'Tugas ditandai sudah dikerjakan.');
    }
}
