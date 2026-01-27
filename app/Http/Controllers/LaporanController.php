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
        // Mengambil data magang atau error jika tidak ditemukan
        $magang = Magang::where('user_id', $user->id)->firstOrFail();
        
        // --- LOGIKA HITUNG MINGGU OTOMATIS ---
        $startMagang = Carbon::parse($magang->tanggal_mulai);
        $now = Carbon::now();
        
        // Hitung minggu berjalan saat ini (Hari pertama masuk minggu ke-1)
        $mingguBerjalan = (int) $startMagang->diffInWeeks($now) + 1;
        
        // Proteksi jika tanggal sekarang < tanggal mulai magang
        if ($now->lt($startMagang)) {
            $mingguBerjalan = 1; 
        }

        $targetMinggu = $mingguBerjalan; 

        // Hitung rentang tanggal minggu tersebut (Senin - Minggu, lalu ambil Jumat untuk tgl_akhir)
        $tglAwal = $startMagang->copy()->addWeeks($targetMinggu - 1)->startOfWeek(Carbon::MONDAY); 
        $tglAkhir = $startMagang->copy()->addWeeks($targetMinggu - 1)->endOfWeek(Carbon::SUNDAY)->subDays(2); // Jatuh pada Jumat

        // Ambil data laporan mingguan atau buat otomatis jika belum ada
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

        // Ambil riwayat laporan dengan urutan terbaru di atas
        $laporans = LaporanMingguan::where('magang_id', $magang->id)
                    ->orderBy('minggu_ke', 'desc')
                    ->get();

        return view('mahasiswa.laporan.index', compact('magang', 'laporan', 'laporans'));
    }

    // ==========================================
    // 2. PROSES UPLOAD FILE PDF
    // ==========================================
   public function upload(Request $request)
    {
        // 1. Validasi Input (Naikkan limit jadi 5MB biar aman)
        $request->validate([
            'laporan_id' => 'required|exists:laporan_mingguans,id',
            'file_pdf' => 'required|mimes:pdf|max:5120', // Ubah ke 5120 (5MB)
        ]);

        try {
            // 2. Cari Data Laporan
            $laporan = LaporanMingguan::findOrFail($request->laporan_id);

            // 3. Proses Simpan File
            if ($request->hasFile('file_pdf')) {
                
                // Hapus file lama jika ada (biar sampah tidak numpuk)
                if ($laporan->file_pdf) {
                    Storage::delete('public/' . $laporan->file_pdf);
                }

                // Simpan file baru
                $path = $request->file('file_pdf')->store('laporan-mingguan', 'public');
                
                // 4. PAKSA UPDATE DATABASE (Solusi Ampuh)
                // Menggunakan forceFill() + save() akan menembus proteksi $fillable
                $laporan->forceFill([
                    'file_pdf' => $path,
                    'status'   => 'pending' 
                ])->save();
            }

            return back()->with('success', 'Laporan berhasil diupload! File sudah masuk database.');

        } catch (\Exception $e) {
            // Jika error, kita tahu kenapa
            return back()->with('error', 'Gagal menyimpan ke database: ' . $e->getMessage());
        }
    }

    // ==========================================
    // 3. GENERATE PDF (CETAK JURNAL)
    // ==========================================
    public function downloadPdf(Request $request)
    {
        $user = Auth::user();
        $magang = Magang::where('user_id', $user->id)->first();

        if (!$magang) {
            return redirect()->back()->with('error', 'Data magang tidak ditemukan.');
        }

        $startDate = $request->input('start_date');
        $endDate   = $request->input('end_date');

        // PERBAIKAN: Tambahkan with('user') agar relasi data mahasiswa terisi di PDF
        $logbookQuery = Logbook::with('user')->where('user_id', $user->id)->orderBy('tanggal', 'asc');
        
        if ($startDate && $endDate) {
            $logbookQuery->whereBetween('tanggal', [$startDate, $endDate]);
        }
        $logbooks = $logbookQuery->get();

        // PERBAIKAN: Tambahkan with('user') untuk data absensi
        $presenceQuery = Presence::with('user')->where('user_id', $user->id)->orderBy('tanggal', 'asc');

        if ($startDate && $endDate) {
            $presenceQuery->whereBetween('tanggal', [$startDate, $endDate]);
        }
        $presences = $presenceQuery->get();

        // Siapkan judul periode untuk header laporan
        $periode = 'Seluruh Kegiatan';
        if ($startDate && $endDate) {
            $periode = Carbon::parse($startDate)->format('d M Y') . ' - ' . Carbon::parse($endDate)->format('d M Y');
        }

        // Generate PDF menggunakan view template
        $pdf = Pdf::loadView('laporan.pdf_template', compact('magang', 'logbooks', 'presences', 'periode'));
        
        // Pengaturan kertas A4 Portrait
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('Jurnal_Kegiatan_' . str_replace(' ', '_', $user->name) . '.pdf');
    }
}