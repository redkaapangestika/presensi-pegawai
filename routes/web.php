<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetugasController;

// =========================================================================
// 1. LOGOUT ROUTES (Bebas Middleware - Harus di atas agar tidak terkena auth)
// =========================================================================
Route::match(['get', 'post'], '/proseslogout', [AuthController::class, 'proseslogout']);
Route::match(['get', 'post'], '/proseslogoutadmin', [AuthController::class, 'proseslogoutadmin']);

// =========================================================================
// 2. GUEST ROUTES (Belum Login)
// =========================================================================

// Landing Page Universal
Route::get('/', function () {
    return view('welcome');
})->name('landing');

// Gerbang Login Pegawai
Route::middleware(['guest:pegawai', 'nocache'])->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
    Route::post('/proseslogin', [AuthController::class, 'proseslogin']);
});

// Gerbang Login Pengelola (Admin, Petugas, Lurah)
Route::middleware(['nocache'])->group(function () {
    Route::get('/panel', function () {
        if (\Illuminate\Support\Facades\Auth::guard('user')->check()) {
            return redirect('/panel/dashboardadmin');
        }
        return view('auth.loginadmin');
    })->name('loginadmin');
    Route::post('/panel', [AuthController::class, 'prosesloginadmin']);
    Route::post('/prosesloginadmin', [AuthController::class, 'prosesloginadmin']);
});


// =========================================================================
// 2. AUTH ROUTES : PEGAWAI (Tampilan Mobile App)
// =========================================================================
Route::middleware(['auth:pegawai', 'nocache'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Presensi
    Route::get('/presensi/create', [PresensiController::class, 'create']);
    Route::post('/presensi/store', [PresensiController::class, 'store']);

    // Profil
    Route::get('/editprofile', [PresensiController::class, 'editprofile']);
    Route::post('/presensi/updateprofile', [PresensiController::class, 'updateprofile']);

    // Histori Presensi
    Route::get('/presensi/histori', [PresensiController::class, 'histori']);
    Route::post('/presensi/gethistori', [PresensiController::class, 'getHistori']);
    Route::get('/presensi/cetaklaporan', [PresensiController::class, 'cetaklaporan']);

    // Izin & Lokasi
    Route::get('/presensi/izin', [PresensiController::class, 'izin']);
    Route::get('/presensi/buatizin', [PresensiController::class, 'buatizin']);
    Route::post('/presensi/storeizin', [PresensiController::class, 'storeizin']);
    Route::get('/presensi/cetaklaporancuti', [PresensiController::class, 'cetaklaporancuti']);
    Route::get('/presensi/lokasi', [PresensiController::class, 'lokasi']);
});


// =========================================================================
// 3. AUTH ROUTES : PENGELOLA (Tampilan Desktop / Admin Panel)
// =========================================================================
Route::middleware(['auth:user', 'nocache'])->group(function () {

    // Bisa Diakses Semua Pengelola (Admin, Petugas, Lurah)
    Route::get('/panel/dashboardadmin', [DashboardController::class, 'dashboardadmin']);
    Route::get('/panel/settings', [AuthController::class, 'settings']);
    Route::post('/panel/settings/lokasi', [AuthController::class, 'updateLokasi']);

    // Profil Admin
    Route::get('/panel/profile', [AuthController::class, 'profile']);
    Route::post('/panel/profile', [AuthController::class, 'updateProfile']);

    // --------------------------------------------------------
    // HAK AKSES KHUSUS ADMIN (Manajemen Data Master)
    // --------------------------------------------------------
    Route::middleware(['role:admin'])->group(function () {
        // Pegawai
        Route::get('/pegawai', [PegawaiController::class, 'index']);
        Route::post('/pegawai/store', [PegawaiController::class, 'store']);
        Route::post('/pegawai/edit', [PegawaiController::class, 'edit']);
        Route::post('/pegawai/{id}/update', [PegawaiController::class, 'update']);
        Route::post('/pegawai/{id}/delete', [PegawaiController::class, 'delete']);

        // Departemen
        Route::get('/departemen', [DepartemenController::class, 'index']);
        Route::post('/departemen/store', [DepartemenController::class, 'store']);
        Route::post('/departemen/edit', [DepartemenController::class, 'edit']);
        Route::post('/departemen/{kode_dept}/update', [DepartemenController::class, 'update']);
        Route::post('/departemen/{kode_dept}/delete', [DepartemenController::class, 'delete']);

        // Data Pengelola Sistem (Users)
        Route::get('/users', [\App\Http\Controllers\UserController::class, 'index']);
        Route::post('/users/store', [\App\Http\Controllers\UserController::class, 'store']);
        Route::post('/users/edit', [\App\Http\Controllers\UserController::class, 'edit']);
        Route::post('/users/{id}/update', [\App\Http\Controllers\UserController::class, 'update']);
        Route::post('/users/{id}/delete', [\App\Http\Controllers\UserController::class, 'delete']);
    });

    // --------------------------------------------------------
    // HAK AKSES KHUSUS PETUGAS (Operasional & Verifikasi)
    // --------------------------------------------------------
    Route::middleware(['role:petugas'])->group(function () {
        // Monitoring Presensi
        Route::get('/presensi/monitoring', [PresensiController::class, 'monitoring']);
        Route::post('/getpresensi', [PresensiController::class, 'getpresensi']);

        // Atur Jadwal Kerja
        Route::get('/petugas/jadwal', [PetugasController::class, 'jadwal']);
        Route::post('/petugas/jadwal', [PetugasController::class, 'storeJadwal']);
        Route::post('/petugas/dinasluar', [PetugasController::class, 'setDinasLuar']);

        // Verifikasi Cuti / Izin
        Route::get('/petugas/verifikasi-cuti', [PetugasController::class, 'verifikasiCuti']);
        Route::post('/petugas/verifikasi-cuti/update', [PetugasController::class, 'updateCuti']);

        // Validasi Presensi
        Route::get('/petugas/validasi-presensi', [PetugasController::class, 'validasiPresensi']);
        Route::post('/petugas/validasi-presensi/update', [PetugasController::class, 'updateValidasi']);
        Route::post('/getpresensi-validasi', [PetugasController::class, 'getpresensiValidasi']);
    });

    // --------------------------------------------------------
    // HAK AKSES LURAH, PETUGAS & ADMIN (Melihat Laporan)
    // --------------------------------------------------------
    Route::middleware(['role:lurah,petugas,admin'])->group(function () {
        Route::get('/panel/laporan/presensi', [\App\Http\Controllers\LaporanController::class, 'presensi']);
        Route::post('/panel/laporan/presensi/cetak', [\App\Http\Controllers\LaporanController::class, 'cetakPresensi']);

        Route::get('/panel/laporan/kinerja', [\App\Http\Controllers\LaporanController::class, 'kinerja']);
        Route::post('/panel/laporan/kinerja/cetak', [\App\Http\Controllers\LaporanController::class, 'cetakKinerja']);

        Route::get('/panel/laporan/cuti', [\App\Http\Controllers\LaporanController::class, 'cuti']);
        Route::post('/panel/laporan/cuti/cetak', [\App\Http\Controllers\LaporanController::class, 'cetakCuti']);

        Route::get('/panel/laporan/pegawai', [\App\Http\Controllers\LaporanController::class, 'pegawai']);
        Route::post('/panel/laporan/pegawai/cetak', [\App\Http\Controllers\LaporanController::class, 'cetakPegawai']);
    });

});