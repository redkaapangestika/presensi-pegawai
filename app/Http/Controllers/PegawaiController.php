<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        
        $pegawai = $query->paginate(2);

        $departemen = DB::table('departemens')->get();
        return view('pegawai.index', compact('pegawai', 'departemen'));
    }
}
