<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            // Perlebar kolom agar cukup menampung data asli
            $table->string('id_pegawai', 10)->change();
            $table->string('nama_lengkap', 150)->change();
            $table->string('jabatan', 60)->change();
            $table->string('no_hp', 20)->nullable()->change();
            $table->string('password', 255)->change();
        });
    }

    public function down(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            $table->char('id_pegawai', 5)->change();
            $table->string('nama_lengkap', 100)->change();
            $table->string('jabatan', 20)->change();
            $table->string('no_hp', 13)->change();
            $table->string('password', 10)->change();
        });
    }
};
