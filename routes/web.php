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

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Jalur URL untuk aplikasi Simang IKPP.
| Pastikan menjalankan 'php artisan route:clear' setelah mengubah file ini.
|
*/

// ==========================================
// 1. ROUTE PUBLIC (BISA DIAKSES TANPA LOGIN)
// ==========================================

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tentang-kami', function () {
    return view('about');
})->name('about');


// ==========================================
// 2. ROUTE SETELAH LOGIN (AUTH & VERIFIED)
// ==========================================
Route::middleware(['auth', 'verified'])->group(function () {

    // ------------------------------------------
    // A. AREA ADMIN (Role: Admin)
    // ------------------------------------------
    Route::middleware('role:admin')->group(function () {
        
        // Dashboard Admin
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        
        // Detail Pendaftar (Lihat Surat Kampus)
        Route::get('/admin/pendaftar/{id}', [AdminController::class, 'show'])->name('admin.show');

        // AKSI TERIMA / TOLAK PENDAFTARAN (PENTING: Method PATCH)
        Route::patch('/magang/{id}/approve', [AdminController::class, 'approve'])->name('magang.approve');
        Route::patch('/magang/{id}/reject', [AdminController::class, 'reject'])->name('magang.reject');

        // Aksi Update Status Manual (Opsional)
        Route::patch('/admin/magang/{id}/{status}', [AdminController::class, 'updateStatus'])->name('admin.status.update');

        // Monitoring Mahasiswa Aktif
        Route::get('/admin/monitoring', [AdminController::class, 'monitoring'])->name('admin.monitoring');
        
        // Detail Monitoring (Logbook + Validasi Laporan Mingguan)
        Route::get('/admin/monitoring/{id}', [AdminController::class, 'detailMahasiswa'])->name('admin.monitoring.detail');

        // VALIDASI LAPORAN MINGGUAN (Approve/Reject PDF)
        Route::patch('/admin/mingguan/{id}/approve', [AdminController::class, 'approveMingguan'])->name('admin.mingguan.approve');
        Route::patch('/admin/mingguan/{id}/reject', [AdminController::class, 'rejectMingguan'])->name('admin.mingguan.reject');

    });


    // ------------------------------------------
    // B. AREA MAHASISWA (Role: Mahasiswa)
    // ------------------------------------------
    Route::middleware('role:mahasiswa')->group(function () {
        
        // Dashboard Mahasiswa
        Route::get('/dashboard', function () {
            // Ambil data magang user yang sedang login untuk ditampilkan di dashboard
            $magang = Magang::where('user_id', Auth::id())->first();
            return view('dashboard', compact('magang'));
        })->name('dashboard');

        // Form Pendaftaran Magang
        Route::get('/daftar-magang', [MagangController::class, 'create'])->name('magang.create');
        Route::post('/daftar-magang', [MagangController::class, 'store'])->name('magang.store');
        
        // Modul Logbook (Otomatis: index, create, store, edit, update, destroy)
        Route::resource('logbook', LogbookController::class);
        
        // Modul Absensi
        Route::get('/absensi', [PresenceController::class, 'index'])->name('presence.index');
        Route::post('/absensi/masuk', [PresenceController::class, 'checkIn'])->name('presence.checkin');
        Route::patch('/absensi/keluar', [PresenceController::class, 'checkOut'])->name('presence.checkout');

        // Modul Laporan Mingguan (Upload PDF)
        Route::get('/laporan-mingguan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::post('/laporan-mingguan', [LaporanController::class, 'upload'])->name('laporan.upload');

        // Cetak Jurnal (PDF)
        Route::get('/laporan/cetak', [LaporanController::class, 'downloadPdf'])->name('laporan.cetak');
    });


    // ------------------------------------------
    // C. PENGATURAN PROFIL (Bawaan Breeze)
    // ------------------------------------------
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';