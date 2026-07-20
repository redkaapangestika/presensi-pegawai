<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RealDataSeeder extends Seeder
{
    public function run()
    {
        // =============================================
        // 1. Departemen / Urusan Kalurahan Condongcatur
        // =============================================
        DB::table('departemens')->truncate();
        DB::table('departemens')->insert([
            ['kode_dept' => 'LUR', 'nama_dept' => 'Lurah & Carik'],
            ['kode_dept' => 'JAG', 'nama_dept' => 'Jagabaya'],
            ['kode_dept' => 'ULU', 'nama_dept' => 'Ulu-Ulu'],
            ['kode_dept' => 'KAM', 'nama_dept' => 'Kamituwa'],
            ['kode_dept' => 'DAN', 'nama_dept' => 'Urusan Danarta'],
            ['kode_dept' => 'PAN', 'nama_dept' => 'Urusan Pangripta'],
            ['kode_dept' => 'TL', 'nama_dept' => 'Urusan Tata Laksana'],
        ]);

        // =============================================
        // 2. Data Pegawai Asli
        // =============================================
        DB::table('pegawais')->truncate();
        DB::table('pegawais')->insert([
            // --- Lurah & Carik ---
            ['id_pegawai' => 'L0001', 'nama_lengkap' => 'Dr. Reno Candra Sangaji, S.IP, M.IP', 'jabatan' => 'Lurah', 'no_hp' => '081328779478', 'kode_dept' => 'LUR', 'password' => Hash::make('1234'), 'foto' => null],
            ['id_pegawai' => 'C0001', 'nama_lengkap' => 'Riska Dian Nur Lestari, S.TP., M.Sc', 'jabatan' => 'Carik', 'no_hp' => '08112630656', 'kode_dept' => 'LUR', 'password' => Hash::make('1234'), 'foto' => null],
            ['id_pegawai' => 'C0002', 'nama_lengkap' => 'Warsana, S.H', 'jabatan' => 'Staf Carik', 'no_hp' => '081328205529', 'kode_dept' => 'LUR', 'password' => Hash::make('1234'), 'foto' => null],
            // --- Jagabaya ---
            ['id_pegawai' => 'J0001', 'nama_lengkap' => 'Rudi Antariksawan', 'jabatan' => 'Jagabaya', 'no_hp' => '085643431344', 'kode_dept' => 'JAG', 'password' => Hash::make('1234'), 'foto' => null],
            ['id_pegawai' => 'J0002', 'nama_lengkap' => 'Tri Susetyanto, S.IP.', 'jabatan' => 'Staf Jagabaya', 'no_hp' => '0888', 'kode_dept' => 'JAG', 'password' => Hash::make('1234'), 'foto' => null],
            ['id_pegawai' => 'J0003', 'nama_lengkap' => 'Heri Supriyono', 'jabatan' => 'Staf Jagabaya', 'no_hp' => '085228458275', 'kode_dept' => 'JAG', 'password' => Hash::make('1234'), 'foto' => null],
            // --- Ulu-Ulu ---
            ['id_pegawai' => 'U0001', 'nama_lengkap' => 'Murgiyanta, S.E', 'jabatan' => 'Ulu-Ulu', 'no_hp' => '081212498287', 'kode_dept' => 'ULU', 'password' => Hash::make('1234'), 'foto' => null],
            ['id_pegawai' => 'U0002', 'nama_lengkap' => 'Wanda Wira Sahputra, S.E', 'jabatan' => 'Staf Ulu-Ulu', 'no_hp' => null, 'kode_dept' => 'ULU', 'password' => Hash::make('1234'), 'foto' => null],
            ['id_pegawai' => 'U0003', 'nama_lengkap' => 'Heri Sunanta', 'jabatan' => 'Staf Ulu-Ulu', 'no_hp' => null, 'kode_dept' => 'ULU', 'password' => Hash::make('1234'), 'foto' => null],
            ['id_pegawai' => 'U0004', 'nama_lengkap' => 'Felicita Erma Sista, S.T', 'jabatan' => 'Staf Ulu-Ulu', 'no_hp' => null, 'kode_dept' => 'ULU', 'password' => Hash::make('1234'), 'foto' => null],
            // --- Kamituwa ---
            ['id_pegawai' => 'K0001', 'nama_lengkap' => 'Al Thouvik Sofisalun, Amd', 'jabatan' => 'Kamituwa', 'no_hp' => '08112534443', 'kode_dept' => 'KAM', 'password' => Hash::make('1234'), 'foto' => null],
            ['id_pegawai' => 'K0002', 'nama_lengkap' => 'Candra Widiantoro, A.Md', 'jabatan' => 'Staf Kamituwa', 'no_hp' => null, 'kode_dept' => 'KAM', 'password' => Hash::make('1234'), 'foto' => null],
            ['id_pegawai' => 'K0003', 'nama_lengkap' => 'Nur Amalina Dwi Astuti, S.Sl', 'jabatan' => 'Staf Kamituwa', 'no_hp' => null, 'kode_dept' => 'KAM', 'password' => Hash::make('1234'), 'foto' => null],
            ['id_pegawai' => 'K0004', 'nama_lengkap' => 'Apri Nugroho, S.IP', 'jabatan' => 'Staf Kamituwa', 'no_hp' => null, 'kode_dept' => 'KAM', 'password' => Hash::make('1234'), 'foto' => null],
            // --- Urusan Danarta ---
            ['id_pegawai' => 'D0001', 'nama_lengkap' => 'Fernandya Riski Hartantri, ST', 'jabatan' => 'Kepala Urusan Danarta', 'no_hp' => '085643099080', 'kode_dept' => 'DAN', 'password' => Hash::make('1234'), 'foto' => null],
            ['id_pegawai' => 'D0002', 'nama_lengkap' => 'Eko Kadaryanto, S.E', 'jabatan' => 'Staf Danarta', 'no_hp' => null, 'kode_dept' => 'DAN', 'password' => Hash::make('1234'), 'foto' => null],
            ['id_pegawai' => 'D0003', 'nama_lengkap' => 'Erna Setyaningsih, S.Pd', 'jabatan' => 'Staf Danarta', 'no_hp' => null, 'kode_dept' => 'DAN', 'password' => Hash::make('1234'), 'foto' => null],
            // --- Urusan Pangripta ---
            ['id_pegawai' => 'P0001', 'nama_lengkap' => 'Wahyu Nurendra', 'jabatan' => 'Kepala Urusan Pangripta', 'no_hp' => '085878226295', 'kode_dept' => 'PAN', 'password' => Hash::make('1234'), 'foto' => null],
            // --- Urusan Tata Laksana ---
            ['id_pegawai' => 'TL001', 'nama_lengkap' => 'Andrec Setiawan, SH.I', 'jabatan' => 'Kepala Urusan Tata Laksana', 'no_hp' => '087838803852', 'kode_dept' => 'TL', 'password' => Hash::make('1234'), 'foto' => null],
            ['id_pegawai' => 'TL002', 'nama_lengkap' => 'Sudarna, BA', 'jabatan' => 'Staf Tata Laksana', 'no_hp' => null, 'kode_dept' => 'TL', 'password' => Hash::make('1234'), 'foto' => null],
            ['id_pegawai' => 'TL003', 'nama_lengkap' => 'Marsana', 'jabatan' => 'Staf Tata Laksana', 'no_hp' => null, 'kode_dept' => 'TL', 'password' => Hash::make('1234'), 'foto' => null],
            ['id_pegawai' => 'TL004', 'nama_lengkap' => 'Serono', 'jabatan' => 'Staf Tata Laksana', 'no_hp' => null, 'kode_dept' => 'TL', 'password' => Hash::make('1234'), 'foto' => null],
            ['id_pegawai' => 'TL005', 'nama_lengkap' => 'Tri Sugiyatno', 'jabatan' => 'Staf Tata Laksana', 'no_hp' => null, 'kode_dept' => 'TL', 'password' => Hash::make('1234'), 'foto' => null],
            ['id_pegawai' => 'TL006', 'nama_lengkap' => 'Amalia Diah Ayu Kiranti, S.T', 'jabatan' => 'Staf Tata Laksana', 'no_hp' => null, 'kode_dept' => 'TL', 'password' => Hash::make('1234'), 'foto' => null],
            ['id_pegawai' => 'TL007', 'nama_lengkap' => 'Nefdia Erlina', 'jabatan' => 'Staf Tata Laksana', 'no_hp' => null, 'kode_dept' => 'TL', 'password' => Hash::make('1234'), 'foto' => null],
            ['id_pegawai' => 'TL008', 'nama_lengkap' => 'Ririn Ardiana, A.Md, Ak', 'jabatan' => 'Staf Tata Laksana', 'no_hp' => null, 'kode_dept' => 'TL', 'password' => Hash::make('1234'), 'foto' => null],
        ]);

        // =============================================
        // 3. Akun Admin / Petugas / Lurah (Users)
        // =============================================
        DB::table('users')->truncate();
        DB::table('users')->insert([
            ['name' => 'Admin System', 'email' => 'admin@condongcatur.id', 'password' => Hash::make('password123'), 'role' => 'admin'],
            ['name' => 'Petugas Absensi', 'email' => 'petugas@condongcatur.id', 'password' => Hash::make('password123'), 'role' => 'petugas'],
            ['name' => 'Lurah Condongcatur', 'email' => 'lurah@condongcatur.id', 'password' => Hash::make('password123'), 'role' => 'lurah'],
        ]);

        echo "=== IMPORT DATA ASLI KALURAHAN CONDONGCATUR SELESAI ===\n";
        echo "26 Pegawai + 7 Departemen + 3 Akun pengelola berhasil dimasukkan.\n\n";
        echo "LOGIN PEGAWAI: ID Pegawai (contoh: L0001) | Password: 1234\n";
        echo "LOGIN ADMIN  : admin@condongcatur.id       | Password: password123\n";
        echo "LOGIN PETUGAS: petugas@condongcatur.id     | Password: password123\n";
        echo "LOGIN LURAH  : lurah@condongcatur.id       | Password: password123\n";
    }
}
