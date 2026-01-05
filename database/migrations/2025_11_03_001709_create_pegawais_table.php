<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pegawais', function (Blueprint $table) {
            $table->char('id_pegawai', 5)->primary();
            $table->string('nama_lengkap', 100);
            $table->string('jabatan', 20);
            $table->string('no_hp', 13);
            $table->string('password', 10);
            $table->string('remember_token', 255)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
