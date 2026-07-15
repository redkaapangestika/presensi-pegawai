<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PetugasController extends Controller
{
    // -------------------------------------------------------
    // Atur Jadwal Kerja
    // -------------------------------------------------------
    public function jadwal()
    {
        // Ambil semua departemen sebagai dasar jadwal
        $departemens = DB::table('departemens')->get();

        // Dummy jadwal default (bisa diganti tabel jadwal kelak)
        $jadwal = [
            ['hari' => 'Senin', 'jam_masuk' => '08:00', 'jam_pulang' => '16:00'],
            ['hari' => 'Selasa', 'jam_masuk' => '08:00', 'jam_pulang' => '16:00'],
            ['hari' => 'Rabu', 'jam_masuk' => '08:00', 'jam_pulang' => '16:00'],
            ['hari' => 'Kamis', 'jam_masuk' => '08:00', 'jam_pulang' => '16:00'],
            ['hari' => 'Jumat', 'jam_masuk' => '07:30', 'jam_pulang' => '15:30'],
        ];

        // Ambil semua pegawai beserta departemennya untuk list dinas luar
        $pegawais = DB::table('pegawais')
            ->select('pegawais.*', 'departemens.nama_dept')
            ->leftJoin('departemens', 'pegawais.kode_dept', '=', 'departemens.kode_dept')
            ->orderBy('pegawais.nama_lengkap', 'asc')
            ->get();

        return view('petugas.jadwal', compact('departemens', 'jadwal', 'pegawais'));
    }

    public function storeJadwal(Request $request)
    {
        // Fitur Dummy Update Jadwal Departemen
        return redirect('/petugas/jadwal')->with('success', 'Penjadwalan dinas normal berhasil diperbarui!');
    }

    public function setDinasLuar(Request $request)
    {
        $id_pegawai = $request->id_pegawai;
        $is_dinas = $request->has('is_dinas_luar') ? 1 : 0;
        $lokasi = $request->lokasi_dinas;

        DB::table('pegawais')->where('id_pegawai', $id_pegawai)->update([
            'is_dinas_luar' => $is_dinas,
            'lokasi_dinas' => $lokasi
        ]);

        return redirect('/petugas/jadwal')->with('success', 'Status dinas luar pegawai berhasil dan izin lokasi telah disesuaikan.');
    }

    // -------------------------------------------------------
    // Verifikasi Cuti / Izin Pegawai
    // -------------------------------------------------------
    public function verifikasiCuti()
    {
        $pengajuan = DB::table('pengajuan_izin')
            ->select('pengajuan_izin.*', 'pegawais.nama_lengkap', 'departemens.nama_dept')
            ->join('pegawais', 'pengajuan_izin.id_pegawai', '=', 'pegawais.id_pegawai')
            ->join('departemens', 'pegawais.kode_dept', '=', 'departemens.kode_dept')
            ->orderBy('pengajuan_izin.created_at', 'desc')
            ->get();

        return view('petugas.verifikasi-cuti', compact('pengajuan'));
    }

    public function updateCuti(Request $request)
    {
        $id = $request->id;
        $status = $request->status_approved; // '1' = setuju, '2' = tolak

        DB::table('pengajuan_izin')
            ->where('id', $id)
            ->update([
                'status_approved' => $status,
                'updated_at' => now(),
            ]);

        return redirect('/petugas/verifikasi-cuti')
            ->with('success', 'Status pengajuan berhasil diperbarui.');
    }

    // -------------------------------------------------------
    // Validasi Presensi
    // -------------------------------------------------------
    public function validasiPresensi()
    {
        $today = date('Y-m-d');

        $presensi = DB::table('presensis')
            ->select('presensis.*', 'pegawais.nama_lengkap', 'departemens.nama_dept')
            ->join('pegawais', 'presensis.id_pegawai', '=', 'pegawais.id_pegawai')
            ->join('departemens', 'pegawais.kode_dept', '=', 'departemens.kode_dept')
            ->where('presensis.tgl_presensi', $today)
            ->orderBy('presensis.jam_in', 'asc')
            ->get();

        return view('petugas.validasi-presensi', compact('presensi', 'today'));
    }

    public function updateValidasi(Request $request)
    {
        $id = $request->id;
        $status = $request->status_validasi; // 'valid' atau 'invalid'

        DB::table('presensis')
            ->where('id_presensi', $id)
            ->update([
                'status_validasi' => $status,
            ]);

        return redirect('/petugas/validasi-presensi')
            ->with('success', 'Status validasi presensi berhasil diperbarui.');
    }

    // AJAX — filter tanggal di halaman validasi presensi
    public function getpresensiValidasi(Request $request)
    {
        $tanggal = $request->tanggal;

        $presensi = DB::table('presensis')
            ->select('presensis.*', 'pegawais.nama_lengkap', 'departemens.nama_dept')
            ->join('pegawais', 'presensis.id_pegawai', '=', 'pegawais.id_pegawai')
            ->join('departemens', 'pegawais.kode_dept', '=', 'departemens.kode_dept')
            ->where('presensis.tgl_presensi', $tanggal)
            ->orderBy('presensis.jam_in', 'asc')
            ->get();

        $rows = '';
        if ($presensi->isEmpty()) {
            $rows = '<tr><td colspan="7" class="text-center text-muted py-4">Tidak ada data presensi untuk tanggal ini.</td></tr>';
        } else {
            foreach ($presensi as $no => $p) {
                $sv = $p->status_validasi ?? null;
                if ($sv == 'valid') {
                    $badge = '<span class="badge bg-success">Valid</span>';
                } elseif ($sv == 'invalid') {
                    $badge = '<span class="badge bg-danger">Tidak Valid</span>';
                } else {
                    $badge = '<span class="badge bg-warning text-dark">Belum Divalidasi</span>';
                }
                $jam_in = $p->jam_in ? '<span class="badge bg-green-lt">' . $p->jam_in . '</span>' : '<span class="text-muted">-</span>';
                if ($p->jam_in && $p->jam_in > '08:00:00') {
                    $jam_in .= ' <span class="badge bg-danger ms-1">Terlambat</span>';
                }
                $jam_out = $p->jam_out ? '<span class="badge bg-red-lt">' . $p->jam_out . '</span>' : '<span class="text-muted">Belum checkout</span>';

                $rows .= '<tr>
                    <td>' . ($no + 1) . '</td>
                    <td>' . e($p->nama_lengkap) . '</td>
                    <td><span class="badge bg-blue-lt">' . e($p->nama_dept) . '</span></td>
                    <td>' . $jam_in . '</td>
                    <td>' . $jam_out . '</td>
                    <td>' . $badge . '</td>
                    <td>
                        <div class="btn-group">
                            <form method="POST" action="/petugas/validasi-presensi/update" id="form-valid-' . $p->id_presensi . '" class="d-inline">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <input type="hidden" name="id" value="' . $p->id_presensi . '">
                                <input type="hidden" name="status_validasi" value="valid">
                                ' . ($sv == 'valid'
                    ? '<button type="button" class="btn btn-sm btn-success disabled" disabled>&#10003; Tervalidasi</button>'
                    : '<button type="button" class="btn btn-sm btn-outline-success" onclick="confirmValidation(\'form-valid-' . $p->id_presensi . '\', true)">&#10003; Valid</button>') . '
                            </form>
                            <form method="POST" action="/petugas/validasi-presensi/update" id="form-invalid-' . $p->id_presensi . '" class="d-inline ms-1">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <input type="hidden" name="id" value="' . $p->id_presensi . '">
                                <input type="hidden" name="status_validasi" value="invalid">
                                ' . ($sv == 'invalid'
                    ? '<button type="button" class="btn btn-sm btn-danger disabled" disabled>&#10005; Ditolak</button>'
                    : '<button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmValidation(\'form-invalid-' . $p->id_presensi . '\', false)">&#10005; Tidak Valid</button>') . '
                            </form>
                        </div>
                    </td>
                </tr>';
            }
        }

        return response($rows);
    }
}
