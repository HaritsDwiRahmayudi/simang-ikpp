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
    // 1. Validasi Input
    $request->validate([
        'nim' => 'required|string|max:20',
        'universitas' => 'required|string|max:100',
        'jurusan' => 'required|string|max:100',
        'tanggal_mulai' => 'required|date',
        'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        // Validasi File: Wajib, harus PDF, max 2MB
        'surat_balasan' => 'required|mimes:pdf|max:2048', 
    ]);

    // 2. Proses Upload File
    if ($request->hasFile('surat_balasan')) {
        // Simpan file ke folder 'storage/app/public/surat_balasan'
        // Nama file akan di-generate otomatis acak agar aman
        $path = $request->file('surat_balasan')->store('surat_balasan', 'public');
    } else {
        return back()->with('error', 'File surat balasan wajib diupload.');
    }

    // 3. Simpan ke Database
    Magang::create([
        'user_id' => Auth::id(),
        'nim' => $request->nim,
        'universitas' => $request->universitas,
        'jurusan' => $request->jurusan,
        'tanggal_mulai' => $request->tanggal_mulai,
        'tanggal_selesai' => $request->tanggal_selesai,
        'status' => 'pending', // Default status menunggu verifikasi admin
        'surat_balasan' => $path, // Simpan path file
    ]);

    // 4. Redirect
    return redirect()->route('dashboard')->with('success', 'Pendaftaran berhasil dikirim! Menunggu verifikasi admin.');
}
}