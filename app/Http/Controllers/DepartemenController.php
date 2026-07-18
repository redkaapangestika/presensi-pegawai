<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartemenController extends Controller
{
    public function index(Request $request)
    {
        $nama_dept = $request->nama_dept;
        $query = DB::table('departemens');
        if (!empty($nama_dept)) {
            $query->where('nama_dept', 'like', '%' . $nama_dept . '%');
        }
        $query->orderByRaw("FIELD(departemens.nama_dept, 'Lurah', 'Carik', 'Jagabaya', 'Ulu-Ulu', 'Kamituwa', 'Kepala Urusan Danarta', 'Kaur Danarta', 'Kepala Urusan Pangripta', 'Kaur Pangripta', 'Kepala Urusan Tata Laksana', 'Kaur Tata Laksana', 'Kaur', 'Staf Carik', 'Staf Jagabaya', 'Staf Ulu-Ulu', 'Staf Kamituwa', 'Staf Danarta', 'Staf Tata Laksana', 'Staf') = 0")->orderByRaw("FIELD(departemens.nama_dept, 'Lurah', 'Carik', 'Jagabaya', 'Ulu-Ulu', 'Kamituwa', 'Kepala Urusan Danarta', 'Kaur Danarta', 'Kepala Urusan Pangripta', 'Kaur Pangripta', 'Kepala Urusan Tata Laksana', 'Kaur Tata Laksana', 'Kaur', 'Staf Carik', 'Staf Jagabaya', 'Staf Ulu-Ulu', 'Staf Kamituwa', 'Staf Danarta', 'Staf Tata Laksana', 'Staf')")->orderBy('departemens.nama_dept');
        $departemen = $query->get();
        return view('departemen.index', compact('departemen'));
    }

    public function store(Request $request)
    {
        $kode_dept = $request->kode_dept;
        $nama_dept = $request->nama_dept;
        $data = [
            'kode_dept' => $kode_dept,
            'nama_dept' => $nama_dept
        ];

        $simpan = DB::table('departemens')->insert($data);
        if ($simpan) {
            return redirect()->back()->with('success', 'Data Berhasil Disimpan');
        } else {
            return redirect()->back()->with('warning', 'Data Gagal Disimpan');
        }
    }

    public function edit(Request $request)
    {
        $kode_dept = $request->kode_dept;
        $departemen = DB::table('departemens')->where('kode_dept', $kode_dept)->first();
        return view('departemen.edit', compact('departemen'));
    }

    public function update($kode_dept, Request $request)
    {
        $nama_dept = $request->nama_dept;
        $data = [
            'nama_dept' => $nama_dept
        ];

        $update = DB::table('departemens')->where('kode_dept', $kode_dept)->update($data);
        if ($update) {
            return redirect()->back()->with('success', 'Data Berhasil Diupdate');
        } else {
            return redirect()->back()->with('warning', 'Data Gagal Diupdate');
        }
    }

    public function delete($kode_dept)
    {
        $hapus = DB::table('departemens')->where('kode_dept', $kode_dept)->delete();
        if ($hapus) {
            return redirect()->back()->with('success', 'Data Berhasil Dihapus');
        } else {
            return redirect()->back()->with('warning', 'Data Gagal Dihapus');
        }
    }
}
