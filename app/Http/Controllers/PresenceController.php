<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presence; // Pastikan Model ini sudah dibuat di Langkah 1 & 2B
use App\Models\Magang;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PresenceController extends Controller
{
    // Halaman Absensi
    public function index()
    {
        $userId = Auth::id();
        $today = Carbon::today()->toDateString();

        // Cek status magang dulu
        $magang = Magang::where('user_id', $userId)->first();
        if (!$magang || $magang->status != 'approved') {
            return redirect()->route('dashboard')->with('error', 'Akun magang belum disetujui.');
        }

        // Cek absen hari ini
        $presenceToday = Presence::where('user_id', $userId)
                                ->where('tanggal', $today)
                                ->first();

        // Ambil riwayat
        $history = Presence::where('user_id', $userId)
                            ->orderBy('tanggal', 'desc')
                            ->get();

        return view('presence.index', compact('presenceToday', 'history'));
    }

    // Proses Absen Masuk
    public function checkIn()
    {
        $userId = Auth::id();
        $today = Carbon::today()->toDateString();

        // Cek double
        if (Presence::where('user_id', $userId)->where('tanggal', $today)->exists()) {
            return redirect()->back()->with('error', 'Anda sudah absen masuk hari ini.');
        }

        Presence::create([
            'user_id' => $userId,
            'tanggal' => $today,
            'jam_masuk' => Carbon::now()->toTimeString(),
            'status' => 'Hadir'
        ]);

        return redirect()->back()->with('success', 'Berhasil Absen Masuk!');
    }

    // Proses Absen Pulang
    public function checkOut()
    {
        $userId = Auth::id();
        $today = Carbon::today()->toDateString();

        $presence = Presence::where('user_id', $userId)->where('tanggal', $today)->first();

        if (!$presence) {
            return redirect()->back()->with('error', 'Belum absen masuk!');
        }
        
        $presence->update([
            'jam_keluar' => Carbon::now()->toTimeString()
        ]);

        return redirect()->back()->with('success', 'Berhasil Absen Pulang. Hati-hati di jalan!');
    }
}