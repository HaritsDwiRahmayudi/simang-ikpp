<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    use HasFactory;

    /**
     * $fillable berfungsi untuk keamanan (Mass Assignment).
     * Hanya kolom yang terdaftar di sini yang boleh diisi lewat Formulir.
     */
    protected $fillable = [
        'user_id',          // ID Mahasiswa
        'tanggal',          // Tanggal Kegiatan
        'kegiatan',         // Isi Laporan
        'nama_koordinator', // Nama Pembimbing Lapangan
        'lokasi',           // Lokasi Kerja (Workshop/Kantor)
        'ttd_koordinator',  // Gambar Tanda Tangan (Format Base64)
        'status_paraf',     // Status Validasi (Opsional)
    ];

    /**
     * Relasi: Setiap Logbook dimiliki oleh satu User (Mahasiswa)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}