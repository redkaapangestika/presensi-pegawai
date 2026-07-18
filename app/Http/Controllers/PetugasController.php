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
            ->orderByRaw("FIELD(pegawais.jabatan, 'Lurah', 'Carik', 'Jagabaya', 'Ulu-Ulu', 'Kamituwa', 'Kepala Urusan Danarta', 'Kaur Danarta', 'Kepala Urusan Pangripta', 'Kaur Pangripta', 'Kepala Urusan Tata Laksana', 'Kaur Tata Laksana', 'Kaur', 'Staf Carik', 'Staf Jagabaya', 'Staf Ulu-Ulu', 'Staf Kamituwa', 'Staf Danarta', 'Staf Tata Laksana', 'Staf') = 0")->orderByRaw("FIELD(pegawais.jabatan, 'Lurah', 'Carik', 'Jagabaya', 'Ulu-Ulu', 'Kamituwa', 'Kepala Urusan Danarta', 'Kaur Danarta', 'Kepala Urusan Pangripta', 'Kaur Pangripta', 'Kepala Urusan Tata Laksana', 'Kaur Tata Laksana', 'Kaur', 'Staf Carik', 'Staf Jagabaya', 'Staf Ulu-Ulu', 'Staf Kamituwa', 'Staf Danarta', 'Staf Tata Laksana', 'Staf')")->orderBy('pegawais.nama_lengkap', 'asc')
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
        $alasan_tolak = $request->alasan_tolak;

        DB::table('pengajuan_izin')
            ->where('id', $id)
            ->update([
                'status_approved' => $status,
                'alasan_tolak' => $status == '2' ? $alasan_tolak : null,
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

    // -------------------------------------------------------
    // Evaluasi Log Kerja (Kinerja)
    // -------------------------------------------------------
    public function logKerja()
    {
        $pegawais = DB::table('pegawais')->orderBy('nama_lengkap', 'asc')->get();
        return view('petugas.log-kerja', compact('pegawais'));
    }

    public function getLogKerja(Request $request)
    {
        $tanggal = $request->tanggal;

        $presensi = DB::table('presensis')
            ->select('presensis.*', 'pegawais.nama_lengkap', 'departemens.nama_dept', 'pegawais.jabatan')
            ->join('pegawais', 'presensis.id_pegawai', '=', 'pegawais.id_pegawai')
            ->join('departemens', 'pegawais.kode_dept', '=', 'departemens.kode_dept')
            ->where('presensis.tgl_presensi', $tanggal)
            ->whereNotNull('presensis.log_kerja')
            ->orderByRaw("FIELD(pegawais.jabatan, 'Lurah', 'Carik', 'Jagabaya', 'Ulu-Ulu', 'Kamituwa', 'Kepala Urusan Danarta', 'Kaur Danarta', 'Kepala Urusan Pangripta', 'Kaur Pangripta', 'Kepala Urusan Tata Laksana', 'Kaur Tata Laksana', 'Kaur', 'Staf Carik', 'Staf Jagabaya', 'Staf Ulu-Ulu', 'Staf Kamituwa', 'Staf Danarta', 'Staf Tata Laksana', 'Staf') = 0")
            ->orderByRaw("FIELD(pegawais.jabatan, 'Lurah', 'Carik', 'Jagabaya', 'Ulu-Ulu', 'Kamituwa', 'Kepala Urusan Danarta', 'Kaur Danarta', 'Kepala Urusan Pangripta', 'Kaur Pangripta', 'Kepala Urusan Tata Laksana', 'Kaur Tata Laksana', 'Kaur', 'Staf Carik', 'Staf Jagabaya', 'Staf Ulu-Ulu', 'Staf Kamituwa', 'Staf Danarta', 'Staf Tata Laksana', 'Staf')")
            ->orderBy('pegawais.nama_lengkap', 'asc')
            ->get();

        $rows = '';
        if ($presensi->isEmpty()) {
            $rows = '<tr><td colspan="6" class="text-center text-muted py-4">Tidak ada log kerja masuk / berkas untuk tanggal ini.</td></tr>';
        } else {
            foreach ($presensi as $no => $p) {
                // Tampilkan link berkas log jika ada
                $berkas = $p->berkas_log
                    ? '<a href="' . asset('storage/uploads/log_kerja/' . $p->berkas_log) . '" target="_blank" class="badge bg-green-lt text-decoration-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-download" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M14 3v4a1 1 0 0 0 1 1h4"></path><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path><path d="M12 17v-6"></path><path d="M9.5 14.5l2.5 2.5l2.5 -2.5"></path></svg> 
                        Lihat Berkas
                       </a>'
                    : '<span class="text-muted">-</span>';

                $rows .= '<tr>
                    <td>' . ($no + 1) . '</td>
                    <td><div class="font-weight-medium">' . e($p->nama_lengkap) . '</div><div class="text-muted"><small>' . e($p->jabatan) . '</small></div></td>
                    <td><span class="badge bg-blue-lt">' . e($p->nama_dept) . '</span></td>
                    <td><span class="badge bg-red-lt">' . e($p->jam_out) . ' WIB</span></td>
                    <td class="text-wrap" style="max-width: 300px;">' . nl2br(e($p->log_kerja)) . '</td>
                    <td>' . $berkas . '</td>
                    <td>
                        <div class="btn-group">
                            <form method="POST" action="/petugas/log-kerja/acc" class="d-inline">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <input type="hidden" name="id_presensi" value="' . $p->id_presensi . '">
                                ' . ($p->status_acc_log == 1 ? '<button type="button" class="btn btn-sm btn-success disabled" disabled>Di-ACC</button>' : '<button type="submit" class="btn btn-sm btn-outline-success">ACC</button>') . '
                            </form>
                            <button type="button" class="btn btn-sm btn-outline-primary ms-1" onclick="editLog(' . $p->id_presensi . ', \'' . htmlspecialchars($p->log_kerja, ENT_QUOTES) . '\')">Edit</button>
                            <form method="POST" action="/petugas/log-kerja/delete" id="form-delete-log-' . $p->id_presensi . '" class="d-inline ms-1">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <input type="hidden" name="id_presensi" value="' . $p->id_presensi . '">
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDeleteLog(\'form-delete-log-' . $p->id_presensi . '\')">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>';
            }
        }
        return response($rows);
    }

    public function storeLogKerja(Request $request)
    {
        $id_pegawai = $request->id_pegawai;
        $tgl_presensi = $request->tgl_presensi;
        $log_kerja = $request->log_kerja;

        DB::table('presensis')->updateOrInsert(
            ['id_pegawai' => $id_pegawai, 'tgl_presensi' => $tgl_presensi],
            ['log_kerja' => $log_kerja]
        );

        return redirect()->back()->with('success', 'Berhasil menambahkan log kerja harian/tugas.');
    }

    public function updateLogKerja(Request $request)
    {
        $id_presensi = $request->id_presensi;
        $log_kerja = $request->log_kerja;

        DB::table('presensis')->where('id_presensi', $id_presensi)->update([
            'log_kerja' => $log_kerja
        ]);

        return redirect()->back()->with('success', 'Catatan log kerja berhasil diperbarui.');
    }

    public function deleteLogKerja(Request $request)
    {
        $id_presensi = $request->id_presensi;

        DB::table('presensis')->where('id_presensi', $id_presensi)->update([
            'log_kerja' => null,
            'berkas_log' => null
        ]);

        return redirect()->back()->with('success', 'Catatan log & berkas kerja berhasil dihapus.');
    }
    public function accLogKerja(Request $request)
    {
        $id = $request->id_presensi;
        DB::table('presensis')->where('id_presensi', $id)->update(['status_acc_log' => 1]);
        return redirect()->back()->with('success', 'Log kerja berhasil dikonfirmasi (ACC).');
    }
}
