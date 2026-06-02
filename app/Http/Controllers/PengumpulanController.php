<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengumpulan;
use App\Models\Tugas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengumpulanController extends Controller
{
    // --- MENGIRIM TUGAS BARU ---
    public function store(Request $request, $tugas_id)
    {
        $request->validate([
            'file_tugas' => 'required|mimes:pdf,doc,docx,zip,rar|max:5120', // Maks 5MB, sesuaikan ekstensi
            'keterangan' => 'nullable|string',
        ]);

        $tugas = Tugas::findOrFail($tugas_id);

        // Cek apakah tugas sudah expired
        if ($tugas->isExpired()) {
            return back()->with('error', 'Maaf, waktu pengumpulan tugas ini sudah habis.');
        }

        // Upload File
        $file = $request->file('file_tugas');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('public/tugas_siswa', $fileName); // Tersimpan di storage/app/public/tugas_siswa

        Pengumpulan::create([
            'tugas_id' => $tugas_id,
            'user_id' => Auth::id(), // ID siswa yang sedang login
            'file_path' => $filePath,
            'keterangan' => $request->keterangan,
            'waktu_pengumpulan' => now(),
        ]);

        return back()->with('success', 'Tugas berhasil dikirim!');
    }

    // --- MENGEDIT TUGAS ---
    public function update(Request $request, $id)
    {
        $request->validate([
            'file_tugas' => 'nullable|mimes:pdf,doc,docx,zip,rar|max:5120',
            'keterangan' => 'nullable|string',
        ]);

        $pengumpulan = Pengumpulan::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        if ($pengumpulan->tugas->isExpired()) {
            return back()->with('error', 'Waktu pengumpulan sudah habis, kamu tidak bisa mengubah tugas.');
        }

        // Jika user upload file baru
        if ($request->hasFile('file_tugas')) {
            // Hapus file lama
            if (Storage::exists($pengumpulan->file_path)) {
                Storage::delete($pengumpulan->file_path);
            }

            // Simpan file baru
            $file = $request->file('file_tugas');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $pengumpulan->file_path = $file->storeAs('public/tugas_siswa', $fileName);
        }

        $pengumpulan->keterangan = $request->keterangan;
        $pengumpulan->waktu_pengumpulan = now();
        $pengumpulan->save();

        return back()->with('success', 'Tugas berhasil diperbarui!');
    }

    // --- MENGHAPUS TUGAS ---
    public function destroy($id)
    {
        $pengumpulan = Pengumpulan::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($pengumpulan->tugas->isExpired()) {
            return back()->with('error', 'Waktu pengumpulan sudah habis, kamu tidak bisa menghapus tugas.');
        }

        // Hapus file fisik dari storage
        if (Storage::exists($pengumpulan->file_path)) {
            Storage::delete($pengumpulan->file_path);
        }

        // Hapus data dari database
        $pengumpulan->delete();

        return back()->with('success', 'Tugas berhasil ditarik/dihapus!');
    }
}