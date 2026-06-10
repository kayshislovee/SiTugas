<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    // ─── [SISWA] Halaman notifikasi siswa ───────────────────────
    public function index()
    {
        $user = Auth::user();

        $notifikasi = Notifikasi::where('user_id', $user->id)
            ->latest()
            ->paginate(20);

        $totalBelumDibaca = Notifikasi::where('user_id', $user->id)
            ->where('dibaca', false)
            ->count();

        return view('siswa.notifikasi-siswa', compact('notifikasi', 'totalBelumDibaca'));
    }

    // ─── [GURU] Halaman notifikasi guru ─────────────────────────
    public function indexGuru()
    {
        $user = Auth::user();

        $notifikasi = Notifikasi::where('user_id', $user->id)
            ->with('tugas')
            ->latest()
            ->paginate(20);

        $totalBelumDibaca   = Notifikasi::where('user_id', $user->id)->where('dibaca', false)->count();
        $totalPengumpulan   = Notifikasi::where('user_id', $user->id)->whereIn('tipe', ['pengumpulan_siswa', 'pengumpulan_update'])->count();
        $totalNotif         = Notifikasi::where('user_id', $user->id)->count();

        return view('guru.notifikasi', compact(
            'notifikasi',
            'totalBelumDibaca',
            'totalPengumpulan',
            'totalNotif'
        ));
    }

    // ─── Tandai satu notif sebagai dibaca (SISWA & GURU) ────────
    public function markAsRead(Request $request, $id)
    {
        $notifikasi = Notifikasi::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $notifikasi->update(['dibaca' => true]);

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back();
    }

    // ─── Tandai semua notif sebagai dibaca (SISWA & GURU) ───────
    public function markAllAsRead(Request $request)
    {
        Notifikasi::where('user_id', Auth::id())
            ->where('dibaca', false)
            ->update(['dibaca' => true]);

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Semua notifikasi sudah ditandai sebagai dibaca.');
    }

    // ─── Hapus satu notifikasi ───────────────────────────────────
    public function destroy($id)
    {
        Notifikasi::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return back()->with('success', 'Notifikasi dihapus.');
    }
}
