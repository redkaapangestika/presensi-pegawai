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
        if (Schema::hasColumn('pegawais', 'foto')) {
            Schema::table('pegawais', function (Blueprint $table) {
                $table->string('foto')->nullable()->change();
            });
        } else {
            Schema::table('pegawais', function (Blueprint $table) {
                $table->string('foto')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            $table->string('foto')->nullable(false)->change();
        });
    }
};
