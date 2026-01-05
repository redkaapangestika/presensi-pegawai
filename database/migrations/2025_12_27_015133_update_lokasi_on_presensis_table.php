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
            $table->string('lokasi_in')->nullable()->after('foto_in');
            $table->string('lokasi_out')->nullable()->after('foto_out');

            $table->dropColumn('location');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presensis', function (Blueprint $table) {
            $table->string('location')->nullable();

            $table->dropColumn(['lokasi_in', 'lokasi_out']);
        });
    }
};
