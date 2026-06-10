<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\Pengumpulan;
use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TugasController extends Controller
{
    // --- [SISWA] Daftar tugas milik siswa ----------------------
    public function tugasSiswa()
    {
        $siswa = Auth::user();
        $pengumpulan = Pengumpulan::where('siswa_id', $siswa->id)
            ->with('tugas')
            ->latest()
            ->get();

        return view('siswa.tugas', compact('siswa', 'pengumpulan'));
    }

    // --- [GURU] Dashboard guru ----------------------------------
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

    // --- [SISWA] Dashboard siswa --------------------------------
    public function dashboardSiswa()
    {
        $siswa = Auth::user();

        $semuaPengumpulan = Pengumpulan::where('siswa_id', $siswa->id)
            ->with('tugas')
            ->get();

        $tugasTotal        = $semuaPengumpulan->count();
        $tugasBelumSelesai = $semuaPengumpulan->where('status', 'belum')->count();
        $tugasSelesai      = $semuaPengumpulan->where('status', 'sudah')->count();

        $tugasTerlambat = $semuaPengumpulan->filter(function ($p) {
            return $p->status === 'belum'
                && $p->tugas
                && \Carbon\Carbon::parse($p->tugas->tgl_pengumpulan)->isPast();
        })->count();

        $tugasSegera = $semuaPengumpulan->filter(function ($p) {
            return in_array($p->status, ['belum', 'proses'])
                && $p->tugas
                && \Carbon\Carbon::parse($p->tugas->tgl_pengumpulan)->isFuture()
                && \Carbon\Carbon::parse($p->tugas->tgl_pengumpulan)->diffInDays(now()) <= 3;
        })->count();

        $notifikasiTerbaru = Notifikasi::where('user_id', $siswa->id)
            ->where('dibaca', false)
            ->count();

        $tugasRecentLimit = Pengumpulan::where('siswa_id', $siswa->id)
            ->with('tugas')
            ->get()
            ->sortBy(fn($p) => optional($p->tugas)->tgl_pengumpulan)
            ->take(5)
            ->values();

        return view('siswa.dashboard', compact(
            'siswa', 'tugasBelumSelesai', 'tugasSelesai', 'tugasTotal',
            'tugasTerlambat', 'tugasSegera', 'notifikasiTerbaru', 'tugasRecentLimit'
        ));
    }

    // --- [GURU] Daftar semua tugas milik guru -------------------
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

    public function indexGuru()
    {
        return $this->index();
    }

    // --- [GURU] Form buat tugas ----------------------------------
    public function create()
    {
        $kelasList = User::where('role', 'siswa')
            ->whereNotNull('kelas')
            ->distinct()
            ->orderBy('kelas')
            ->pluck('kelas');

        return view('guru.buat-tugas', compact('kelasList'));
    }

    // --- [GURU] Simpan tugas baru --------------------------------
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
        ]);

        $filePath = null;
        $fileOriginalName = null;

        if ($request->hasFile('file_tugas')) {
            $file = $request->file('file_tugas');
            $fileOriginalName = $file->getClientOriginalName();
            $filePath = $file->storeAs('tugas', time() . '_' . $fileOriginalName, 'public');
        }

        $tugas = Tugas::create([
            ...$validated,
            'guru_id'            => Auth::id(),
            'file_path'          => $filePath,
            'file_original_name' => $fileOriginalName,
        ]);

        $siswaDiKelas = User::where('role', 'siswa')->where('kelas', $validated['kelas'])->get();

        foreach ($siswaDiKelas as $siswa) {
            Pengumpulan::create([
                'tugas_id' => $tugas->id,
                'siswa_id' => $siswa->id,
                'status'   => 'belum',
            ]);

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

    // --- [GURU] Detail tugas + daftar pengumpulan ---------------
    public function show(Tugas $tugas)
    {
        $this->authorizeGuru($tugas);

        $daftarPengumpulan = $tugas->pengumpulan()
            ->with('siswa')
            ->orderByRaw("FIELD(status, 'proses', 'sudah', 'terlambat', 'belum')")
            ->orderBy('dikumpulkan_at', 'asc')
            ->get();

        return view('guru.detail-tugas', compact('tugas', 'daftarPengumpulan'));
    }

    // --- [GURU] Form edit tugas ----------------------------------
    public function edit(Tugas $tugas)
    {
        $this->authorizeGuru($tugas);

        $kelasList = User::where('role', 'siswa')
            ->whereNotNull('kelas')
            ->distinct()
            ->orderBy('kelas')
            ->pluck('kelas');

        return view('guru.edit-tugas', compact('tugas', 'kelasList'));
    }

    // --- [GURU] Simpan perubahan tugas --------------------------
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
        ]);

        $filePath = $tugas->file_path;
        $fileOriginalName = $tugas->file_original_name;

        if ($request->hasFile('file_tugas')) {
            if ($tugas->file_path && \Storage::disk('public')->exists($tugas->file_path)) {
                \Storage::disk('public')->delete($tugas->file_path);
            }
            $file = $request->file('file_tugas');
            $fileOriginalName = $file->getClientOriginalName();
            $filePath = $file->storeAs('tugas', time() . '_' . $fileOriginalName, 'public');
        }

        $kelasLama = $tugas->kelas;
        $tugas->update([...$validated, 'file_path' => $filePath, 'file_original_name' => $fileOriginalName]);

        if ($kelasLama !== $validated['kelas']) {
            $tugas->pengumpulan()->delete();
            $siswaBaru = User::where('role', 'siswa')->where('kelas', $validated['kelas'])->get();
            foreach ($siswaBaru as $siswa) {
                Pengumpulan::create(['tugas_id' => $tugas->id, 'siswa_id' => $siswa->id, 'status' => 'belum']);
            }
        }

        $siswaDiKelas = User::where('role', 'siswa')->where('kelas', $validated['kelas'])->get();
        foreach ($siswaDiKelas as $siswa) {
            Notifikasi::create([
                'user_id'  => $siswa->id,
                'tugas_id' => $tugas->id,
                'judul'    => 'Tugas diperbarui: ' . $tugas->judul,
                'pesan'    => 'Guru ' . Auth::user()->name . ' memperbarui tugas ' . $tugas->mapel . '. Cek detail terbaru di halaman tugas.',
                'tipe'     => 'diperbarui',
            ]);
        }

        return redirect()->route('guru.kelola-tugas')->with('success', 'Tugas berhasil diperbarui!');
    }

    // --- [GURU] Hapus tugas --------------------------------------
    public function destroy(Tugas $tugas)
    {
        $this->authorizeGuru($tugas);

        if ($tugas->file_path && \Storage::disk('public')->exists($tugas->file_path)) {
            \Storage::disk('public')->delete($tugas->file_path);
        }

        foreach ($tugas->pengumpulan as $p) {
            if ($p->file_path && \Storage::disk('public')->exists($p->file_path)) {
                \Storage::disk('public')->delete($p->file_path);
            }
        }

        $tugas->delete();

        return redirect()->route('guru.kelola-tugas')->with('success', 'Tugas berhasil dihapus.');
    }

    // ─────────────────────────────────────────────────────────────
    // --- [GURU] Beri Nilai + Feedback ke pengumpulan siswa -------
    // ─────────────────────────────────────────────────────────────
    public function beriNilai(Request $request, Pengumpulan $pengumpulan)
    {
        $this->authorizeGuru($pengumpulan->tugas);

        $validated = $request->validate([
            'nilai'        => 'required|integer|min:0|max:100',
            'feedback_guru'=> 'nullable|string|max:1000',
        ], [
            'nilai.required' => 'Nilai wajib diisi.',
            'nilai.min'      => 'Nilai minimal 0.',
            'nilai.max'      => 'Nilai maksimal 100.',
        ]);

        $pengumpulan->update([
            'nilai'        => $validated['nilai'],
            'feedback_guru'=> $validated['feedback_guru'] ?? null,
            'status'       => 'sudah',
        ]);

        // Notifikasi ke siswa bahwa tugasnya sudah dinilai
        Notifikasi::create([
            'user_id'  => $pengumpulan->siswa_id,
            'tugas_id' => $pengumpulan->tugas_id,
            'judul'    => '🎯 Tugas kamu sudah dinilai: ' . $pengumpulan->tugas->judul,
            'pesan'    => 'Tugas ' . $pengumpulan->tugas->mapel . ' (' . $pengumpulan->tugas->judul . ') '
                         . 'kamu sudah dinilai. Nilai kamu: ' . $validated['nilai'] . '/100.'
                         . ($validated['feedback_guru'] ? ' Feedback guru: ' . $validated['feedback_guru'] : ''),
            'tipe'     => 'nilai',
        ]);

        return back()->with('success', 'Nilai berhasil disimpan dan siswa telah diberitahu.');
    }

    // ─────────────────────────────────────────────────────────────
    // --- [GURU] Tandai sebagai belum (reset) ---------------------
    // ─────────────────────────────────────────────────────────────
    public function toggleStatus(Request $request, Pengumpulan $pengumpulan)
    {
        $this->authorizeGuru($pengumpulan->tugas);

        // Jika ada nilai & feedback dikirim → pakai beriNilai logic
        if ($request->has('nilai') && $request->nilai !== null && $request->nilai !== '') {
            return $this->beriNilai($request, $pengumpulan);
        }

        // Toggle sederhana: sudah → belum, belum → sudah
        if ($pengumpulan->status === 'belum') {
            $pengumpulan->update(['status' => 'sudah', 'dikumpulkan_at' => now()]);
        } else {
            $pengumpulan->update(['status' => 'belum', 'dikumpulkan_at' => null, 'nilai' => null, 'feedback_guru' => null]);
        }

        return back()->with('success', 'Status pengumpulan berhasil diperbarui.');
    }

    // ─────────────────────────────────────────────────────────────
    // --- [GURU] Preview / lihat file jawaban siswa ---------------
    // ─────────────────────────────────────────────────────────────
    public function previewJawaban(Pengumpulan $pengumpulan)
    {
        $this->authorizeGuru($pengumpulan->tugas);

        if (! $pengumpulan->file_path) {
            abort(404, 'File jawaban tidak ditemukan.');
        }

        $fullPath = storage_path('app/public/' . $pengumpulan->file_path);

        if (! file_exists($fullPath)) {
            abort(404, 'File tidak ditemukan di server.');
        }

        $mime = mime_content_type($fullPath);

        // Untuk gambar & PDF → tampilkan inline di browser
        $inlineTypes = ['application/pdf', 'image/jpeg', 'image/png', 'image/gif', 'image/webp'];

        if (in_array($mime, $inlineTypes)) {
            return response()->file($fullPath, [
                'Content-Type'        => $mime,
                'Content-Disposition' => 'inline; filename="' . $pengumpulan->file_original_name . '"',
            ]);
        }

        // Untuk file lain (docx, xlsx, dll) → force download
        return response()->download($fullPath, $pengumpulan->file_original_name);
    }

    // ─────────────────────────────────────────────────────────────
    // --- [SISWA] Detail tugas + form pengumpulan ----------------
    // ─────────────────────────────────────────────────────────────
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

    // --- [SISWA] Submit/Upload jawaban tugas --------------------
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
            if ($pengumpulan->file_path && \Storage::disk('public')->exists($pengumpulan->file_path)) {
                \Storage::disk('public')->delete($pengumpulan->file_path);
            }

            $file = $request->file('file_jawaban');
            $fileOriginalName = $file->getClientOriginalName();
            $filePath = $file->storeAs('pengumpulan', time() . '_' . $fileOriginalName, 'public');

            $pengumpulan->update([
                'file_path'          => $filePath,
                'file_original_name' => $fileOriginalName,
                'catatan'            => $validated['catatan'] ?? null,
                'status'             => 'proses',
                'dikumpulkan_at'     => now(),
            ]);

            Notifikasi::create([
                'user_id'  => $tugas->guru_id,
                'tugas_id' => $tugas->id,
                'judul'    => 'Siswa mengumpulkan tugas: ' . $tugas->judul,
                'pesan'    => $siswa->name . ' telah mengumpulkan jawaban untuk tugas ' . $tugas->mapel . '.',
                'tipe'     => 'pengumpulan_siswa',
            ]);

            return redirect()->route('siswa.detail-tugas', $tugas->id)->with('success', 'Tugas berhasil dikumpulkan!');
        } catch (\Exception $e) {
            \Log::error('Error upload tugas: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengupload file: ' . $e->getMessage());
        }
    }

    // --- [SISWA] Edit pengumpulan (upload ulang) ----------------
    public function editPengumpulanSiswa(Tugas $tugas)
    {
        $siswa = Auth::user();
        try {
            $pengumpulan = Pengumpulan::where('tugas_id', $tugas->id)
                ->where('siswa_id', $siswa->id)
                ->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', 'Pengumpulan tugas tidak ditemukan.');
        }
        return view('siswa.edit-pengumpulan', compact('tugas', 'pengumpulan'));
    }

    // --- [SISWA] Update pengumpulan -----------------------------
    public function updatePengumpulanSiswa(Request $request, Tugas $tugas)
    {
        $siswa = Auth::user();
        try {
            $pengumpulan = Pengumpulan::where('tugas_id', $tugas->id)
                ->where('siswa_id', $siswa->id)
                ->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', 'Pengumpulan tugas tidak ditemukan.');
        }

        $validated = $request->validate([
            'file_jawaban' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip,jpg,jpeg,png|max:10240',
            'catatan'      => 'nullable|string|max:1000',
        ]);

        try {
            $filePath = $pengumpulan->file_path;
            $fileOriginalName = $pengumpulan->file_original_name;

            if ($request->hasFile('file_jawaban')) {
                if ($pengumpulan->file_path && \Storage::disk('public')->exists($pengumpulan->file_path)) {
                    \Storage::disk('public')->delete($pengumpulan->file_path);
                }
                $file = $request->file('file_jawaban');
                $fileOriginalName = $file->getClientOriginalName();
                $filePath = $file->storeAs('pengumpulan', time() . '_' . $fileOriginalName, 'public');
            }

            $pengumpulan->update([
                'file_path'          => $filePath,
                'file_original_name' => $fileOriginalName,
                'catatan'            => $validated['catatan'] ?? $pengumpulan->catatan,
                'status'             => 'proses',
                'dikumpulkan_at'     => now(),
            ]);

            Notifikasi::create([
                'user_id'  => $tugas->guru_id,
                'tugas_id' => $tugas->id,
                'judul'    => 'Siswa mengupdate pengumpulan: ' . $tugas->judul,
                'pesan'    => $siswa->name . ' telah mengupdate jawaban untuk tugas ' . $tugas->mapel . '.',
                'tipe'     => 'pengumpulan_update',
            ]);

            return redirect()->route('siswa.detail-tugas', $tugas->id)->with('success', 'Jawaban berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengupdate file: ' . $e->getMessage());
        }
    }

    private function authorizeGuru(Tugas $tugas): void
    {
        if ($tugas->guru_id !== Auth::id()) {
            abort(403, 'Akses ditolak. Tugas ini bukan milik Anda.');
        }
    }
}
