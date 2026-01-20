<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // Tambahkan ini
use App\Models\Magang; // Tambahkan ini

Route::get('/', function () {
    return view('welcome');
});

// GROUP ROUTE SETELAH LOGIN
Route::middleware('auth')->group(function () {

    // 1. AREA ADMIN (Role Admin)
    Route::middleware('role:admin')->group(function () {
        
        // HAPUS KODE LAMA ANDA, GANTI DENGAN 2 BARIS INI:

        // 1. Route Dashboard: Mengarah ke Controller 'index' (Untuk menampilkan Tabel)
        Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
        
        // 2. Route Aksi: Mengarah ke Controller 'updateStatus' (Untuk tombol Terima/Tolak)
        Route::patch('/admin/magang/{id}/{status}', [App\Http\Controllers\AdminController::class, 'updateStatus'])->name('admin.status.update');

    });

    // 2. AREA MAHASISWA (Role Mahasiswa + Wajib Verified Email)
    Route::middleware(['role:mahasiswa', 'verified'])->group(function () {
        
        // --- BAGIAN INI YANG ANDA TANYAKAN (SUDAH DIUPDATE) ---
        
        // Dashboard Pintar (Kirim data status magang ke view)
        Route::get('/dashboard', function () {
            $magang = Magang::where('user_id', Auth::id())->first();
            return view('dashboard', compact('magang'));
        })->name('dashboard');

        // Route Form Magang
        Route::get('/daftar-magang', [App\Http\Controllers\MagangController::class, 'create'])->name('magang.create');
        Route::post('/daftar-magang', [App\Http\Controllers\MagangController::class, 'store'])->name('magang.store');
        
        // -----------------------------------------------------
    });

    // Profile Settings (Bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';