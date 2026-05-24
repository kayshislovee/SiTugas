<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    // ─── [SISWA] Daftar notifikasi siswa ────────────────────────
    public function index()
    {
        $notifikasi = Notifikasi::where('user_id', Auth::id())
            ->latest()
            ->paginate(15);

        return view('siswa.notifikasi-siswa', compact('notifikasi'));
    }

    // ─── [SISWA] Tandai satu notifikasi sebagai sudah dibaca ─────
    public function markAsRead(Request $request, Notifikasi $notifikasi)
    {
        // Verifikasi bahwa notifikasi ini milik user yang login
        if ($notifikasi->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $notifikasi->update(['dibaca' => true]);

        return back()->with('success', 'Notifikasi sudah ditandai sebagai dibaca.');
    }

    // ─── [SISWA] Tandai semua notifikasi sebagai sudah dibaca ────
    public function markAllAsRead(Request $request)
    {
        Notifikasi::where('user_id', Auth::id())
            ->where('dibaca', false)
            ->update(['dibaca' => true]);

        return back()->with('success', 'Semua notifikasi sudah ditandai sebagai dibaca.');
    }
}
