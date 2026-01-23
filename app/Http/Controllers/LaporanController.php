<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Magang;
use App\Models\LaporanMingguan; // Model Baru
use App\Models\Logbook;         // Untuk PDF
use App\Models\Presence;        // Untuk PDF
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
        
        // --- LOGIKA HITUNG MINGGU OTOMATIS (SAMA DENGAN ADMIN) ---
        $startMagang = Carbon::parse($magang->tanggal_mulai);
        $now = Carbon::now();
        
        // Hitung minggu berjalan saat ini
        $mingguBerjalan = (int) $startMagang->diffInWeeks($now) + 1;
        
        if ($mingguBerjalan < 1) $mingguBerjalan = 1;

        // TARGET VALIDASI:
        // Logikanya: Kita mengupload laporan untuk minggu yang SUDAH LEWAT atau SEDANG BERJALAN.
        // Jika sekarang Minggu ke-2, berarti target upload adalah Minggu ke-1 (atau Minggu ke-2 tergantung kebijakan).
        // Disini saya set default: Target adalah (Minggu Berjalan - 1) agar sinkron dengan Admin.
        // Kecuali jika baru minggu pertama.
        
        $targetMinggu = ($mingguBerjalan > 1) ? $mingguBerjalan - 1 : 1;

        // Hitung Tanggal Awal (Senin) & Akhir (Jumat) Minggu Tersebut
        $tglAwal = $startMagang->copy()->addWeeks($targetMinggu - 1)->startOfWeek(); 
        $tglAkhir = $startMagang->copy()->addWeeks($targetMinggu - 1)->endOfWeek()->subDays(2); // Jumat

        // Cari data di database (atau buat slot baru jika belum ada)
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

        return view('mahasiswa.laporan.index', compact('magang', 'laporan'));
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

        $laporan = LaporanMingguan::findOrFail($request->laporan_id);

        // Cek jika ada file
        if ($request->hasFile('file_pdf')) {
            
            // Hapus file lama jika ada (untuk menghemat penyimpanan)
            if ($laporan->file_pdf) {
                Storage::delete('public/' . $laporan->file_pdf);
            }

            // Simpan file baru ke folder 'storage/app/public/laporan-mingguan'
            $path = $request->file('file_pdf')->store('laporan-mingguan', 'public');
            
            // Update Database
            $laporan->update([
                'file_pdf' => $path,
                // Jika status sebelumnya ditolak, ubah jadi pending lagi agar admin cek ulang
                // Jika status sudah disetujui, biarkan (atau bisa diubah logicnya sesuai kebutuhan)
                'status' => ($laporan->status == 'ditolak') ? 'pending' : $laporan->status 
            ]);
        }

        return back()->with('success', 'Laporan mingguan berhasil diupload!');
    }

    // ==========================================
    // 3. GENERATE PDF (Fitur Lama Anda)
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
            $periode = \Carbon\Carbon::parse($startDate)->format('d M Y') . ' - ' . \Carbon\Carbon::parse($endDate)->format('d M Y');
        }

        // 6. Generate PDF
        $pdf = Pdf::loadView('laporan.pdf_template', compact('magang', 'logbooks', 'presences', 'periode'));
        
        // Set ukuran kertas (A4 Portrait)
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('Laporan_Mingguan_' . $user->name . '.pdf');
    }
}