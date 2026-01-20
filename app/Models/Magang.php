<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Magang extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * (Kolom-kolom ini wajib didaftarkan agar bisa disimpan lewat Form)
     */
    protected $fillable = [
        'user_id',          // ID User yang login
        'nim',              // Nomor Induk Mahasiswa
        'universitas',      // Asal Kampus
        'jurusan',          // Jurusan
        'tanggal_mulai',    // Rencana mulai
        'tanggal_selesai',  // Rencana selesai
        'status',           // Status (pending/approved/rejected)
    ];

    /**
     * Relasi ke Tabel User
     * (Satu data pendaftaran magang, dimiliki oleh satu User)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}