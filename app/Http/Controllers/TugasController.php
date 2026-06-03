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
    // ─── [SISWA] Daftar tugas milik siswa ──────────────────────
    public function tugasSiswa()
    {
        $siswa = Auth::user();
        $pengumpulan = \App\Models\Pengumpulan::where('siswa_id', $siswa->id)
            ->with('tugas')
            ->latest()
            ->get();

        return view('siswa.tugas', compact('siswa', 'pengumpulan'));
    }

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

        // Ambil semua pengumpulan siswa beserta relasi tugas sekaligus
        $semuaPengumpulan = Pengumpulan::where('siswa_id', $siswa->id)
            ->with('tugas')
            ->get();

        $tugasTotal        = $semuaPengumpulan->count();
        $tugasBelumSelesai = $semuaPengumpulan->where('status', 'belum')->count();
        $tugasSelesai      = $semuaPengumpulan->where('status', 'sudah')->count();

        // Tugas yang deadline-nya sudah lewat DAN belum dikumpulkan
        $tugasTerlambat = $semuaPengumpulan->filter(function ($p) {
            return $p->status === 'belum'
                && $p->tugas
                && \Carbon\Carbon::parse($p->tugas->tgl_pengumpulan)->isPast();
        })->count();

        // Tugas yang deadline-nya dalam 3 hari ke depan (belum/proses)
        $tugasSegera = $semuaPengumpulan->filter(function ($p) {
            return in_array($p->status, ['belum', 'proses'])
                && $p->tugas
                && \Carbon\Carbon::parse($p->tugas->tgl_pengumpulan)->isFuture()
                && \Carbon\Carbon::parse($p->tugas->tgl_pengumpulan)->diffInDays(now()) <= 3;
        })->count();

        $notifikasiTerbaru = Notifikasi::where('user_id', $siswa->id)
            ->where('dibaca', false)
            ->count();

        // 5 tugas terbaru — urutkan berdasarkan deadline terdekat
        $tugasRecentLimit = Pengumpulan::where('siswa_id', $siswa->id)
            ->with('tugas')
            ->get()
            ->sortBy(function ($p) {
                return optional($p->tugas)->tgl_pengumpulan;
            })
            ->take(5)
            ->values();

        return view('siswa.dashboard', compact(
            'siswa',
            'tugasBelumSelesai',
            'tugasSelesai',
            'tugasTotal',
            'tugasTerlambat',
            'tugasSegera',
            'notifikasiTerbaru',
            'tugasRecentLimit'
        ));
    }

    // ─── [GURU] Daftar semua tugas milik guru ───────────────────
    public function index()
    {
        $tugas = Tugas::where('guru_id', Auth::id())
            ->withCount([
                'pengumpulan as pengumpulan_count',
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
            'file_tugas'       => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip|max:10240',
        ], [
            'judul.required'           => 'Judul tugas wajib diisi.',
            'mapel.required'           => 'Mata pelajaran wajib dipilih.',
            'kelas.required'           => 'Kelas wajib dipilih.',
            'tgl_pemberian.required'   => 'Tanggal pemberian wajib diisi.',
            'tgl_pengumpulan.required' => 'Tanggal pengumpulan wajib diisi.',
            'tgl_pengumpulan.after_or_equal' => 'Tanggal pengumpulan harus setelah atau sama dengan tanggal pemberian.',
            'file_tugas.mimes'         => 'File harus berformat: PDF, Word, Excel, PowerPoint, TXT, atau ZIP.',
            'file_tugas.max'           => 'Ukuran file maksimal 10MB.',
        ]);

        $filePath = null;
        $fileOriginalName = null;

        // Handle file upload
        if ($request->hasFile('file_tugas')) {
            $file = $request->file('file_tugas');
            $fileOriginalName = $file->getClientOriginalName();
            // Simpan file ke folder storage/app/tugas dengan nama yang unik
            $filePath = $file->storeAs(
                'tugas',
                time() . '_' . $fileOriginalName,
                'public'
            );
        }

        $tugas = Tugas::create([
            ...$validated,
            'guru_id'           => Auth::id(),
            'file_path'         => $filePath,
            'file_original_name' => $fileOriginalName,
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
            'file_tugas'      => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip|max:10240',
        ], [
            'file_tugas.mimes' => 'File harus berformat: PDF, Word, Excel, PowerPoint, TXT, atau ZIP.',
            'file_tugas.max'   => 'Ukuran file maksimal 10MB.',
        ]);

        $filePath = $tugas->file_path;
        $fileOriginalName = $tugas->file_original_name;

        // Handle file upload jika ada file baru
        if ($request->hasFile('file_tugas')) {
            // Hapus file lama jika ada
            if ($tugas->file_path && \Storage::disk('public')->exists($tugas->file_path)) {
                \Storage::disk('public')->delete($tugas->file_path);
            }

            $file = $request->file('file_tugas');
            $fileOriginalName = $file->getClientOriginalName();
            $filePath = $file->storeAs(
                'tugas',
                time() . '_' . $fileOriginalName,
                'public'
            );
        }

        $kelasLama = $tugas->kelas;
        $tugas->update([
            ...$validated,
            'file_path'         => $filePath,
            'file_original_name' => $fileOriginalName,
        ]);

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

        // Hapus file tugas jika ada
        if ($tugas->file_path && \Storage::disk('public')->exists($tugas->file_path)) {
            \Storage::disk('public')->delete($tugas->file_path);
        }

        // Hapus file pengumpulan siswa terkait
        $pengumpulans = $tugas->pengumpulan;
        foreach ($pengumpulans as $pengumpulan) {
            if ($pengumpulan->file_path && \Storage::disk('public')->exists($pengumpulan->file_path)) {
                \Storage::disk('public')->delete($pengumpulan->file_path);
            }
        }

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

    // ─── [SISWA] List semua tugas untuk siswa ───────────────────
    public function listTugasSiswa()
    {
        $siswa = Auth::user();
        $pengumpulans = Pengumpulan::where('siswa_id', $siswa->id)
            ->with('tugas')
            ->latest()
            ->get();

        return view('siswa.tugas', compact('pengumpulans'));
    }

    // ─── [SISWA] Detail tugas + form pengumpulan ────────────────
    public function detailTugasSiswa(Tugas $tugas)
    {
        $siswa = Auth::user();
        
        try {
            $pengumpulan = Pengumpulan::where('tugas_id', $tugas->id)
                                       ->where('siswa_id', $siswa->id)
                                       ->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', 'Pengumpulan tugas tidak ditemukan untuk siswa ini.');
        }

        return view('siswa.detail-tugas', compact('tugas', 'pengumpulan'));
    }

    // ─── [SISWA] Submit/Upload jawaban tugas ────────────────────
    public function submitTugas(Request $request, Tugas $tugas)
    {
        $siswa = Auth::user();
        $pengumpulan = Pengumpulan::where('tugas_id', $tugas->id)
                                   ->where('siswa_id', $siswa->id)
                                   ->firstOrFail();

        $validated = $request->validate([
            'file_jawaban' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip,jpg,jpeg,png|max:10240',
            'catatan'      => 'nullable|string|max:1000',
        ], [
            'file_jawaban.required' => 'File jawaban wajib diupload.',
            'file_jawaban.mimes'    => 'File harus berformat: PDF, Word, Excel, PowerPoint, TXT, ZIP, atau gambar.',
            'file_jawaban.max'      => 'Ukuran file maksimal 10MB.',
        ]);

        try {
            // Hapus file lama jika ada
            if ($pengumpulan->file_path && \Storage::disk('public')->exists($pengumpulan->file_path)) {
                \Storage::disk('public')->delete($pengumpulan->file_path);
            }

            $file = $request->file('file_jawaban');
            $fileOriginalName = $file->getClientOriginalName();
            $filePath = $file->storeAs(
                'pengumpulan',
                time() . '_' . $fileOriginalName,
                'public'
            );

            $pengumpulan->update([
                'file_path'         => $filePath,
                'file_original_name' => $fileOriginalName,
                'catatan'           => $validated['catatan'] ?? null,
                'status'            => 'proses',
                'dikumpulkan_at'    => now(),
            ]);

            // Kirim notifikasi ke guru
            Notifikasi::create([
                'user_id'  => $tugas->guru_id,
                'tugas_id' => $tugas->id,
                'judul'    => 'Siswa mengumpulkan tugas: ' . $tugas->judul,
                'pesan'    => $siswa->name . ' telah mengumpulkan jawaban untuk tugas ' . $tugas->mapel . '.',
                'tipe'     => 'pengumpulan_siswa',
            ]);

            return redirect()->route('siswa.detail-tugas', $tugas->id)
                             ->with('success', 'Tugas berhasil dikumpulkan!');
        } catch (\Exception $e) {
            \Log::error('Error saat upload tugas: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengupload file: ' . $e->getMessage());
        }
    }

    // ─── [SISWA] Edit/Update pengumpulan (untuk upload ulang) ───
    public function editPengumpulanSiswa(Tugas $tugas)
    {
        $siswa = Auth::user();
        
        try {
            $pengumpulan = Pengumpulan::where('tugas_id', $tugas->id)
                                       ->where('siswa_id', $siswa->id)
                                       ->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', 'Pengumpulan tugas tidak ditemukan untuk siswa ini.');
        }

        return view('siswa.edit-pengumpulan', compact('tugas', 'pengumpulan'));
    }

    // ─── [SISWA] Update pengumpulan (edit jawaban) ──────────────
    public function updatePengumpulanSiswa(Request $request, Tugas $tugas)
    {
        $siswa = Auth::user();
        
        try {
            $pengumpulan = Pengumpulan::where('tugas_id', $tugas->id)
                                       ->where('siswa_id', $siswa->id)
                                       ->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', 'Pengumpulan tugas tidak ditemukan untuk siswa ini.');
        }

        $validated = $request->validate([
            'file_jawaban' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip,jpg,jpeg,png|max:10240',
            'catatan'      => 'nullable|string|max:1000',
        ], [
            'file_jawaban.mimes' => 'File harus berformat: PDF, Word, Excel, PowerPoint, TXT, ZIP, atau gambar.',
            'file_jawaban.max'   => 'Ukuran file maksimal 10MB.',
        ]);

        try {
            $filePath = $pengumpulan->file_path;
            $fileOriginalName = $pengumpulan->file_original_name;

            // Handle file upload jika ada file baru
            if ($request->hasFile('file_jawaban')) {
                // Hapus file lama
                if ($pengumpulan->file_path && \Storage::disk('public')->exists($pengumpulan->file_path)) {
                    \Storage::disk('public')->delete($pengumpulan->file_path);
                }

                $file = $request->file('file_jawaban');
                $fileOriginalName = $file->getClientOriginalName();
                $filePath = $file->storeAs(
                    'pengumpulan',
                    time() . '_' . $fileOriginalName,
                    'public'
                );
            }

            $pengumpulan->update([
                'file_path'         => $filePath,
                'file_original_name' => $fileOriginalName,
                'catatan'           => $validated['catatan'] ?? $pengumpulan->catatan,
                'status'            => 'proses',
                'dikumpulkan_at'    => now(),
            ]);

            // Kirim notifikasi ke guru tentang update
            Notifikasi::create([
                'user_id'  => $tugas->guru_id,
                'tugas_id' => $tugas->id,
                'judul'    => 'Siswa mengupdate pengumpulan: ' . $tugas->judul,
                'pesan'    => $siswa->name . ' telah mengupdate jawaban untuk tugas ' . $tugas->mapel . '.',
                'tipe'     => 'pengumpulan_update',
            ]);

            return redirect()->route('siswa.detail-tugas', $tugas->id)
                             ->with('success', 'Jawaban berhasil diperbarui!');
        } catch (\Exception $e) {
            \Log::error('Error saat update pengumpulan: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengupdate file: ' . $e->getMessage());
        }
    }
}