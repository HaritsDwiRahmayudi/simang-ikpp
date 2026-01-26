<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Magang;
use App\Models\LaporanMingguan;
use App\Models\Logbook;
use App\Models\Presence;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    // ==========================================
    // 1. HALAMAN UTAMA (UPLOAD & STATUS)
    // ==========================================
    public function index()
    {
        $user = Auth::user();
        $magang = Magang::where('user_id', $user->id)->firstOrFail();
        
        // --- LOGIKA HITUNG MINGGU OTOMATIS ---
        $startMagang = Carbon::parse($magang->tanggal_mulai);
        $now = Carbon::now();
        
        // Hitung minggu berjalan saat ini
        // Menggunakan diffInWeeks dan ditambah 1 agar hari pertama dihitung minggu ke-1
        $mingguBerjalan = (int) $startMagang->diffInWeeks($now) + 1;
        
        // Jika belum mulai magang (tanggal sekarang < tanggal mulai), set minggu ke 1
        if ($now->lt($startMagang)) {
            $mingguBerjalan = 1; 
        }

        // Tentukan Target Minggu yang harus diupload
        $targetMinggu = $mingguBerjalan; 

        // Hitung Tanggal Awal (Senin) & Akhir (Jumat) Minggu Tersebut
        // startOfWeek(Carbon::MONDAY) memastikan minggu dimulai hari Senin
        $tglAwal = $startMagang->copy()->addWeeks($targetMinggu - 1)->startOfWeek(Carbon::MONDAY); 
        $tglAkhir = $startMagang->copy()->addWeeks($targetMinggu - 1)->endOfWeek(Carbon::SUNDAY)->subDays(2); // Jumat (Minggu - 2 hari)

        // 1. CARI ATAU BUAT RECORD (Hanya 1 per minggu)
        // firstOrCreate mengecek apakah data untuk minggu ini sudah ada?
        // Jika ADA: Ambil datanya (tidak buat baru).
        // Jika TIDAK ADA: Buat data baru dengan status 'pending'.
        $laporan = LaporanMingguan::firstOrCreate(
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

        // 2. Ambil SEMUA riwayat laporan (untuk tabel history di bawah)
        $laporans = LaporanMingguan::where('magang_id', $magang->id)
                    ->orderBy('minggu_ke', 'desc')
                    ->get();

        // Kirim variabel ke View
        return view('mahasiswa.laporan.index', compact('magang', 'laporan', 'laporans'));
    }

    // ==========================================
    // 2. PROSES UPLOAD FILE PDF
    // ==========================================
    public function upload(Request $request)
    {
        $request->validate([
            'laporan_id' => 'required|exists:laporan_mingguans,id',
            'file_pdf' => 'required|mimes:pdf|max:2048', // Wajib PDF, Max 2MB
        ]);

        // Ambil data yang SUDAH ADA berdasarkan ID (jangan buat baru)
        $laporan = LaporanMingguan::findOrFail($request->laporan_id);

        if ($request->hasFile('file_pdf')) {
            
            // Hapus file lama jika ada (untuk menghemat penyimpanan server)
            if ($laporan->file_pdf) {
                Storage::delete('public/' . $laporan->file_pdf);
            }

            // Simpan file baru ke folder 'storage/app/public/laporan-mingguan'
            $path = $request->file('file_pdf')->store('laporan-mingguan', 'public');
            
            // UPDATE record yang sama
            $laporan->update([
                'file_pdf' => $path,
                // Jika status sebelumnya ditolak, ubah jadi pending lagi agar admin cek ulang
                // Jika belum diperiksa, tetap pending
                'status' => 'pending' 
            ]);
        }

        return back()->with('success', 'Laporan mingguan berhasil diupload! Menunggu verifikasi admin.');
    }

    // ==========================================
    // 3. GENERATE PDF (CETAK JURNAL)
    // ==========================================
    public function downloadPdf(Request $request)
    {
        $user = Auth::user();
        
        // 1. Cek apakah User punya data Magang
        $magang = Magang::where('user_id', $user->id)->first();

        if (!$magang) {
            return redirect()->back()->with('error', 'Data magang tidak ditemukan.');
        }

        // 2. Ambil Input Tanggal (Filter Mingguan)
        $startDate = $request->input('start_date');
        $endDate   = $request->input('end_date');

        // 3. Query Logbook (Filter Tanggal jika ada input)
        $logbookQuery = Logbook::where('user_id', $user->id)->orderBy('tanggal', 'asc');
        
        if ($startDate && $endDate) {
            $logbookQuery->whereBetween('tanggal', [$startDate, $endDate]);
        }
        $logbooks = $logbookQuery->get();

        // 4. Query Absensi (Filter Tanggal jika ada input)
        $presenceQuery = Presence::where('user_id', $user->id)->orderBy('tanggal', 'asc');

        if ($startDate && $endDate) {
            $presenceQuery->whereBetween('tanggal', [$startDate, $endDate]);
        }
        $presences = $presenceQuery->get();

        // 5. Siapkan Judul Periode
        $periode = 'Seluruh Kegiatan';
        if ($startDate && $endDate) {
            $periode = Carbon::parse($startDate)->format('d M Y') . ' - ' . Carbon::parse($endDate)->format('d M Y');
        }

        // 6. Generate PDF menggunakan View
        $pdf = Pdf::loadView('laporan.pdf_template', compact('magang', 'logbooks', 'presences', 'periode'));
        
        // Set ukuran kertas (A4 Portrait)
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('Jurnal_Kegiatan_' . str_replace(' ', '_', $user->name) . '.pdf');
    }
}