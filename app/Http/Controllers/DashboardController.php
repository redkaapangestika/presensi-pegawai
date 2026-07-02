<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $hariini = date('Y-m-d');
        $bulanini = date("m") * 1; //1 atau Januari
        $tahunini = date("Y"); //2026
        $id_pegawai = auth()->guard('pegawai')->user()->id_pegawai;
        $presensihariini = DB::table('presensis')
            ->where('id_pegawai', $id_pegawai)
            ->where('tgl_presensi', $hariini)
            ->first();
        $historibulanini = DB::table('presensis')
            ->where('id_pegawai', $id_pegawai)
            ->whereMonth('tgl_presensi', $bulanini)
            ->whereYear('tgl_presensi', $tahunini)
            ->orderBy('tgl_presensi')
            ->get();
        
        $rekappresensi = DB::table('presensis')
            ->selectRaw('COUNT(id_pegawai) as jmlhadir, SUM(IF(jam_in > "08.00:00", 1, 0)) as jmlterlambat')
            ->where('id_pegawai', $id_pegawai)
            ->whereMonth('tgl_presensi', $bulanini)
            ->whereYear('tgl_presensi', $tahunini)
            ->first();
        
        $leaderboard = DB::table('presensis')
        ->join('pegawais', 'presensis.id_pegawai', '=', 'pegawais.id_pegawai')
            ->where('tgl_presensi', $hariini)
            ->orderBy('jam_in')
            ->get();
        $namabulan = ["","Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        
        $rekapizin = DB::table('pengajuan_izin')
            ->selectRaw('SUM(IF(status="i",1,0)) as jmlizin, SUM(IF(status="s",1,0)) as jmlsakit')
            ->where('id_pegawai', $id_pegawai)
            ->whereMonth('tgl_izin', $bulanini)
            ->whereYear('tgl_izin', $tahunini)
            ->where('status_approved', '1') // Hanya menghitung izin yang disetujui
            ->first();
        return view('dashboard.dashboard', compact('presensihariini', 'historibulanini', 'namabulan', 'bulanini', 'tahunini', 'rekappresensi', 'leaderboard', 'rekapizin'));
    }
}
