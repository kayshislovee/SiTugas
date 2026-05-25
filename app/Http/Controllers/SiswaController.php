<?php

namespace App\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    /**
     * Menampilkan daftar semua notifikasi milik user yang sedang login (Siswa).
     */
    public function index()
    {
        // 1. Mengambil data user (siswa) yang sedang login
        $user = Auth::user();

        // 2. Mengambil semua notifikasi khusus untuk siswa tersebut, urut dari yang terbaru
        $notifikasi = Notifikasi::where('user_id', $user->user_id)
                                ->latest()
                                ->get();

        // 3. Mengarahkan ke halaman view notifikasi siswa dengan membawa datanya
        return view('siswa.notifikasi', compact('notifikasi'));
    }

    /**
     * Mengubah status notifikasi tertentu menjadi sudah dibaca (Tandai telah dibaca).
     */
    public function markAsRead($id)
    {
        // Mencari notifikasi berdasarkan notif_id
        $notif = Notifikasi::where('notif_id', $id)
                           ->where('user_id', Auth::id())
                           ->first();

        if ($notif) {
            $notif->update(['is_read' => true]);
        }

        return redirect()->back()->with('success', 'Notifikasi ditandai telah dibaca.');
    }

    /**
     * Mengubah SEMUA notifikasi milik siswa tersebut menjadi sudah dibaca sekaligus.
     */
    public function markAllAsRead()
    {
        Notifikasi::where('user_id', Auth::id())
                  ->where('is_read', false)
                  ->update(['is_read' => true]);

        return redirect()->back()->with('success', 'Semua notifikasi telah dibaca.');
    }
}