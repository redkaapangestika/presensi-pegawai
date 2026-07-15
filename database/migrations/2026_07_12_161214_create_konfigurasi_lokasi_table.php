<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('konfigurasi_lokasi', function (Blueprint $table) {
            $table->id();
            $table->string('titik_koordinat');
            $table->integer('radius_meter');
            $table->timestamps();
        });

        // Insert default location (Condongcatur)
        DB::table('konfigurasi_lokasi')->insert([
            'titik_koordinat' => '-7.7597148,110.3957252',
            'radius_meter' => 100,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konfigurasi_lokasi');
    }
};
