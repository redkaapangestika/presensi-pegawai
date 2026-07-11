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
        $query->orderBy('nama_lengkap');
        if(!empty($request->nama_pegawai)){
            $query->where('nama_lengkap', 'like', '%'.$request->nama_pegawai.'%');
        }

        if(!empty($request->kode_dept)){
            $query->where('pegawais.kode_dept', $request->kode_dept);
        }
        
        $pegawai = $query->paginate(5);

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
            dd($e);
            //return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data pegawai.');
        }

    }
}
