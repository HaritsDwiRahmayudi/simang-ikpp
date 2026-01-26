<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Magang;
use App\Models\Logbook;
use App\Models\Presence;
use App\Models\LaporanMingguan;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    // Dashboard Utama
    public function index()
    {
        $pendaftar = Magang::with('user')->latest()->get();
        return view('admin.dashboard', compact('pendaftar'));
    }

    // Detail Pendaftar (Lihat PDF Surat Kampus)
    public function show($id)
    {
        $magang = Magang::with('user')->findOrFail($id);
        return view('admin.show', compact('magang'));
    }

    // Approve Pendaftaran Awal
    public function approve($id)
    {
        $magang = Magang::findOrFail($id);
        $magang->update(['status' => 'approved']);
        return back()->with('success', 'Mahasiswa berhasil diterima.');
    }

    // Reject Pendaftaran Awal
    public function reject($id)
    {
        $magang = Magang::findOrFail($id);
        $magang->update(['status' => 'rejected']);
        return back()->with('success', 'Pendaftaran ditolak.');
    }

    // Halaman Monitoring (List Mahasiswa Aktif)
    public function monitoring()
    {
        $mahasiswas = Magang::with('user')->where('status', 'approved')->get();
        return view('admin.monitoring', compact('mahasiswas'));
    }

    // ==========================================
    // DETAIL MONITORING (LOGBOOK & VALIDASI MINGGUAN)
    // ==========================================
    public function detailMahasiswa($id)
    {
        $magang = Magang::with('user')->findOrFail($id);

        // --- 1. LOGIKA MINGGU (DISAMAKAN DENGAN MAHASISWA) ---
        $startMagang = Carbon::parse($magang->tanggal_mulai);
        $now = Carbon::now();

        // Hitung minggu berjalan
        $mingguBerjalan = (int) $startMagang->diffInWeeks($now) + 1;
        
        // Jika belum mulai atau masih baru, set minggu 1
        if ($now->lt($startMagang) || $mingguBerjalan < 1) {
            $mingguBerjalan = 1;
        }

        // Admin memantau minggu yang sedang berjalan
        $targetMinggu = $mingguBerjalan; 

        // Hitung tanggal untuk minggu tersebut
        $tglAwal = $startMagang->copy()->addWeeks($targetMinggu - 1)->startOfWeek(); 
        $tglAkhir = $startMagang->copy()->addWeeks($targetMinggu - 1)->endOfWeek()->subDays(2); // Jumat

        // Ambil atau Buat Data Laporan Mingguan
        $laporanMingguan = LaporanMingguan::firstOrCreate(
            [
                'magang_id' => $magang->id,
                'minggu_ke' => $targetMinggu
            ],
            [
                'tgl_awal_minggu' => $tglAwal->format('Y-m-d'),
                'tgl_akhir_minggu' => $tglAkhir->format('Y-m-d'),
                'status' => 'pending'
            ]
        );

        // --- 2. AMBIL DATA PENDUKUNG ---
        $logs = Logbook::where('user_id', $magang->user_id)
                        ->orderBy('tanggal', 'desc')
                        ->get();

        $presences = Presence::where('user_id', $magang->user_id)
                            ->orderBy('tanggal', 'desc')
                            ->get();

        return view('admin.detail-mahasiswa', compact('magang', 'logs', 'presences', 'laporanMingguan'));
    }

    // Approve Laporan Mingguan
    public function approveMingguan($id)
    {
        $laporan = LaporanMingguan::findOrFail($id);
        $laporan->update(['status' => 'disetujui']);
        return back()->with('success', 'Laporan mingguan disetujui.');
    }

    // Reject Laporan Mingguan
    public function rejectMingguan($id)
    {
        $laporan = LaporanMingguan::findOrFail($id);
        $laporan->update(['status' => 'ditolak']);
        return back()->with('success', 'Laporan mingguan ditolak.');
    }

    // Update Status Manual (Legacy)
    public function updateStatus(Request $request, $id, $status)
    {
        $magang = Magang::findOrFail($id);
        $magang->update(['status' => $status]);
        return back()->with('success', 'Status berhasil diperbarui.');
    }
}