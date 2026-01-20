<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('magangs', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel User (Mahasiswa)
            // onDelete('cascade') artinya jika akun user dihapus, data magangnya ikut terhapus
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Data Diri & Akademik
            $table->string('nim');
            $table->string('universitas');
            $table->string('jurusan');
            
            // Data Waktu Magang
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            
            // Status Pengajuan (Default: pending)
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('magangs');
    }
};