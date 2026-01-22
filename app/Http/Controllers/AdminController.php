<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Magang;      // Model Pendaftaran Magang
use App\Models\User;        // Model User
use App\Models\Logbook;     // Model Logbook (Untuk Monitoring)
use App\Models\Presence;    // Model Absensi (Untuk Monitoring)

class AdminController extends Controller
{
    // ==========================================================
    // BAGIAN 1: PENDAFTARAN MAGANG (Dashboard Utama)
    // ==========================================================

    // 1. Tampilkan Daftar Pendaftar (Calon Magang)
    public function index()
    {
        // Ambil semua data magang, urutkan dari yang terbaru
        $pendaftar = Magang::with('user')->latest()->get(); 
        
        return view('admin.dashboard', compact('pendaftar'));
    }

    // 2. Update Status Pendaftaran (Terima/Tolak Awal)
    public function updateStatus($id, $status)
    {
        $magang = Magang::findOrFail($id);

        if (in_array($status, ['approved', 'rejected'])) {
            $magang->status = $status;
            $magang->save();
            
            return redirect()->back()->with('success', 'Status pendaftaran berhasil diperbarui!');
        }

        return redirect()->back()->with('error', 'Status tidak valid!');
    }

    // ==========================================================
    // BAGIAN 2: MONITORING KEGIATAN (Fitur Baru)
    // ==========================================================

    // 3. Halaman Monitoring (Daftar Mahasiswa yang SUDAH DITERIMA)
    public function monitoring()
    {
        // Hanya ambil mahasiswa yang status magangnya 'approved' (Sedang/Selesai Magang)
        $mahasiswas = Magang::with('user')
                            ->where('status', 'approved')
                            ->get();
                            
        return view('admin.monitoring', compact('mahasiswas'));
    }

    // 4. Detail Mahasiswa (Lihat Logbook & Absen per Orang)
    public function detailMahasiswa($id)
    {
        // Cari data magang berdasarkan ID
        $magang = Magang::with('user')->findOrFail($id);
        $userId = $magang->user_id;

        // Ambil riwayat Logbook & Absensi mahasiswa tersebut
        $logs = Logbook::where('user_id', $userId)->orderBy('tanggal', 'desc')->get();
        $presences = Presence::where('user_id', $userId)->orderBy('tanggal', 'desc')->get();

        return view('admin.detail-mahasiswa', compact('magang', 'logs', 'presences'));
    }

    // 5. Aksi Setujui/Tolak Laporan Akhir (Untuk syarat cetak PDF)
    public function approveLaporan(Request $request, $id)
    {
        $magang = Magang::findOrFail($id);
        
        // Validasi input status
        $request->validate([
            'status_laporan' => 'required|in:approved,rejected'
        ]);

        // Update kolom status_laporan
        $magang->update(['status_laporan' => $request->status_laporan]);

        return redirect()->back()->with('success', 'Status laporan akhir berhasil diperbarui.');
    }
}