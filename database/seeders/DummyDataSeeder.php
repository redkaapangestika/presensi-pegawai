<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Departemen
        DB::table('departemens')->truncate();
        $departemons = [
            ['kode_dept' => 'IT', 'nama_dept' => 'Information Technology'],
            ['kode_dept' => 'HRD', 'nama_dept' => 'Human Resources'],
            ['kode_dept' => 'KEU', 'nama_dept' => 'Keuangan'],
            ['kode_dept' => 'MKT', 'nama_dept' => 'Marketing']
        ];
        DB::table('departemens')->insert($departemons);



        // 3. Pegawai
        DB::table('pegawais')->truncate();
        $pegawais = [
            [
                'id_pegawai' => '11111',
                'nama_lengkap' => 'John Pegawai',
                'jabatan' => 'Staff IT',
                'no_hp' => '0811111111',
                'password' => Hash::make('password123'),
                'kode_dept' => 'IT',
                'foto' => null,
            ],
            [
                'id_pegawai' => '22222',
                'nama_lengkap' => 'Jane Petugas',
                'jabatan' => 'Admin HR',
                'no_hp' => '0822222222',
                'password' => Hash::make('password123'),
                'kode_dept' => 'HRD',
                'foto' => null,
            ],
            [
                'id_pegawai' => '33333',
                'nama_lengkap' => 'Bapak Lurah',
                'jabatan' => 'Kepala Desa',
                'no_hp' => '0833333333',
                'password' => Hash::make('password123'),
                'kode_dept' => 'KEU',
                'foto' => null,
            ],
            [
                'id_pegawai' => '44444',
                'nama_lengkap' => 'Dina Administrator',
                'jabatan' => 'System Admin',
                'no_hp' => '0844444444',
                'password' => Hash::make('password123'),
                'kode_dept' => 'IT',
                'foto' => null,
            ]
        ];
        DB::table('pegawais')->insert($pegawais);

        // 4. Users (Sistem Akun Login per Role)
        DB::table('users')->truncate();
        $users = [
            [
                'name' => 'Admin System',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ],
            [
                'name' => 'Petugas Absensi',
                'email' => 'petugas@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'petugas',
            ],
            [
                'name' => 'Lurah Desa',
                'email' => 'lurah@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'lurah',
            ]
        ];
        DB::table('users')->insert($users);

        echo "Dummy Data Berhasil Disuntikkan (Departemen, Lokasi, Pegawai, dan Users).\n";
        echo "Gunakan salah satu email (admin@gmail.com, petugas@gmail.com, lurah@gmail.com, pegawai@gmail.com) dengan password: password123\n";
    }
}
