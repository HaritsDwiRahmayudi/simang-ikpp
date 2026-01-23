<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Magang extends Model
{
    use HasFactory;

    protected $table = 'magangs'; // Pastikan nama tabel benar

    // Tambahkan 'status_laporan' agar bisa di-update
    protected $fillable = [
        'user_id',
        'nim',
        'universitas',
        'jurusan',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',           // Status pendaftaran (pending/approved/rejected)
        'status_laporan',   // Status laporan akhir (diterima/ditolak)
        'surat_balasan',    // Surat balasan dari instansi
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}