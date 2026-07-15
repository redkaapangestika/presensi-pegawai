<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function proseslogin(Request $request)
    {
        if (Auth::guard('pegawai')->attempt(['id_pegawai' => $request->id_pegawai, 'password' => $request->password])) {
            return redirect('/dashboard');
        } else {
            return redirect('/login')->with('warning', 'Login Gagal! Silahkan Cek Id Pegawai dan Password Anda');
        }
    }

    public function proseslogout(Request $request)
    {
        Auth::guard('pegawai')->logout();
        Auth::guard('user')->logout();
        $request->session()->flush();
        return redirect('/login');
    }

    public function proseslogoutadmin(Request $request)
    {
        Auth::guard('user')->logout();
        Auth::guard('pegawai')->logout();
        $request->session()->flush();
        return redirect('/');
    }

    public function prosesloginadmin(Request $request)
    {
        if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('/panel/dashboardadmin');
        } else {
            return redirect('/panel')->with('warning', 'Login Gagal! Silahkan Cek Email dan Password Anda');
        }
    }

    public function settings()
    {
        $user = Auth::guard('user')->user();
        return view('admin.settings', compact('user'));
    }

    public function profile()
    {
        $user = Auth::guard('user')->user();
        return view('admin.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user_id = Auth::guard('user')->user()->id;
        $user = \Illuminate\Support\Facades\DB::table('users')->where('id', $user_id)->first();

        $data = [];
        if (!empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
            $foto = $user_id . "-" . time() . "." . $request->file('foto')->getClientOriginalExtension();
            $request->file('foto')->storeAs('uploads/admin', $foto, 'public');
            $data['foto'] = $foto;
        }

        if (count($data) > 0) {
            \Illuminate\Support\Facades\DB::table('users')->where('id', $user_id)->update($data);
            return redirect()->back()->with('success', 'Pengaturan berhasil disimpan!');
        }

        return redirect()->back()->with('warning', 'Tidak ada data yang diubah.');
    }

    public function updateLokasi(Request $request)
    {
        // Hanya bisa diakses admin/petugas
        $role = Auth::guard('user')->user()->role;
        if ($role !== 'admin' && $role !== 'petugas') {
            return redirect()->back()->with('warning', 'Anda tidak memiliki akses ini.');
        }

        $titik_koordinat = $request->titik_koordinat;
        $radius_meter = $request->radius_meter;
        $kuota_cuti_tahunan = $request->kuota_cuti_tahunan ?? 12;
        $kuorum_cuti_harian = $request->kuorum_cuti_harian ?? 3;

        $konfig = \Illuminate\Support\Facades\DB::table('konfigurasi_lokasi')->first();
        if ($konfig) {
            \Illuminate\Support\Facades\DB::table('konfigurasi_lokasi')
                ->where('id', $konfig->id)
                ->update([
                    'titik_koordinat' => $titik_koordinat,
                    'radius_meter' => $radius_meter,
                    'kuota_cuti_tahunan' => $kuota_cuti_tahunan,
                    'kuorum_cuti_harian' => $kuorum_cuti_harian,
                    'updated_at' => now(),
                ]);
        } else {
            \Illuminate\Support\Facades\DB::table('konfigurasi_lokasi')->insert([
                'titik_koordinat' => $titik_koordinat,
                'radius_meter' => $radius_meter,
                'kuota_cuti_tahunan' => $kuota_cuti_tahunan,
                'kuorum_cuti_harian' => $kuorum_cuti_harian,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Konfigurasi Lokasi dan Cuti berhasil diupdate!');
    }
}
