<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('presensis', function (Blueprint $table) {
            $table->increments('id_presensi');
            $table->char('id_pegawai', 5);
            $table->date('tgl_presensi');
            $table->time('jam_in');
            $table->time('jam_out');
            $table->string('foto_in', 255);
            $table->string('foto_out', 255);
            $table->text('location');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presensis');
    }
};
