<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Pegawai;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $query = Pegawai::query();
        $query->select('pegawais.*', 'nama_dept');
        $query->join('departemens', 'pegawais.kode_dept', '=', 'departemens.kode_dept');
        $jabatanOrder = "CASE pegawais.jabatan
            WHEN 'Lurah' THEN 1 WHEN 'Carik' THEN 2 WHEN 'Jagabaya' THEN 3
            WHEN 'Ulu-Ulu' THEN 4 WHEN 'Kamituwa' THEN 5
            WHEN 'Kepala Urusan Danarta' THEN 6 WHEN 'Kaur Danarta' THEN 7
            WHEN 'Kepala Urusan Pangripta' THEN 8 WHEN 'Kaur Pangripta' THEN 9
            WHEN 'Kepala Urusan Tata Laksana' THEN 10 WHEN 'Kaur Tata Laksana' THEN 11
            WHEN 'Kaur' THEN 12 WHEN 'Staf Carik' THEN 13 WHEN 'Staf Jagabaya' THEN 14
            WHEN 'Staf Ulu-Ulu' THEN 15 WHEN 'Staf Kamituwa' THEN 16
            WHEN 'Staf Danarta' THEN 17 WHEN 'Staf Tata Laksana' THEN 18
            WHEN 'Staf' THEN 19 ELSE 99 END";
        $query->orderByRaw($jabatanOrder)->orderBy('pegawais.nama_lengkap');
        if (!empty($request->nama_pegawai)) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_pegawai . '%');
        }

        if (!empty($request->kode_dept)) {
            $query->where('pegawais.kode_dept', $request->kode_dept);
        }

        $pegawai = $query->paginate(10);

        $departemen = DB::table('departemens')->get();
        return view('pegawai.index', compact('pegawai', 'departemen'));
    }

    public function store(Request $request)
    {
        $id_pegawai = $request->id_pegawai;
        $nama_lengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $no_hp = $request->no_hp;
        $kode_dept = $request->kode_dept;
        $password = Hash::make('12345');

        // Check for duplicate ID Pegawai
        $cek = DB::table('pegawais')->where('id_pegawai', $id_pegawai)->count();
        if ($cek > 0) {
            return redirect()->back()->with('warning', 'Data Gagal Disimpan, ID Pegawai sudah digunakan oleh Pegawai lain.');
        }

        if ($request->hasFile('foto')) {
            $foto = $id_pegawai . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = null;
        }

        try {
            $data = [
                'id_pegawai' => $id_pegawai,
                'nama_lengkap' => $nama_lengkap,
                'jabatan' => $jabatan,
                'no_hp' => $no_hp,
                'kode_dept' => $kode_dept,
                'password' => $password,
                'foto' => $foto
            ];
            $simpan = DB::table('pegawais')->insert($data);
            if ($simpan) {
                if ($request->hasFile('foto')) {
                    $folderPath = 'uploads/pegawai/';
                    $request->file('foto')->storeAs('uploads/pegawai', $foto, 'public');
                }
                return redirect()->back()->with('success', 'Data pegawai berhasil disimpan.');
            } else {
                return redirect()->back()->with('error', 'Gagal menyimpan data pegawai.');
            }
        } catch (\Exception $e) {
            // Check if error is due to duplicate entry (Integrity constraint violation)
            if ($e->getCode() == 23000) {
                return redirect()->back()->with('warning', 'Data Gagal Disimpan, ID Pegawai sudah digunakan oleh Pegawai lain.');
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data pegawai.');
        }
    }

    public function edit(Request $request)
    {
        $id_pegawai = $request->id_pegawai;
        $departemen = DB::table('departemens')->get();
        $pegawai = DB::table('pegawais')->where('id_pegawai', $id_pegawai)->first();
        return view('pegawai.edit', compact('departemen', 'pegawai'));
    }

    public function update($id_pegawai, Request $request)
    {
        $id_pegawai = $request->id_pegawai;
        $nama_lengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $no_hp = $request->no_hp;
        $kode_dept = $request->kode_dept;
        $password = Hash::make('12345');
        $old_foto = $request->old_foto;
        if ($request->hasFile('foto')) {
            $foto = $id_pegawai . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = $old_foto;
        }

        try {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'jabatan' => $jabatan,
                'no_hp' => $no_hp,
                'kode_dept' => $kode_dept,
                'password' => $password,
                'foto' => $foto
            ];
            $update = DB::table('pegawais')->where('id_pegawai', $id_pegawai)->update($data);
            if ($update) {
                if ($request->hasFile('foto')) {
                    $oldPath = 'uploads/pegawai/' . $old_foto;
                    if ($old_foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($oldPath)) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
                    }
                    $request->file('foto')->storeAs('uploads/pegawai', $foto, 'public');
                }
                return redirect()->back()->with('success', 'Data pegawai berhasil disimpan.');
            } else {
                return redirect()->back()->with('error', 'Gagal menyimpan data pegawai.');
            }
        } catch (\Exception $e) {
            dd($e);
            //return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data pegawai.');
        }
    }

    public function delete($id_pegawai)
    {
        $delete = DB::table('pegawais')->where('id_pegawai', $id_pegawai)->delete();
        if ($delete) {
            return redirect()->back()->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return redirect()->back()->with(['warning' => 'Data Gagal Dihapus']);
        }
    }
}
