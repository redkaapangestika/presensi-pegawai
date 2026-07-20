<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    private $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

    public function presensi()
    {
        $namabulan = $this->namabulan;
        $karyawan = DB::table('pegawais')->orderBy('nama_lengkap')->get();
        return view('laporan.presensi', compact('namabulan', 'karyawan'));
    }

    public function cetakPresensi(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $id_pegawai = $request->id_pegawai;
        $namabulan = $this->namabulan;

        if ($id_pegawai) {
            $pegawai = DB::table('pegawais')->where('id_pegawai', $id_pegawai)->first();
            $presensi = DB::table('presensis')
                ->where('id_pegawai', $id_pegawai)
                ->whereMonth('tgl_presensi', $bulan)
                ->whereYear('tgl_presensi', $tahun)
                ->orderBy('tgl_presensi')
                ->get();
        } else {
            $pegawai = null; // Semua Pegawai
            $presensi = DB::table('presensis')
                ->join('pegawais', 'presensis.id_pegawai', '=', 'pegawais.id_pegawai')
                ->select('presensis.*', 'pegawais.nama_lengkap', 'pegawais.jabatan')
                ->whereMonth('tgl_presensi', $bulan)
                ->whereYear('tgl_presensi', $tahun)
                ->orderBy('pegawais.nama_lengkap')
                ->orderBy('tgl_presensi')
                ->get();
        }

        return view('laporan.cetak_presensi', compact('bulan', 'tahun', 'id_pegawai', 'pegawai', 'presensi', 'namabulan'));
    }

    public function kinerja()
    {
        $namabulan = $this->namabulan;
        $karyawan = DB::table('pegawais')->orderBy('nama_lengkap')->get();
        return view('laporan.kinerja', compact('namabulan', 'karyawan'));
    }

    public function cetakKinerja(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $id_pegawai = $request->id_pegawai;
        $namabulan = $this->namabulan;

        if ($id_pegawai) {
            $pegawai = DB::table('pegawais')->where('id_pegawai', $id_pegawai)->first();
            $kinerja = DB::table('presensis')
                ->where('id_pegawai', $id_pegawai)
                ->whereNotNull('log_kerja')
                ->where('status_acc_log', 1)
                ->whereMonth('tgl_presensi', $bulan)
                ->whereYear('tgl_presensi', $tahun)
                ->orderBy('tgl_presensi')
                ->get();
        } else {
            $pegawai = null;
            $kinerja = DB::table('presensis')
                ->join('pegawais', 'presensis.id_pegawai', '=', 'pegawais.id_pegawai')
                ->select('presensis.*', 'pegawais.nama_lengkap', 'pegawais.jabatan')
                ->whereNotNull('log_kerja')
                ->where('status_acc_log', 1)
                ->whereMonth('tgl_presensi', $bulan)
                ->whereYear('tgl_presensi', $tahun)
                ->orderBy('pegawais.nama_lengkap')
                ->orderBy('tgl_presensi')
                ->get();
        }

        return view('laporan.cetak_kinerja', compact('bulan', 'tahun', 'id_pegawai', 'pegawai', 'kinerja', 'namabulan'));
    }

    public function cuti()
    {
        $namabulan = $this->namabulan;
        $karyawan = DB::table('pegawais')->orderBy('nama_lengkap')->get();
        return view('laporan.cuti', compact('namabulan', 'karyawan'));
    }

    public function cetakCuti(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $id_pegawai = $request->id_pegawai;
        $namabulan = $this->namabulan;

        if ($id_pegawai) {
            $pegawai = DB::table('pegawais')->where('id_pegawai', $id_pegawai)->first();
            $cuti = DB::table('pengajuan_izin')
                ->where('id_pegawai', $id_pegawai)
                ->whereMonth('tgl_izin', $bulan)
                ->whereYear('tgl_izin', $tahun)
                ->orderBy('tgl_izin')
                ->get();
        } else {
            $pegawai = null; // Laporan Global
            $cuti = DB::table('pengajuan_izin')
                ->join('pegawais', 'pengajuan_izin.id_pegawai', '=', 'pegawais.id_pegawai')
                ->select('pengajuan_izin.*', 'pegawais.nama_lengkap')
                ->whereMonth('tgl_izin', $bulan)
                ->whereYear('tgl_izin', $tahun)
                ->orderBy('pegawais.nama_lengkap')
                ->orderBy('tgl_izin')
                ->get();
        }

        return view('laporan.cetak_cuti', compact('bulan', 'tahun', 'id_pegawai', 'pegawai', 'cuti', 'namabulan'));
    }
    public function pegawai()
    {
        $departemen = DB::table('departemens')->orderBy('nama_dept')->get();
        return view('laporan.pegawai', compact('departemen'));
    }

    public function cetakPegawai(Request $request)
    {
        $kode_dept = $request->kode_dept;

        $query = DB::table('pegawais')
            ->join('departemens', 'pegawais.kode_dept', '=', 'departemens.kode_dept')
            ->select('pegawais.id_pegawai', 'pegawais.nama_lengkap', 'pegawais.jabatan', 'pegawais.no_hp', 'departemens.nama_dept', 'pegawais.foto');

        if (!empty($kode_dept)) {
            $query->where('pegawais.kode_dept', $kode_dept);
            $departemen = DB::table('departemens')->where('kode_dept', $kode_dept)->first();
        } else {
            $departemen = null;
        }

        $jabatanOrder = "CASE pegawais.jabatan
            WHEN 'Lurah' THEN 1
            WHEN 'Carik' THEN 2
            WHEN 'Jagabaya' THEN 3
            WHEN 'Ulu-Ulu' THEN 4
            WHEN 'Kamituwa' THEN 5
            WHEN 'Kepala Urusan Danarta' THEN 6
            WHEN 'Kaur Danarta' THEN 7
            WHEN 'Kepala Urusan Pangripta' THEN 8
            WHEN 'Kaur Pangripta' THEN 9
            WHEN 'Kepala Urusan Tata Laksana' THEN 10
            WHEN 'Kaur Tata Laksana' THEN 11
            WHEN 'Kaur' THEN 12
            WHEN 'Staf Carik' THEN 13
            WHEN 'Staf Jagabaya' THEN 14
            WHEN 'Staf Ulu-Ulu' THEN 15
            WHEN 'Staf Kamituwa' THEN 16
            WHEN 'Staf Danarta' THEN 17
            WHEN 'Staf Tata Laksana' THEN 18
            WHEN 'Staf' THEN 19
            ELSE 99 END";
        $pegawai = $query->orderByRaw($jabatanOrder)->orderBy('pegawais.nama_lengkap')->get();

        return view('laporan.cetak_pegawai', compact('pegawai', 'departemen', 'kode_dept'));
    }
}
