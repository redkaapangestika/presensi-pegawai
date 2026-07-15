<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = DB::table('users')->orderBy('id')->get();
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        try {
            DB::table('users')->insert([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            return redirect()->back()->with('success', 'Pengelola Sistem berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', 'Gagal menambahkan Pengelola Sistem: ' . $e->getMessage());
        }
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $user = DB::table('users')->where('id', $id)->first();
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'updated_at' => now()
        ];

        if (!empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        }

        try {
            DB::table('users')->where('id', $id)->update($data);
            return redirect()->back()->with('success', 'Data Pengelola Sistem berhasil diupdate.');
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', 'Gagal mengupdate Data Pengelola Sistem.');
        }
    }

    public function delete($id)
    {
        // Hindari hapus diri sendiri jika kebetulan
        if (Auth::guard('user')->user()->id == $id) {
            return redirect()->back()->with('warning', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        try {
            DB::table('users')->where('id', $id)->delete();
            return redirect()->back()->with('success', 'Data Pengelola Sistem berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', 'Gagal menghapus Data Pengelola Sistem.');
        }
    }
}
