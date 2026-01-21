<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('logbooks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke Mahasiswa
            
            $table->date('tanggal');
            $table->string('nama_koordinator'); // Nama Pembimbing
            $table->string('lokasi');           // Lokasi (Unit Kerja)
            $table->text('kegiatan');           // Isi Jurnal
            $table->longText('ttd_koordinator'); // Tanda Tangan Digital (Base64)
            $table->string('foto_kegiatan')->nullable(); // Upload Bukti Foto (Path File)
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logbooks');
    }
};