<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tugas;
use App\Models\Pengumpulan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    // ─── Guru: Tambah Siswa ──────────────────────────────────────

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

        return view('guru.kelola-siswa', compact('siswa', 'search', 'kelas', 'kelasList'));
    }

    public function createSiswa()
    {
        return view('guru.tambah-siswa');
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

        // Otomatis daftarkan ke tugas yang sudah ada untuk kelas siswa ini
        $tugasUntukKelas = Tugas::where('kelas', $siswa->kelas)->get();
        foreach ($tugasUntukKelas as $tugas) {
            Pengumpulan::firstOrCreate([
                'tugas_id' => $tugas->id,
                'siswa_id' => $siswa->id,
            ], ['status' => 'belum']);
        }

        return redirect()->route('guru.kelola-siswa')
                         ->with('success', 'Siswa berhasil ditambahkan!');
    }

    public function editSiswa(User $user)
    {
        if ($user->role !== 'siswa') abort(404);
        return view('guru.edit-siswa', compact('user'));
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

        return redirect()->route('guru.kelola-siswa')
                         ->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroySiswa(User $user)
    {
        if ($user->role !== 'siswa') abort(404);
        $user->delete();
        return redirect()->route('guru.kelola-siswa')
                         ->with('success', 'Siswa berhasil dihapus.');
    }
}
