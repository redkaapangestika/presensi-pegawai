<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartemenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dep = [
            ['CRK', 'Carik'],
            ['JGB', 'Jagabaya'],
            ['KMT', 'Kamituwa'],
            ['KUD', 'Kepala Urusan Danarta'],
            ['KUP', 'Kepala Urusan Pangripta'],
            ['KUT', 'Kepala Urusan Tata Laksana'],
            ['LRH', 'Lurah'],
            ['SDA', 'Staf Danarta'],
            ['SJB', 'Staf Jagabaya'],
            ['SKT', 'Staf Kamituwa'],
            ['STC', 'Staf Carik'],
            ['STL', 'Staf Tata Laksana'],
            ['SUU', 'Staf Ulu-Ulu'],
            ['ULU', 'Ulu-Ulu']
        ];

        foreach ($dep as $d) {
            \Illuminate\Support\Facades\DB::table('departemens')->updateOrInsert(
                ['kode_dept' => $d[0]],
                ['nama_dept' => $d[1]]
            );
        }
    }
}
