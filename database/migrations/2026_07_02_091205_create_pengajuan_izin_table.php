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
        Schema::create('pengajuan_izin', function (Blueprint $table) {
                        $table->increments('id');
            $table->char('id_pegawai',5);
            $table->date('tgl_izin');
            $table->char('status',1)->comment('i = izin, s = sakit');
            $table->string('keterangan',255);
            $table->char('status_approved',1)
                  ->default('0')
                  ->comment('0 = pending, 1 = disetujui, 2 = ditolak');
            $table->timestamps();

            // Relasi ke tabel pegawais
            $table->foreign('id_pegawai')
                  ->references('id_pegawai')
                  ->on('pegawais')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_izin');
    }
};
