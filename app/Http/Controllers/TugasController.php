<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\Pengumpulan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TugasController extends Controller
{
    // ─── [GURU] Tampilkan semua tugas milik guru ─────────────────────
    public function index()
    {
        $tugas = Tugas::where('guru_id', Auth::id())
            ->withCount([
                'pengumpulan',
                'pengumpulan as sudah_count' => fn($q) => $q->where('status', '!=', 'belum'),
            ])
            ->latest()
            ->get();

        return view('guru.kelola-tugas', compact('tugas'));
    }

    // ─── [GURU] Form buat tugas ───────────────────────────────────────
    public function create()
    {
        return view('guru.buat-tugas');
    }

    // ─── [GURU] Simpan tugas baru ─────────────────────────────────────
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'           => 'required|string|max:255',
            'deskripsi'       => 'nullable|string',
            'mapel'           => 'required|string|max:100',
            'kelas'           => 'required|string|max:50',
            'tgl_pemberian'   => 'required|date',
            'tgl_pengumpulan' => 'required|date|after_or_equal:tgl_pemberian',
        ], [
            'judul.required'           => 'Judul tugas wajib diisi.',
            'mapel.required'           => 'Mata pelajaran wajib dipilih.',
            'kelas.required'           => 'Kelas wajib dipilih.',
            'tgl_pemberian.required'   => 'Tanggal pemberian wajib diisi.',
            'tgl_pengumpulan.required' => 'Tanggal pengumpulan wajib diisi.',
            'tgl_pengumpulan.after_or_equal' => 'Tanggal pengumpulan harus setelah atau sama dengan tanggal pemberian.',
        ]);

        $tugas = Tugas::create([
            ...$validated,
            'guru_id' => Auth::id(),
        ]);

        // Buat record pengumpulan untuk setiap siswa di kelas yang sama
        $siswaDiKelas = User::where('role', 'siswa')
            ->where('kelas', $validated['kelas'])
            ->get();

        foreach ($siswaDiKelas as $siswa) {
            Pengumpulan::create([
                'tugas_id' => $tugas->id,
                'siswa_id' => $siswa->id,
                'status'   => 'belum',
            ]);
        }

        return redirect()->route('guru.kelola-tugas', $tugas->id)
            ->with('success', 'Tugas berhasil dibuat!');
    }

    // ─── [GURU] Tampilkan detail tugas + daftar pengumpulan ──────────
    public function show(Tugas $tugas)
    {
        $this->authorizeGuru($tugas);

        $daftarPengumpulan = $tugas->pengumpulan()
            ->with('siswa')
            ->get();

        return view('guru.kelola-tugas', compact('tugas', 'daftarPengumpulan'));
    }

    // ─── [GURU] Form edit tugas ───────────────────────────────────────
    public function edit(Tugas $tugas)
    {
        $this->authorizeGuru($tugas);

        return view('guru.edit-tugas', compact('tugas'));
    }

    // ─── [GURU] Simpan perubahan tugas ───────────────────────────────
    public function update(Request $request, Tugas $tugas)
    {
        $this->authorizeGuru($tugas);

        $validated = $request->validate([
            'judul'           => 'required|string|max:255',
            'deskripsi'       => 'nullable|string',
            'mapel'           => 'required|string|max:100',
            'kelas'           => 'required|string|max:50',
            'tgl_pemberian'   => 'required|date',
            'tgl_pengumpulan' => 'required|date|after_or_equal:tgl_pemberian',
        ]);

        $kelasLama = $tugas->kelas;
        $tugas->update($validated);

        // Jika kelas berubah, perbarui daftar pengumpulan
        if ($kelasLama !== $validated['kelas']) {
            // Hapus record siswa dari kelas lama
            $tugas->pengumpulan()->delete();

            // Buat ulang untuk kelas baru
            $siswaDiKelas = User::where('role', 'siswa')
                ->where('kelas', $validated['kelas'])
                ->get();

            foreach ($siswaDiKelas as $siswa) {
                Pengumpulan::create([
                    'tugas_id' => $tugas->id,
                    'siswa_id' => $siswa->id,
                    'status'   => 'belum',
                ]);
            }
        }

        return redirect()->route('guru.kelola-tugas')
            ->with('success', 'Tugas berhasil diperbarui!');
    }

    // ─── [GURU] Hapus tugas ───────────────────────────────────────────
    public function destroy(Tugas $tugas)
    {
        $this->authorizeGuru($tugas);

        $tugas->delete();

        return redirect()->route('guru.kelola-tugas')
            ->with('success', 'Tugas berhasil dihapus.');
    }

    // ─── [GURU] Toggle status pengumpulan siswa ───────────────────────
    public function toggleStatus(Request $request, Pengumpulan $pengumpulan)
    {
        // Pastikan tugas ini milik guru yang login
        $this->authorizeGuru($pengumpulan->tugas);

        $pengumpulan->status = $pengumpulan->status === 'belum' ? 'sudah' : 'belum';
        if ($pengumpulan->status === 'sudah') {
            $pengumpulan->dikumpulkan_at = now();
        } else {
            $pengumpulan->dikumpulkan_at = null;
        }
        $pengumpulan->save();

        return back()->with('success', 'Status berhasil diperbarui.');
    }

    // ─── Helper: pastikan tugas milik guru yang login ─────────────────
    private function authorizeGuru(Tugas $tugas): void
    {
        if ($tugas->guru_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }
    }
}
