<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Presensi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PegawaiActivityNotification;

class PresensiController extends Controller
{
    public function create()
    {
        $hariini = date('Y-m-d');
        $id_pegawai = Auth::guard('pegawai')->user()->id_pegawai;
        $cekPresensi = DB::table('presensis')
            ->where('tgl_presensi', $hariini)
            ->where('id_pegawai', $id_pegawai)
            ->first();

        $cek = $cekPresensi && $cekPresensi->jam_in ? 1 : 0;

        // Check if officer gave a mandatory task (so we can pass to view if we want)
        $hasTask = $cekPresensi && !empty($cekPresensi->log_kerja);
        $isiLogKerja = $hasTask ? $cekPresensi->log_kerja : '';

        $pegawai = DB::table('pegawais')->where('id_pegawai', $id_pegawai)->first();
        $is_dinas_luar = $pegawai->is_dinas_luar ?? 0;

        return view('presensi.create', compact('cek', 'is_dinas_luar', 'hasTask', 'isiLogKerja'));
    }

    public function store(Request $request)
    {
        $id_pegawai = Auth::guard('pegawai')->user()->id_pegawai;
        $tgl_presensi = date('Y-m-d');

        $jam = Carbon::now('Asia/Jakarta')->format('H:i:s');
        $konfigurasi = DB::table('konfigurasi_lokasi')->first();
        if ($konfigurasi) {
            $lokasi_kantor = explode(",", $konfigurasi->titik_koordinat);
            $latitudekantor = $lokasi_kantor[0];
            $longitudekantor = $lokasi_kantor[1];
            $batas_radius = $konfigurasi->radius_meter;
        } else {
            $latitudekantor = -7.778497430337909;
            $longitudekantor = 110.40738509292642;
            $batas_radius = 100;
        }

        $lokasi = $request->lokasi;
        $lokasiuser = explode(",", $lokasi);
        $latitudeuser = $lokasiuser[0];
        $longitudeuser = $lokasiuser[1];

        $jarak = $this->distance($latitudekantor, $longitudekantor, $latitudeuser, $longitudeuser);
        $radius = round($jarak['meters']);

        $cek = DB::table('presensis')
            ->where('tgl_presensi', $tgl_presensi)
            ->where('id_pegawai', $id_pegawai)
            ->whereNotNull('jam_in')
            ->count();
        if ($cek > 0) {
            $ket = 'out';
        } else {
            $ket = 'in';
        }
        $image = $request->image;
        $fileName = $id_pegawai . '_' . $tgl_presensi . "-" . $ket . "_" . Carbon::now()->format('Ymd_His') . '.png';
        $image_parts = explode(";base64,", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $path = "uploads/absensi/" . $fileName;


        $pegawai = DB::table('pegawais')->where('id_pegawai', $id_pegawai)->first();
        $is_dinas_luar = $pegawai->is_dinas_luar ?? 0;

        if (!$is_dinas_luar && $jarak['meters'] > $batas_radius) {
            echo "error|Anda berada diluar area kantor (" . $radius . " meter dari " . $batas_radius . " meter yang ditentukan). Silahkan lakukan absensi di dalam area kantor.|";
            return;
        }
        if ($cek > 0) {
            // CLOCK OUT

            // Validasi jika ditugaskan oleh petugas (must finish task)
            $cekTask = DB::table('presensis')
                ->where('tgl_presensi', $tgl_presensi)
                ->where('id_pegawai', $id_pegawai)
                ->first();

            if ($cekTask && !empty($cekTask->log_kerja)) {
                // Must have uploaded file
                if (!$request->hasFile('berkas_log')) {
                    echo "error|Anda memiliki target log kerja hari ini. Harap upload Berkas Bukti penyelesaian sebelum Absen Pulang.|out";
                    return;
                }
            }

            $data_pulang = [
                'jam_out' => $jam,
                'foto_out' => $fileName,
                'lokasi_out' => $lokasi,
            ];

            if ($cekTask && !empty($cekTask->log_kerja)) {
                if ($request->has('log_kerja') && !empty($request->log_kerja)) {
                    $data_pulang['log_kerja'] = "[TUGAS PETUGAS]:\n" . $cekTask->log_kerja . "\n\n[CATATAN PEGAWAI]:\n" . $request->log_kerja;
                }
            } else {
                if ($request->has('log_kerja') && !empty($request->log_kerja)) {
                    $data_pulang['log_kerja'] = $request->log_kerja;
                }
            }

            if ($request->hasFile('berkas_log')) {
                $berkas_log = $request->file('berkas_log');
                $fileNameBerkas = $id_pegawai . '_' . $tgl_presensi . "_log_" . Carbon::now()->format('His') . '.' . $berkas_log->getClientOriginalExtension();
                $berkas_log->storeAs('uploads/log_kerja', $fileNameBerkas, 'supabase');
                $data_pulang['berkas_log'] = $fileNameBerkas;
            }

            $update = DB::table('presensis')
                ->where('tgl_presensi', $tgl_presensi)
                ->where('id_pegawai', $id_pegawai)
                ->update($data_pulang);

            if ($update) {
                echo "success|Sampai Jumpa! Hati-hati di jalan|out";
                Storage::disk('supabase')->put($path, $image_base64);

                // Notify admin/petugas
                $notifiables = User::whereIn('role', ['admin', 'petugas'])->get();
                Notification::send($notifiables, new PegawaiActivityNotification(
                    "Clock Out",
                    $pegawai->nama_lengkap . " (" . $pegawai->id_pegawai . ") baru saja absen pulang.",
                    "pulang",
                    "/presensi/monitoring"
                ));
            } else {
                echo "error|Gagal melakukan absensi pulang, silahkan coba lagi nanti.|out";
            }
        } else {
            // CLOCK IN
            $data = [
                'id_pegawai' => $id_pegawai,
                'tgl_presensi' => $tgl_presensi,
                'jam_in' => $jam,
                'foto_in' => $fileName,
                'lokasi_in' => $lokasi,
            ];

            // Check if record exists (maybe officer assigned a task beforehand)
            $existingPresensi = DB::table('presensis')
                ->where('id_pegawai', $id_pegawai)
                ->where('tgl_presensi', $tgl_presensi)
                ->first();

            if ($existingPresensi) {
                $simpan = DB::table('presensis')
                    ->where('id_presensi', $existingPresensi->id_presensi)
                    ->update([
                        'jam_in' => $jam,
                        'foto_in' => $fileName,
                        'lokasi_in' => $lokasi,
                    ]);
            } else {
                $simpan = DB::table('presensis')->insert($data);
            }
            if ($simpan) {
                echo "success| Selamat Bekerja! Semoga harimu menyenangkan|in";
                Storage::disk('supabase')->put($path, $image_base64);

                // Notify admin/petugas
                $notifiables = User::whereIn('role', ['admin', 'petugas'])->get();
                Notification::send($notifiables, new PegawaiActivityNotification(
                    "Clock In",
                    $pegawai->nama_lengkap . " (" . $pegawai->id_pegawai . ") baru saja absen masuk.",
                    "masuk",
                    "/presensi/monitoring"
                ));
            } else {
                echo "error|Gagal melakukan absensi masuk, silahkan coba lagi nanti.|in";
            }
            // Logic to store presensi data
        }
    }
    //Menghitung Jarak
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }

