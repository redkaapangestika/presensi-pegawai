<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
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

        
        if($jarak['meters'] > 100){
            echo "error|Anda berada diluar area kantor (".$radius." meter dari kantor). Silahkan lakukan absensi di dalam area kantor.|";
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
}
