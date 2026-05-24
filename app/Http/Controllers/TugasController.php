<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\Pengumpulan;
use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * PERBAIKAN CRUD TUGAS:
 *
 * Bug sebelumnya:
 * 1. Kolom 'deadline' di kode lama tidak cocok dengan nama kolom migrasi ('tgl_pengumpulan').
 * 2. Setelah store/update, notifikasi tidak dibuat untuk siswa.
 * 3. Method show() mengembalikan view 'kelola-tugas' tapi variable tidak cocok.
 *
 * Perbaikan:
 * 1. Gunakan nama kolom konsisten: 'tgl_pemberian' dan 'tgl_pengumpulan'.
 * 2. Buat notifikasi untuk setiap siswa di kelas setelah tugas dibuat/diupdate.
 * 3. Pisahkan view detail tugas ke 'guru.detail-tugas'.
 */
class TugasController extends Controller
{
    // ─── [GURU] Dashboard guru ──────────────────────────────────
    public function dashboardGuru()
    {
        $guru = Auth::user();
        $totalTugas = Tugas::where('guru_id', $guru->id)->count();
        $tugasMendatang = Tugas::where('guru_id', $guru->id)
            ->where('tgl_pengumpulan', '>=', now())
            ->count();
        $totalSiswa = User::where('role', 'siswa')->count();
        $tugasRecentLimit = Tugas::where('guru_id', $guru->id)
            ->latest()
            ->take(5)
            ->get();

        return view('guru.dashboard', compact('guru', 'totalTugas', 'tugasMendatang', 'totalSiswa', 'tugasRecentLimit'));
    }

    // ─── [SISWA] Dashboard siswa ────────────────────────────────
    public function dashboardSiswa()
    {
        $siswa = Auth::user();
        $tugasBelumSelesai = Pengumpulan::where('siswa_id', $siswa->id)
            ->where('status', 'belum')
            ->with('tugas')
            ->count();
        $tugasSelesai = Pengumpulan::where('siswa_id', $siswa->id)
            ->where('status', 'sudah')
            ->with('tugas')
            ->count();
        $tugasTotal = Pengumpulan::where('siswa_id', $siswa->id)->count();
        $notifikasiTerbaru = Notifikasi::where('user_id', $siswa->id)
            ->where('dibaca', false)
            ->count();
        $tugasRecentLimit = Pengumpulan::where('siswa_id', $siswa->id)
            ->with('tugas')
            ->latest()
            ->take(5)
            ->get();

        return view('siswa.dashboard', compact('siswa', 'tugasBelumSelesai', 'tugasSelesai', 'tugasTotal', 'notifikasiTerbaru', 'tugasRecentLimit'));
    }

    // ─── [GURU] Daftar semua tugas milik guru ───────────────────
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
    
    // ─── [GURU] Alias indexGuru untuk routes ─────────────────────
    public function indexGuru()
    {
        return $this->index();
    }

    // ─── [GURU] Form buat tugas ──────────────────────────────────
    public function create()
    {
        return view('guru.buat-tugas');
    }

    // ─── [GURU] Simpan tugas baru ────────────────────────────────
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'            => 'required|string|max:255',
            'deskripsi'        => 'nullable|string',
            'mapel'            => 'required|string|max:100',
            'kelas'            => 'required|string|max:50',
            'tgl_pemberian'    => 'required|date',
            'tgl_pengumpulan'  => 'required|date|after_or_equal:tgl_pemberian',
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

        // Buat record pengumpulan + notifikasi untuk tiap siswa di kelas
        $siswaDiKelas = User::where('role', 'siswa')
                            ->where('kelas', $validated['kelas'])
                            ->get();

