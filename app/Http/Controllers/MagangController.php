<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Magang;
use Illuminate\Support\Facades\Auth;

class MagangController extends Controller
{
    // Tampilkan Form
    public function create()
    {
        // Cek jika sudah pernah daftar, jangan kasih daftar lagi (Opsional)
        $existing = Magang::where('user_id', Auth::id())->first();
        if ($existing) {
            return redirect()->route('dashboard')->with('status', 'Anda sudah mendaftar!');
        }

        return view('magang.create');
    }

    // Simpan Data
    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|string|max:20',
            'universitas' => 'required|string|max:100',
            'jurusan' => 'required|string|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
        ]);

        Magang::create([
            'user_id' => Auth::id(), // Ambil ID user yang sedang login
            'nim' => $request->nim,
            'universitas' => $request->universitas,
            'jurusan' => $request->jurusan,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Pendaftaran berhasil dikirim! Menunggu persetujuan Admin.');
    }
}