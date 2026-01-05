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
        Schema::table('presensis', function (Blueprint $table) {
            $table->time('jam_out')->nullable()->change();
            $table->string('foto_out')->nullable()->change();
            $table->string('lokasi_out')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presensis', function (Blueprint $table) {
            $table->time('jam_out')->nullable(false)->change();
            $table->string('foto_out')->nullable(false)->change();
            $table->string('lokasi_out')->nullable(false)->change();
        });
    }
};
