<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pegawais = [
            ['L0001', 'Dr. Reno Candra Sangaji, S.IP, M.IP', 'Lurah', 'LRH', '081328779478'],
            ['C0001', 'Riska Dian Nur Lestari, S.TP., M.Sc', 'Carik', 'CRK', '08112630656'],
            ['C0002', 'Warsana, S.H', 'Staf Carik', 'STC', '081328205529'],
            ['J0001', 'Rudi Antariksawan', 'Jagabaya', 'JGB', '085643431344'],
            ['J0002', 'Tri Susetyanto, S.IP.', 'Staf Jagabaya', 'SJB', '0888'],
            ['J0003', 'Heri Supriyono', 'Staf Jagabaya', 'SJB', '085228458275'],
            ['U0001', 'Murgiyanta, S.E', 'Ulu-Ulu', 'ULU', '081212498287'],
            ['U0002', 'Wanda Wira Sahputra, S.E', 'Staf Ulu-Ulu', 'SUU', ''],
            ['U0003', 'Heri Sunanta', 'Staf Ulu-Ulu', 'SUU', ''],
            ['U0004', 'Felicita Erma Sista, S.T', 'Staf Ulu-Ulu', 'SUU', ''],
            ['K0001', 'Al Thouvik Sofisalam, Amd', 'Kamituwa', 'KMT', '08112534443'],
            ['K0002', 'Candra Widiantoro, A.Md', 'Staf Kamituwa', 'SKT', ''],
            ['K0003', 'Nur Amalina Dwi Astuti, S.SL', 'Staf Kamituwa', 'SKT', ''],
            ['K0004', 'Apri Nugroho, S.IP', 'Staf Kamituwa', 'SKT', ''],
            ['D0001', 'Fernandya Riski Hartantri, ST', 'Kepala Urusan Danarta', 'KUD', '085643099080'],
            ['D0002', 'Eko Kadaryanto, S.E', 'Staf Danarta', 'SDA', ''],
            ['D0003', 'Erna Setyaningsih, S.Pd', 'Staf Danarta', 'SDA', ''],
            ['P0001', 'Wahyu Nurendra', 'Kepala Urusan Pangripta', 'KUP', '085878226295'],
            ['TL001', 'Andree Setiawan, SH.I', 'Kepala Urusan Tata Laksana', 'KUT', '087838803852'],
            ['TL002', 'Sudarna, BA', 'Staf Tata Laksana', 'STL', ''],
            ['TL003', 'Marsana', 'Staf Tata Laksana', 'STL', ''],
            ['TL004', 'Serono', 'Staf Tata Laksana', 'STL', ''],
            ['TL005', 'Tri Sugiyatno', 'Staf Tata Laksana', 'STL', ''],
            ['TL006', 'Amalia Diah Ayu Kiranti, S.T', 'Staf Tata Laksana', 'STL', ''],
            ['TL007', 'Nefdia Erlina', 'Staf Tata Laksana', 'STL', ''],
            ['TL008', 'Ririn Ardiana, A.Md, Ak', 'Staf Tata Laksana', 'STL', ''],
        ];

        foreach ($pegawais as $p) {
            \Illuminate\Support\Facades\DB::table('pegawais')->updateOrInsert(
                ['id_pegawai' => $p[0]],
                [
                    'nama_lengkap' => $p[1],
                    'jabatan' => $p[2],
                    'kode_dept' => $p[3],
                    'no_hp' => $p[4] ?: null,
                    'password' => \Illuminate\Support\Facades\Hash::make('1234')
                ]
            );
        }
    }
}
