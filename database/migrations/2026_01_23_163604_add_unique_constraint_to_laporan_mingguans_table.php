<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laporan_mingguans', function (Blueprint $table) {
            // Membuat kombinasi magang_id dan minggu_ke menjadi unik
            // Artinya: Mahasiswa A tidak bisa punya dua data untuk "Minggu #1"
            $table->unique(['magang_id', 'minggu_ke']);
        });
    }

    public function down(): void
    {
        Schema::table('laporan_mingguans', function (Blueprint $table) {
            $table->dropUnique(['magang_id', 'minggu_ke']);
        });
    }
};