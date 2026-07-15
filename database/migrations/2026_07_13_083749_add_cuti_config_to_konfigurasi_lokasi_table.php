<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('konfigurasi_lokasi', function (Blueprint $table) {
            $table->integer('kuota_cuti_tahunan')->default(12)->after('radius_meter');
            $table->integer('kuorum_cuti_harian')->default(3)->after('kuota_cuti_tahunan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('konfigurasi_lokasi', function (Blueprint $table) {
            $table->dropColumn('kuota_cuti_tahunan');
            $table->dropColumn('kuorum_cuti_harian');
        });
    }
};
