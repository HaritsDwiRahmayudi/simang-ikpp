<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Magang extends Model
{
    use HasFactory;

    protected $table = 'magangs';

    // KITA BALIKAN KE FILLABLE (SAFETY FIRST)
    protected $fillable = [
        'user_id',
        'nim',
        'universitas',
        'jurusan',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',          
        'status_laporan',  
        'surat_balasan',   
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // WAJIB ADA INI BIAR ADMIN GAK ERROR 500
    public function laporanMingguans()
    {
        return $this->hasMany(LaporanMingguan::class, 'magang_id');
    }
}