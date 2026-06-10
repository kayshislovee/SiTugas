<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tugas;
use App\Models\Pengumpulan;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    // ─── Dashboard ───────────────────────────────────────────────
    public function dashboard()
    {
        $totalGuru   = User::where('role', 'guru')->count();
        $totalSiswa  = User::where('role', 'siswa')->count();
        $totalTugas  = Tugas::count();
        $totalKelas  = User::where('role', 'siswa')
                           ->distinct('kelas')
                           ->count('kelas');

        $guruTerbaru  = User::where('role', 'guru')->latest()->take(5)->get();
        $siswaTerbaru = User::where('role', 'siswa')->latest()->take(5)->get();
        $tugasTerbaru = Tugas::with('guru')->latest()->take(5)->get();

        return view('superadmin.dashboard', compact(
            'totalGuru', 'totalSiswa', 'totalTugas', 'totalKelas',
            'guruTerbaru', 'siswaTerbaru', 'tugasTerbaru'
        ));
    }

    // ─── Manajemen Guru ─────────────────────────────────────────

    public function indexGuru(Request $request)
    {
        $search = $request->input('search');
        $guru = User::where('role', 'guru')
            ->when($search, fn($q) => $q->where('name', 'like', "%$search%")
                                        ->orWhere('nip', 'like', "%$search%"))
            ->latest()
            ->paginate(15);

        return view('superadmin.kelola-guru', compact('guru', 'search'));
    }

    public function createGuru()
    {
        return view('superadmin.tambah-guru');
    }

    public function storeGuru(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'nip'      => 'required|string|max:30|unique:users,nip',
            'password' => 'required|string|min:6',
        ], [
            'name.required'     => 'Nama wajib diisi.',
            'nip.required'      => 'NIP wajib diisi.',
            'nip.unique'        => 'NIP sudah terdaftar.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min'      => 'Kata sandi minimal 6 karakter.',
        ]);

        User::create([
            'name'     => $validated['name'],
            'nip'      => $validated['nip'],
            'role'     => 'guru',
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('superadmin.kelola-guru')
                         ->with('success', 'Guru berhasil ditambahkan!');
    }

    public function editGuru(User $user)
    {
        if ($user->role !== 'guru') abort(404);
        return view('superadmin.edit-guru', compact('user'));
    }

    public function updateGuru(Request $request, User $user)
    {
        if ($user->role !== 'guru') abort(404);

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'nip'      => 'required|string|max:30|unique:users,nip,' . $user->id,
            'password' => 'nullable|string|min:6',
        ]);

        $data = [
            'name' => $validated['name'],
            'nip'  => $validated['nip'],
        ];
        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()->route('superadmin.kelola-guru')
                         ->with('success', 'Data guru berhasil diperbarui!');
    }

    public function destroyGuru(User $user)
    {
        if ($user->role !== 'guru') abort(404);
        $user->delete();
        return redirect()->route('superadmin.kelola-guru')
                         ->with('success', 'Guru berhasil dihapus.');
    }

    // ─── Manajemen Siswa ─────────────────────────────────────────

    public function indexSiswa(Request $request)
    {
        $search = $request->input('search');
        $kelas  = $request->input('kelas');

        $siswa = User::where('role', 'siswa')
            ->when($search, fn($q) => $q->where('name', 'like', "%$search%")
                                        ->orWhere('nis', 'like', "%$search%"))
            ->when($kelas, fn($q) => $q->where('kelas', $kelas))
            ->latest()
            ->paginate(15);

        $kelasList = User::where('role', 'siswa')
                         ->distinct()
                         ->pluck('kelas')
                         ->filter()
                         ->sort()
                         ->values();

        return view('superadmin.kelola-siswa', compact('siswa', 'search', 'kelas', 'kelasList'));
    }

    public function createSiswa()
    {
        return view('superadmin.tambah-siswa');
    }

    public function storeSiswa(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'nis'      => 'required|string|max:20|unique:users,nis',
            'kelas'    => 'required|string|max:20',
            'password' => 'required|string|min:6',
        ], [
            'name.required'     => 'Nama wajib diisi.',
            'nis.required'      => 'NIS wajib diisi.',
            'nis.unique'        => 'NIS sudah terdaftar.',
            'kelas.required'    => 'Kelas wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min'      => 'Kata sandi minimal 6 karakter.',
        ]);

        $siswa = User::create([
            'name'     => $validated['name'],
            'nis'      => $validated['nis'],
            'kelas'    => $validated['kelas'],
            'role'     => 'siswa',
            'password' => Hash::make($validated['password']),
        ]);

        // Otomatis daftarkan ke tugas yang sudah ada untuk kelas ini
        $tugasUntukKelas = Tugas::where('kelas', $siswa->kelas)->get();
        foreach ($tugasUntukKelas as $tugas) {
            Pengumpulan::firstOrCreate([
                'tugas_id' => $tugas->id,
                'siswa_id' => $siswa->id,
            ], ['status' => 'belum']);
        }

        return redirect()->route('superadmin.kelola-siswa')
                         ->with('success', 'Siswa berhasil ditambahkan!');
    }

    public function editSiswa(User $user)
    {
        if ($user->role !== 'siswa') abort(404);
        return view('superadmin.edit-siswa', compact('user'));
    }

    public function updateSiswa(Request $request, User $user)
    {
        if ($user->role !== 'siswa') abort(404);

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'nis'      => 'required|string|max:20|unique:users,nis,' . $user->id,
            'kelas'    => 'required|string|max:20',
            'password' => 'nullable|string|min:6',
        ]);

        $data = [
            'name'  => $validated['name'],
            'nis'   => $validated['nis'],
            'kelas' => $validated['kelas'],
        ];
        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()->route('superadmin.kelola-siswa')
                         ->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroySiswa(User $user)
    {
        if ($user->role !== 'siswa') abort(404);
        $user->delete();
        return redirect()->route('superadmin.kelola-siswa')
                         ->with('success', 'Siswa berhasil dihapus.');
    }

    // ─── Lihat semua tugas (semua guru + semua kelas) ────────────

    public function indexTugas(Request $request)
    {
        $kelas = $request->input('kelas');
        $guru  = $request->input('guru_id');

        $tugas = Tugas::with(['guru', 'pengumpulan'])
            ->when($kelas, fn($q) => $q->where('kelas', $kelas))
            ->when($guru, fn($q) => $q->where('guru_id', $guru))
            ->latest()
            ->paginate(20);

        $kelasList = Tugas::distinct()->pluck('kelas')->filter()->sort()->values();
        $guruList  = User::where('role', 'guru')->get();

        return view('superadmin.kelola-tugas', compact('tugas', 'kelasList', 'guruList', 'kelas', 'guru'));
    }

    // ─── Detail tugas (lihat pengumpulan siswa) ──────────────────

    public function showTugas(Tugas $tugas)
    {
        $daftarPengumpulan = $tugas->pengumpulan()->with('siswa')->get();
        return view('superadmin.detail-tugas', compact('tugas', 'daftarPengumpulan'));
    }
}