    public function editprofile()
    {
        $id_pegawai = Auth::guard('pegawai')->user()->id_pegawai;
        $data = DB::table('pegawais')->where('id_pegawai', $id_pegawai)->first();
        return view('presensi.editprofile', compact('data'));
    }

    public function updateprofile(Request $request)
    {
        $id_pegawai = Auth::guard('pegawai')->user()->id_pegawai;
        $nama_lengkap = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $password = $request->password;
        $pegawai = DB::table('pegawais')->where('id_pegawai', $id_pegawai)->first();
        if ($request->hasFile('foto')) {
            $foto = $id_pegawai . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = $pegawai->foto;
        }

        if (!empty($password)) {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'password' => Hash::make($password),
                'foto' => $foto,
            ];
        } else {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'foto' => $foto,
            ];
        }

        $update = DB::table('pegawais')->where('id_pegawai', $id_pegawai)->update($data);
        if ($update) {
            if ($request->hasFile('foto')) {
                $folderPath = 'uploads/pegawai/';
                $request->file('foto')->storeAs('uploads/pegawai', $foto, 'supabase');
            }
            return Redirect()->back()->with('success', 'Profile berhasil diupdate');
        } else {
            return Redirect()->back()->with('error', 'Gagal mengupdate profile, silahkan coba lagi nanti');
        }
    }

    public function histori()
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('presensi.histori', compact('namabulan'));
    }

    public function getHistori(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $id_pegawai = Auth::guard('pegawai')->user()->id_pegawai;

        $histori = DB::table('presensis')
            ->where('id_pegawai', $id_pegawai)
            ->whereMonth('tgl_presensi', $bulan)
            ->whereYear('tgl_presensi', $tahun)
            ->orderBy('tgl_presensi', 'desc')
            ->get();

        return view('presensi.gethistori', compact('histori'));
    }

    public function cetaklaporan(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $id_pegawai = Auth::guard('pegawai')->user()->id_pegawai;

        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $pegawai = DB::table('pegawais')->where('id_pegawai', $id_pegawai)->first();

        $histori = DB::table('presensis')
            ->where('id_pegawai', $id_pegawai)
            ->whereMonth('tgl_presensi', $bulan)
            ->whereYear('tgl_presensi', $tahun)
            ->orderBy('tgl_presensi', 'asc')
            ->get();

        return view('presensi.cetaklaporan', compact('bulan', 'tahun', 'namabulan', 'pegawai', 'histori'));
    }

    public function izin()
    {
        $id_pegawai = Auth::guard('pegawai')->user()->id_pegawai;
        $dataizin = DB::table('pengajuan_izin')
            ->where('id_pegawai', $id_pegawai)
            ->get();

        $tahun_ini = date('Y');
        $konfig = DB::table('konfigurasi_lokasi')->first();
        $kuota_tahunan = $konfig->kuota_cuti_tahunan ?? 12;

        $cuti_terpakai = DB::table('pengajuan_izin')
            ->where('id_pegawai', $id_pegawai)
            ->whereYear('tgl_izin', $tahun_ini)
            ->where('status_approved', '1') // Semua jenis yg disetujui mengurangi jatah? Atau minimal menghitung semua
            ->count();

        $sisa_cuti = $kuota_tahunan - $cuti_terpakai;

        return view('presensi.izin', compact('dataizin', 'sisa_cuti'));
    }

    public function cetaklaporancuti(Request $request)
    {
        $id_pegawai = Auth::guard('pegawai')->user()->id_pegawai;
        $pegawai = DB::table('pegawais')->where('id_pegawai', $id_pegawai)->first();

        $histori = DB::table('pengajuan_izin')
            ->where('id_pegawai', $id_pegawai)
            ->orderBy('tgl_izin', 'asc')
            ->get();

        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        return view('presensi.cetaklaporancuti', compact('pegawai', 'histori', 'namabulan'));
    }
    public function buatizin()
    {
        $id_pegawai = Auth::guard('pegawai')->user()->id_pegawai;
        $tahun_ini = date('Y');
        $konfig = DB::table('konfigurasi_lokasi')->first();
        $kuota_tahunan = $konfig->kuota_cuti_tahunan ?? 12;

        $cuti_terpakai = DB::table('pengajuan_izin')
            ->where('id_pegawai', $id_pegawai)
            ->whereYear('tgl_izin', $tahun_ini)
            ->where('status_approved', '1') // Semua jenis yg disetujui mengurangi jatah? Atau minimal menghitung semua
            ->count();

        $sisa_cuti = $kuota_tahunan - $cuti_terpakai;

        $kuorum = $konfig->kuorum_cuti_harian ?? 3;
        $disabled_dates = DB::table('pengajuan_izin')
            ->select('tgl_izin')
            ->where('tgl_izin', '>=', date('Y-m-d'))
            ->where('status_approved', '1') // Quorum hanya berlaku untuk yang disetujui (Approved)
            ->groupBy('tgl_izin')
            ->havingRaw('COUNT(DISTINCT id_pegawai) >= ?', [$kuorum])
            ->pluck('tgl_izin')
            ->toArray();

        return view('presensi.buatizin', compact('sisa_cuti', 'kuota_tahunan', 'disabled_dates'));
    }

    public function lokasi()
    {
        return view('presensi.lokasi');
    }

    public function storeizin(Request $request)
    {

        $id_pegawai = Auth::guard('pegawai')->user()->id_pegawai;
        $tgl_izin = $request->tgl_izin;
        $tgl_selesai_izin = $request->tgl_selesai_izin;
        $status = $request->status;
        $keterangan = $request->keterangan;

        $simpan = false;

        if (empty($tgl_selesai_izin)) {
            $tgl_selesai_izin = $tgl_izin;
        }

        $start_date = Carbon::parse($tgl_izin);
        $end_date = Carbon::parse($tgl_selesai_izin);

        $konfig = DB::table('konfigurasi_lokasi')->first();
        $kuorum_harian = $konfig->kuorum_cuti_harian ?? 3;
        $kuota_tahunan = $konfig->kuota_cuti_tahunan ?? 12;

        $tahun_ini = date('Y');
        $cuti_terpakai = DB::table('pengajuan_izin')
            ->where('id_pegawai', $id_pegawai)
            ->whereYear('tgl_izin', $tahun_ini)
            ->where('status_approved', '1') // Semua pengajuan yang disetujui mengurangi sisa cuti Anda.
            ->count();

        $sisa_cuti = $kuota_tahunan - $cuti_terpakai;
        $jumlah_hari = $start_date->diffInDays($end_date) + 1;

        if ($jumlah_hari > $sisa_cuti) {
            return redirect('/presensi/izin')->with('error', 'Sisa kuota cuti/izin Anda tidak mencukupi (Sisa: ' . $sisa_cuti . ' Hari).');
        }

        for ($date = $start_date; $date->lte($end_date); $date->addDay()) {
            $tgl = $date->format('Y-m-d');

            $existing_leaves = DB::table('pengajuan_izin')
                ->where('tgl_izin', $tgl)
                ->where('status_approved', '1') // Quorum cuti hanya berdasarkan yang Disetujui
                ->distinct('id_pegawai')
                ->count();

            if ($existing_leaves >= $kuorum_harian) {
                return redirect('/presensi/izin')
                    ->with('error', 'Gagal: Kuorum pelayanan cuti untuk tanggal ' . date('d-m-Y', strtotime($tgl)) . ' sudah penuh (Maks. ' . $kuorum_harian . ' pegawai).');
            }

            $data = [
                'id_pegawai' => $id_pegawai,
                'tgl_izin' => $tgl,
                'status' => $status,
                'keterangan' => $keterangan,
                'status_approved' => '0', // Pending
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Check if already exist to prevent duplicate
            $cek = DB::table('pengajuan_izin')
                ->where('id_pegawai', $id_pegawai)
                ->where('tgl_izin', $tgl)
                ->count();

            if ($cek == 0) {
                $simpan = DB::table('pengajuan_izin')->insert($data);
            }
        }


        if ($simpan) {
            // Notify admin/petugas
            $pegawai = DB::table('pegawais')->where('id_pegawai', $id_pegawai)->first();
            $notifiables = User::whereIn('role', ['admin', 'petugas'])->get();
            Notification::send($notifiables, new PegawaiActivityNotification(
                "Pengajuan Izin",
                $pegawai->nama_lengkap . " (" . $pegawai->id_pegawai . ") mengajukan " . $status . " mulai " . date('d/m/Y', strtotime($tgl_izin)) . ".",
                "izin",
                "/petugas/verifikasi-cuti"
            ));

            return redirect('/presensi/izin')
                ->with('success', 'Pengajuan berhasil dikirim.');
        } else {
            return redirect('/presensi/izin')
                ->with('error', 'Kuorum Penuh! Gagal mengirim pengajuan cuti pada tanggal tersebut.');
        }
    }

    public function monitoring()
    {
        return view('presensi.monitoring');
    }

    public function getpresensi(Request $request)
    {
        $tanggal = $request->tanggal;
        $presensi = DB::table('presensis')
            ->select('presensis.*', 'pegawais.nama_lengkap', 'departemens.nama_dept')
            ->join('pegawais', 'presensis.id_pegawai', '=', 'pegawais.id_pegawai')
            ->join('departemens', 'pegawais.kode_dept', '=', 'departemens.kode_dept')
            ->where('tgl_presensi', $tanggal)
            ->get();

        return view('presensi.getpresensi', compact('presensi'));
    }
}
