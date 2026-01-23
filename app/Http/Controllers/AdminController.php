<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Magang;
use App\Models\Logbook;
use App\Models\Presence;
use App\Models\LaporanMingguan;
use Carbon\Carbon;

class AdminController extends Controller
{
    // ==========================================
    // 1. DASHBOARD & PENDAFTARAN (Status Awal)
    // ==========================================

    public function index()
    {
        $pendaftar = Magang::with('user')->latest()->get();
        return view('admin.dashboard', compact('pendaftar'));
    }

    // Membuka halaman detail pendaftar (lihat PDF surat balasan)
    public function show($id)
    {
        $magang = Magang::with('user')->findOrFail($id);
        return view('admin.show', compact('magang'));
    }

    // Aksi Terima Pendaftaran
    public function approve($id)
    {
        return $this->updateStatus($id, 'approved');
    }

    // Aksi Tolak Pendaftaran
    public function reject($id)
    {
        return $this->updateStatus($id, 'rejected');
    }

    // Helper Update Status
    public function updateStatus($id, $status)
    {
        $magang = Magang::findOrFail($id);
        if (in_array($status, ['approved', 'rejected'])) {
            $magang->status = $status;
            $magang->save();
            return redirect()->route('admin.dashboard')->with('success', 'Status pendaftaran berhasil diperbarui!');
        }
        return redirect()->back()->with('error', 'Status tidak valid!');
    }


    // ==========================================
    // 2. MONITORING & DETAIL MAHASISWA
    // ==========================================

    // List Mahasiswa Aktif
    public function monitoring()
    {
        $mahasiswas = Magang::with('user')->where('status', 'approved')->get();
        return view('admin.monitoring', compact('mahasiswas'));
    }

    // Detail Mahasiswa + Logika Hitung Minggu Otomatis
    public function detailMahasiswa($id)
    {
        $magang = Magang::with('user')->findOrFail($id);
        
        // Ambil Logbook & Absensi
        $logs = Logbook::where('user_id', $magang->user_id)->latest()->get();
        $presences = Presence::where('user_id', $magang->user_id)->latest()->get();

        // --- LOGIKA MINGGUAN OTOMATIS ---
        $startMagang = Carbon::parse($magang->tanggal_mulai);
        $now = Carbon::now();
        
        // PERBAIKAN 1: Tambahkan (int) agar angka bulat (misal 2.5 jadi 2)
        // Ini mencegah error data tidak sinkron dengan mahasiswa
        $mingguBerjalan = (int) $startMagang->diffInWeeks($now) + 1;
        
        // Handle jika belum mulai (tanggal mulai di masa depan)
        if ($mingguBerjalan < 1) $mingguBerjalan = 1;

        // TARGET VALIDASI:
        // Biasanya admin memvalidasi minggu yang BARU SAJA LEWAT.
        // Jadi jika sekarang Minggu ke-2, kita validasi laporan Minggu ke-1.
        $targetValidasi = ($mingguBerjalan > 1) ? $mingguBerjalan - 1 : 1;

        // Hitung Tanggal Awal (Senin) & Akhir (Jumat) untuk Target Minggu Tersebut
        // startOfWeek() defaultnya Senin di Laravel/Carbon
        $tglAwal = $startMagang->copy()->addWeeks($targetValidasi - 1)->startOfWeek(); 
        $tglAkhir = $startMagang->copy()->addWeeks($targetValidasi - 1)->endOfWeek()->subDays(2); // Jumat

        // Cari atau Buat Slot Validasi di Database
        // Ini memastikan 'Card' validasi muncul di halaman detail
        $laporanMingguan = LaporanMingguan::firstOrCreate(
            [
                'magang_id' => $magang->id,
                'minggu_ke' => $targetValidasi
            ],
            [
                'tgl_awal_minggu' => $tglAwal->format('Y-m-d'),
                'tgl_akhir_minggu' => $tglAkhir->format('Y-m-d'),
                'status' => 'pending' // Default pending
            ]
        );

        return view('admin.detail-mahasiswa', compact('magang', 'logs', 'presences', 'laporanMingguan'));
    }


    // ==========================================
    // 3. PROSES VALIDASI MINGGUAN (BARU)
    // ==========================================

    // TERIMA: Status 'disetujui' & Absensi Full 'hadir'
    public function approveMingguan(Request $request, $id)
    {
        $laporan = LaporanMingguan::findOrFail($id);
        
        // 1. Update Status Laporan
        $laporan->update(['status' => 'disetujui']);

        // 2. Isi Absensi Otomatis (Senin - Jumat) -> HADIR
        $startDate = Carbon::parse($laporan->tgl_awal_minggu);
        $endDate = Carbon::parse($laporan->tgl_akhir_minggu);

        // Loop per hari
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            Presence::updateOrCreate(
                [
                    'user_id' => $laporan->magang->user_id,
                    'tanggal' => $date->format('Y-m-d')
                ],
                [
                    'jam_masuk' => '08:00:00', // Default jam masuk
                    'jam_keluar' => '17:00:00', // Default jam keluar
                    'status' => 'hadir'
                ]
            );
        }

        return back()->with('success', "Laporan Minggu ke-{$laporan->minggu_ke} DISETUJUI. Absensi minggu ini otomatis dianggap HADIR.");
    }

    // TOLAK: Status 'ditolak' & Absensi Full 'alpa'
    public function rejectMingguan(Request $request, $id)
    {
        $laporan = LaporanMingguan::findOrFail($id);

        // 1. Update Status Laporan
        $laporan->update(['status' => 'ditolak']);

        // 2. Isi Absensi Otomatis (Senin - Jumat) -> ALPA
        $startDate = Carbon::parse($laporan->tgl_awal_minggu);
        $endDate = Carbon::parse($laporan->tgl_akhir_minggu);

        // Loop per hari
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            Presence::updateOrCreate(
                [
                    'user_id' => $laporan->magang->user_id,
                    'tanggal' => $date->format('Y-m-d')
                ],
                [
                    // PERBAIKAN 2: Gunakan '00:00:00' bukan null
                    // Karena database Anda kolom jam_masuk bersifat NOT NULL.
                    'jam_masuk' => '00:00:00', 
                    'jam_keluar' => '00:00:00',
                    'status' => 'alpa'
                ]
            );
        }

        return back()->with('error', "Laporan Minggu ke-{$laporan->minggu_ke} DITOLAK. Mahasiswa dianggap ALPA (Tidak Hadir) selama seminggu.");
    }
}