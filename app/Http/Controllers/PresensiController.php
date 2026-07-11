<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Presensi;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PresensiController extends Controller
{
    public function create()
    {
        $hariini = date('Y-m-d');
        $id_pegawai = Auth::guard('pegawai')->user()->id_pegawai;
        $cek = DB::table('presensis')
            ->where('tgl_presensi', $hariini)
            ->where('id_pegawai', $id_pegawai)
            ->count();
        return view('presensi.create', compact('cek'));
    }

    public function store(Request $request)
    {
        $id_pegawai = Auth::guard('pegawai')->user()->id_pegawai;
        $tgl_presensi = date('Y-m-d');

        $jam = Carbon::now('Asia/Jakarta')->format('H:i:s');
        $latitudekantor = -7.778497430337909;
        $longitudekantor = 110.40738509292642;
        $lokasi = $request->lokasi;
        $lokasiuser = explode(",", $lokasi);
        $latitudeuser = $lokasiuser[0];
        $longitudeuser = $lokasiuser[1];

        $jarak = $this->distance($latitudekantor, $longitudekantor, $latitudeuser, $longitudeuser);
        $radius = round($jarak['meters']);

        $cek = DB::table('presensis')
            ->where('tgl_presensi', $tgl_presensi)
            ->where('id_pegawai', $id_pegawai)
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


        if ($jarak['meters'] > 100) {
            echo "error|Anda berada diluar area kantor (" . $radius . " meter dari kantor). Silahkan lakukan absensi di dalam area kantor.|";
            return;
        }
        if ($cek > 0) {
            // CLOCK OUT
            $data_pulang = [
                'jam_out' => $jam,
                'foto_out' => $fileName,
                'lokasi_out' => $lokasi,
            ];
            $update = DB::table('presensis')
                ->where('tgl_presensi', $tgl_presensi)
                ->where('id_pegawai', $id_pegawai)
                ->update($data_pulang);
            if ($update) {
                echo "success|Sampai Jumpa! Hati-hati di jalan|out";
                Storage::disk('public')->put($path, $image_base64);
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
            $simpan = DB::table('presensis')->insert($data);
            if ($simpan) {
                echo "success| Selamat Bekerja! Semoga harimu menyenangkan|in";
                Storage::disk('public')->put($path, $image_base64);
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
        $miles = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
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
                $request->file('foto')->storeAs('uploads/pegawai', $foto, 'public');
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

    public function izin()
    {
        $id_pegawai = Auth::guard('pegawai')->user()->id_pegawai;
        $dataizin = DB::table('pengajuan_izin')
            ->where('id_pegawai', $id_pegawai)
            ->get();
        return view('presensi.izin', compact('dataizin'));
    }
    public function buatizin()
    {
        
        return view('presensi.buatizin');
    }

    public function storeizin(Request $request)
    {

        $id_pegawai = Auth::guard('pegawai')->user()->id_pegawai;
        $tgl_izin = $request->tgl_izin;
        $status = $request->status;
        $keterangan = $request->keterangan;

        $data = [
            'id_pegawai' => $id_pegawai,
            'tgl_izin' => $tgl_izin,
            'status' => $status,
            'keterangan' => $keterangan,
            'status_approved' => '0', // Pending
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $simpan = DB::table('pengajuan_izin')->insert($data);

        if ($simpan) {
            return redirect('/presensi/izin')
                ->with('success', 'Pengajuan izin berhasil dikirim.');
        } else {
            return redirect('/presensi/izin')
                ->with('error', 'Gagal mengirim pengajuan izin.');
        }
    }

    public function monitoring()
    {
        return view('presensi.monitoring');   
    }

    public function getpresensi(Request $request){
        $tanggal = $request->tanggal;
        $presensi = DB::table('presensis')
        ->select('presensis.*','pegawais.nama_lengkap','departemens.nama_dept')
        ->join('pegawais','presensis.id_pegawai','=','pegawais.id_pegawai')
        ->join('departemens','pegawais.kode_dept','=','departemens.kode_dept')
        ->where('tgl_presensi',$tanggal)
        ->get();

        return view('presensi.getpresensi',compact('presensi'));
    }
}
