<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanMingguan extends Model
{
    use HasFactory;

    protected $table = 'laporan_mingguans';

    // KITA BALIKAN KE FILLABLE (SAFETY FIRST)
    // Pastikan 'file_pdf' ada disini!
    protected $fillable = [
        'magang_id',
        'minggu_ke',
        'tgl_awal_minggu',
        'tgl_akhir_minggu',
        'file_pdf',        // <--- INI KUNCINYA BANG
        'status',
    ];

    public function magang()
    {
        return $this->belongsTo(Magang::class);
    }
}