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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->date('tanggal');
            $table->string('nama_koordinator');
            $table->string('lokasi');
            $table->text('kegiatan');
            
            // --- PERBAIKAN DISINI ---
            // Tambahkan ->nullable() agar kolom ini tidak wajib diisi
            $table->longText('ttd_koordinator')->nullable(); 
            
            $table->string('foto_kegiatan')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logbooks');
    }
};