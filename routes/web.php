<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Magang; 

Route::get('/', function () {
    return view('welcome');
});

// GROUP ROUTE SETELAH LOGIN
Route::middleware('auth')->group(function () {

    // ==========================================
    // 1. AREA ADMIN (Khusus Role Admin)
    // ==========================================
    Route::middleware('role:admin')->group(function () {
        
        // Dashboard Admin (Tabel Pendaftar)
        Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
        
        // Aksi Terima/Tolak Magang
        Route::patch('/admin/magang/{id}/{status}', [App\Http\Controllers\AdminController::class, 'updateStatus'])->name('admin.status.update');

        // Route Monitoring Baru
    Route::get('/admin/monitoring', [App\Http\Controllers\AdminController::class, 'monitoring'])->name('admin.monitoring');
    Route::get('/admin/monitoring/{id}', [App\Http\Controllers\AdminController::class, 'detailMahasiswa'])->name('admin.monitoring.detail');
    Route::patch('/admin/laporan/{id}/approve', [App\Http\Controllers\AdminController::class, 'approveLaporan'])->name('admin.laporan.approve');

    });

  // 2. AREA MAHASISWA (Role Mahasiswa + Wajib Verified Email)
    Route::middleware(['role:mahasiswa', 'verified'])->group(function () {
        
        // Dashboard
        Route::get('/dashboard', function () {
            $magang = Magang::where('user_id', Auth::id())->first();
            return view('dashboard', compact('magang'));
        })->name('dashboard');

        // Pendaftaran Magang
        Route::get('/daftar-magang', [App\Http\Controllers\MagangController::class, 'create'])->name('magang.create');
        Route::post('/daftar-magang', [App\Http\Controllers\MagangController::class, 'store'])->name('magang.store');
        
        // --- TAMBAHKAN BARIS INI AGAR LOGBOOK BISA DIBUKA ---
        Route::resource('logbook', App\Http\Controllers\LogbookController::class);

        // --- TAMBAHKAN BARIS INI JUGA UNTUK ABSENSI (JIKA SUDAH SIAP) ---
        Route::get('/absensi', [App\Http\Controllers\PresenceController::class, 'index'])->name('presence.index');
        Route::post('/absensi/masuk', [App\Http\Controllers\PresenceController::class, 'checkIn'])->name('presence.checkin');
        Route::patch('/absensi/keluar', [App\Http\Controllers\PresenceController::class, 'checkOut'])->name('presence.checkout');

        // Route Download PDF
    Route::get('/laporan/cetak', [App\Http\Controllers\LaporanController::class, 'downloadPdf'])->name('laporan.cetak');
    });

    // ==========================================
    // PENGATURAN PROFIL (Bawaan Breeze)
    // ==========================================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';