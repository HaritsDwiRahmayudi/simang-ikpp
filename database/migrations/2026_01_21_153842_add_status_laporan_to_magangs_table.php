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
    Schema::table('magangs', function (Blueprint $table) {
        // Default 'pending' artinya belum diperiksa
        $table->string('status_laporan')->default('pending')->after('status'); 
    });
}

public function down(): void
{
    Schema::table('magangs', function (Blueprint $table) {
        $table->dropColumn('status_laporan');
    });
}
};
