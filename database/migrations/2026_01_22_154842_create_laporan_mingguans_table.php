<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('laporan_mingguans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('magang_id')->constrained('magangs')->onDelete('cascade');
        $table->integer('minggu_ke'); // Penanda Minggu ke-1, 2, dst
        $table->date('tgl_awal_minggu'); 
        $table->date('tgl_akhir_minggu'); 
        $table->string('file_pdf')->nullable(); // File PDF per minggu
        $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('laporan_mingguans');
}
};
