<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Magang; 
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MagangController;
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\LaporanController;

Route::get('/', function () {
    return view('welcome');
});

// GROUP ROUTE SETELAH LOGIN
Route::middleware(['auth', 'verified'])->group(function () {

    // ==========================================
    // 1. AREA ADMIN (Khusus Role Admin)
    // ==========================================
    Route::middleware('role:admin')->group(function () {
        
        // Dashboard Admin (Tabel Pendaftar)
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        
        // Halaman Detail Pendaftar (Lihat PDF Surat Balasan)
        Route::get('/admin/pendaftar/{id}', [AdminController::class, 'show'])->name('admin.show');

        // AKSI TERIMA / TOLAK PENDAFTARAN AWAL
        Route::patch('/magang/{id}/approve', [AdminController::class, 'approve'])->name('magang.approve');
        Route::patch('/magang/{id}/reject', [AdminController::class, 'reject'])->name('magang.reject');

        // Aksi Update Status (Legacy/Cadangan)
        Route::patch('/admin/magang/{id}/{status}', [AdminController::class, 'updateStatus'])->name('admin.status.update');

        // MONITORING & DETAIL MAHASISWA
        Route::get('/admin/monitoring', [AdminController::class, 'monitoring'])->name('admin.monitoring');
        // Halaman Detail ini sekarang menghandle Logbook + Validasi Mingguan Otomatis
        Route::get('/admin/monitoring/{id}', [AdminController::class, 'detailMahasiswa'])->name('admin.monitoring.detail');

        // -----------------------------------------------------------
        // FITUR BARU: VALIDASI MINGGUAN OTOMATIS (Approve/Reject)
        // -----------------------------------------------------------
        Route::patch('/admin/mingguan/{id}/approve', [AdminController::class, 'approveMingguan'])->name('admin.mingguan.approve');
        Route::patch('/admin/mingguan/{id}/reject', [AdminController::class, 'rejectMingguan'])->name('admin.mingguan.reject');

    });

    // ==========================================
    // 2. AREA MAHASISWA (Role Mahasiswa)
    // ==========================================
    Route::middleware('role:mahasiswa')->group(function () {
        
        // Dashboard Mahasiswa
        Route::get('/dashboard', function () {
            $magang = Magang::where('user_id', Auth::id())->first();
            return view('dashboard', compact('magang'));
        })->name('dashboard');

        // Pendaftaran Magang
        Route::get('/daftar-magang', [MagangController::class, 'create'])->name('magang.create');
        Route::post('/daftar-magang', [MagangController::class, 'store'])->name('magang.store');
        
        // Logbook & Absensi
        Route::resource('logbook', LogbookController::class);
        
        Route::get('/absensi', [PresenceController::class, 'index'])->name('presence.index');
        Route::post('/absensi/masuk', [PresenceController::class, 'checkIn'])->name('presence.checkin');
        Route::patch('/absensi/keluar', [PresenceController::class, 'checkOut'])->name('presence.checkout');

        // -----------------------------------------------------------
        // FITUR BARU: UPLOAD LAPORAN MINGGUAN (PDF)
        // -----------------------------------------------------------
        Route::get('/laporan-mingguan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::post('/laporan-mingguan', [LaporanController::class, 'upload'])->name('laporan.upload');

        // Download Rekap Kegiatan (Fitur Lama - Tetap ada)
        Route::get('/laporan/cetak', [LaporanController::class, 'downloadPdf'])->name('laporan.cetak');
    });

    // ==========================================
    // PENGATURAN PROFIL
    // ==========================================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';