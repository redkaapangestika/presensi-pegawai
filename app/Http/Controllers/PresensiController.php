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
        return view('presensi.create');
    }

    public function store(Request $request)
    {
        $id_pegawai = Auth::guard('pegawai')->user()->id_pegawai;
        $tgl_presensi = date('Y-m-d');

        $cek = Presensi::where('id_pegawai', $id_pegawai)
            ->where('tgl_presensi', $tgl_presensi)
            ->exists();

        if ($cek) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda sudah presensi hari ini'
            ], 400);
        }

        $jam = Carbon::now('Asia/Jakarta')->format('H:i:s');
        $lokasi = $request->lokasi;
        $image = $request->image;
        $folderPath = "public/uploads/absensi/";
        $fileName = $id_pegawai . '_' . Carbon::now()->format('Ymd_His') . '.png';
        $image_parts = explode(";base64,", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = Str::uuid() . '.png';
        $path = "uploads/absensi/" . $fileName;
        $data = [
            'id_pegawai' => $id_pegawai,
            'tgl_presensi' => $tgl_presensi,
            'jam_in' => $jam,
            'foto_in' => $fileName,
            'lokasi_in' => $lokasi,
        ];
        $simpan = DB::table('presensis')->insert($data);
        if ($simpan) {
            echo 0;
            Storage::disk('public')->put($path, $image_base64);
        } else {
            echo 1;
        }
        // Logic to store presensi data
    }
}
