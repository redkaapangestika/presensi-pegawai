<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function proseslogin(Request $request)
    {
        if (Auth::guard('pegawai')->attempt(['id_pegawai' => $request->id_pegawai, 'password' => $request->password])){
            return redirect('/dashboard');
        } else {
            return redirect('/')->with('warning', 'Login Gagal! Silahkan Cek Id Pegawai dan Password Anda');
        }
    }

    public function proseslogout(Request $request){
        if (Auth::guard('pegawai')->check()) {
            Auth::guard('pegawai')->logout();
            return redirect('/');
        }

        if (Auth::guard('user')->check()) {
            Auth::guard('user')->logout();
            return redirect('/panel');
        }
    }

    public function proseslogoutadmin(Request $request){
        if (Auth::guard('user')->check()) {
            Auth::guard('user')->logout();
            return redirect('/panel');
        }
    }

    public function prosesloginadmin(Request $request)
    {
        if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect('/panel/dashboardadmin');
        } else {
            return redirect('/panel')->with('warning', 'Login Gagal! Silahkan Cek Email dan Password Anda');
        }
    }
}
