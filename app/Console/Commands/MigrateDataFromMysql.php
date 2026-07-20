<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MigrateDataFromMysql extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrasi data dari MySQL (Laragon) ke Supabase (PostgreSQL) serta membuat akun dummy per entitas.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Memulai sinkronisasi data dari MySQL ke PostgreSQL...");

        // List table yang dimigrasi (hindari tabel sistem seperti migrations, cache, sessions)
        $tables = [
            'departemens',
            'pegawais',
            'users',
            'konfigurasi_lokasis',
            'pengajuan_izins',
            'presensis'
        ];

        foreach ($tables as $table) {
            $this->info("Menyalin tabel: $table");

            try {
                // Periksa apakah tabel eksis di source
                $existsInSource = DB::connection('mysql')->select("SHOW TABLES LIKE '$table'");
                if (empty($existsInSource)) {
                    $this->warn("Tabel $table tidak ditemukan di MySQL... melewatinya.");
                    continue;
                }

                $data = DB::connection('mysql')->table($table)->get();
                $this->info("Ditemukan " . $data->count() . " record.");

                // PostgreSQL reset table data terlebih dahulu
                DB::connection('pgsql')->table($table)->truncate();

                $chunks = $data->chunk(100);
                foreach ($chunks as $chunk) {
                    $insertData = [];
                    foreach ($chunk as $row) {
                        $insertData[] = (array) $row;
                    }
                    DB::connection('pgsql')->table($table)->insert($insertData);
                }

                $this->info("Selesai menyalin tabel $table.");
            } catch (\Exception $e) {
                $this->error("Gagal menyalin tabel $table: " . $e->getMessage());
            }
        }

        $this->info("--------------------------------------------------");
        $this->info("Membuat Akun Dummy Per Entitas...");

        $roles = [
            'admin' => 'Admin Role',
            'petugas' => 'Petugas Role',
            'lurah' => 'Lurah Role',
            'pegawai' => 'Pegawai Role'
        ];

        // Buat Akun Dummy Pegawai Terlebih Dahulu agar Foreign Key bisa berjalan
        $dummyPegawaiId = '99999';
        $dummyPegawaiExists = DB::connection('pgsql')->table('pegawais')->where('id_pegawai', $dummyPegawaiId)->exists();
        if (!$dummyPegawaiExists) {
            DB::connection('pgsql')->table('pegawais')->insert([
                'id_pegawai' => $dummyPegawaiId,
                'nama_lengkap' => 'Mr. Dummy Pegawai',
                'jabatan' => 'Staff',
                'no_hp' => '08123456789',
                'password' => 'dummy', // password plain (jika app pake hashing harusnya hashed)
            ]);
        }

        foreach ($roles as $role => $name) {
            $email = $role . '@dummy.com';
            $exists = DB::connection('pgsql')->table('users')->where('email', $email)->exists();
            if (!$exists) {
                DB::connection('pgsql')->table('users')->insert([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make('password123'),
                    'role' => $role,
                ]);
                $this->info("Dibuat akun dummy: $email | Password: password123 | Role: $role");
            } else {
                $this->warn("Akun dummy $email sudah eksis.");
            }
        }

        $this->info("--------------------------------------------------");
        $this->info("Migrasi Data & Akun Dummy Berhasil!");
    }
}
