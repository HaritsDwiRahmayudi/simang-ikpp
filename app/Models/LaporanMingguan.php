<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanMingguan extends Model
{
    use HasFactory;

    // GANTI $fillable DENGAN $guarded
    // $guarded = [] artinya: "Tidak ada kolom yang dilarang diisi".
    // Ini solusi paling ampuh agar tidak error saat nama kolom berubah-ubah.
    protected $guarded = [];

    public function magang()
    {
        return $this->belongsTo(Magang::class);
    }
}