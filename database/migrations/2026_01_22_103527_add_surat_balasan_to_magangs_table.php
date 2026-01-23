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
    Schema::table('magangs', function (Blueprint $table) {
        // Menambah kolom surat_balasan setelah tanggal_selesai
        $table->string('surat_balasan')->nullable()->after('tanggal_selesai');
    });
}

public function down()
{
    Schema::table('magangs', function (Blueprint $table) {
        $table->dropColumn('surat_balasan');
    });
}
};