        foreach ($siswaDiKelas as $siswa) {
            // Record pengumpulan (status awal: belum)
            Pengumpulan::create([
                'tugas_id' => $tugas->id,
                'siswa_id' => $siswa->id,
                'status'   => 'belum',
            ]);

            // Notifikasi tugas baru
            Notifikasi::create([
                'user_id'  => $siswa->id,
                'tugas_id' => $tugas->id,
                'judul'    => 'Tugas baru: ' . $tugas->judul,
                'pesan'    => 'Guru ' . Auth::user()->name . ' menambahkan tugas baru untuk '
                              . $tugas->mapel . '. Deadline: '
                              . \Carbon\Carbon::parse($tugas->tgl_pengumpulan)->format('d M Y') . '.',
                'tipe'     => 'tugas_baru',
            ]);
        }

        return redirect()->route('guru.kelola-tugas')
                         ->with('success', 'Tugas berhasil dibuat dan notifikasi dikirim ke ' . $siswaDiKelas->count() . ' siswa!');
    }

    // ─── [GURU] Detail tugas + daftar pengumpulan ───────────────
    public function show(Tugas $tugas)
    {
        $this->authorizeGuru($tugas);

        $daftarPengumpulan = $tugas->pengumpulan()
            ->with('siswa')
            ->get();

        return view('guru.detail-tugas', compact('tugas', 'daftarPengumpulan'));
    }

    // ─── [GURU] Form edit tugas ──────────────────────────────────
    public function edit(Tugas $tugas)
    {
        $this->authorizeGuru($tugas);

        return view('guru.edit-tugas', compact('tugas'));
    }

    // ─── [GURU] Simpan perubahan tugas ──────────────────────────
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

        // Jika kelas berubah, buat ulang record pengumpulan
        if ($kelasLama !== $validated['kelas']) {
            $tugas->pengumpulan()->delete();

            $siswaBaru = User::where('role', 'siswa')
                             ->where('kelas', $validated['kelas'])
                             ->get();

            foreach ($siswaBaru as $siswa) {
                Pengumpulan::create([
                    'tugas_id' => $tugas->id,
                    'siswa_id' => $siswa->id,
                    'status'   => 'belum',
                ]);
            }
        }

        // Kirim notifikasi "tugas diperbarui" ke siswa kelas baru
        $siswaDiKelas = User::where('role', 'siswa')
                            ->where('kelas', $validated['kelas'])
                            ->get();

        foreach ($siswaDiKelas as $siswa) {
            Notifikasi::create([
                'user_id'  => $siswa->id,
                'tugas_id' => $tugas->id,
                'judul'    => 'Tugas diperbarui: ' . $tugas->judul,
                'pesan'    => 'Guru ' . Auth::user()->name . ' memperbarui tugas '
                              . $tugas->mapel . '. Cek detail terbaru di halaman tugas.',
                'tipe'     => 'diperbarui',
            ]);
        }

        return redirect()->route('guru.kelola-tugas')
                         ->with('success', 'Tugas berhasil diperbarui!');
    }

    // ─── [GURU] Hapus tugas ──────────────────────────────────────
    public function destroy(Tugas $tugas)
    {
        $this->authorizeGuru($tugas);
        $tugas->delete(); // cascade akan hapus pengumpulan & notifikasi

        return redirect()->route('guru.kelola-tugas')
                         ->with('success', 'Tugas berhasil dihapus.');
    }

    // ─── [GURU] Toggle status pengumpulan siswa ─────────────────
    public function toggleStatus(Request $request, Pengumpulan $pengumpulan)
    {
        $this->authorizeGuru($pengumpulan->tugas);

        $pengumpulan->status = $pengumpulan->status === 'belum' ? 'sudah' : 'belum';
        $pengumpulan->dikumpulkan_at = $pengumpulan->status === 'sudah' ? now() : null;
        $pengumpulan->save();

        return back()->with('success', 'Status pengumpulan berhasil diperbarui.');
    }

    // ─── Helper: verifikasi tugas milik guru yang login ─────────
    private function authorizeGuru(Tugas $tugas): void
    {
        if ($tugas->guru_id !== Auth::id()) {
            abort(403, 'Akses ditolak. Tugas ini bukan milik Anda.');
        }
    }
}