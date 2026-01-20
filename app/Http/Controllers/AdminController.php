<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Magang; // Jangan lupa import Model

class AdminController extends Controller
{
    // 1. Tampilkan Daftar Pendaftar
    public function index()
    {
        // Ambil semua data magang, urutkan dari yang terbaru
        // with('user') gunanya biar nama mahasiswa ketarik
        $pendaftar = Magang::with('user')->latest()->get(); 
        
        return view('admin.dashboard', compact('pendaftar'));
    }

    // 2. Update Status (Terima/Tolak)
    public function updateStatus($id, $status)
    {
        // Cari data berdasarkan ID
        $magang = Magang::findOrFail($id);

        // Pastikan status hanya boleh 'approved' atau 'rejected'
        if (in_array($status, ['approved', 'rejected'])) {
            $magang->status = $status;
            $magang->save();
            
            return redirect()->back()->with('success', 'Status pendaftaran berhasil diperbarui!');
        }

        return redirect()->back()->with('error', 'Status tidak valid!');
    }
}