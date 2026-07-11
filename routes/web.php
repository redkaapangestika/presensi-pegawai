<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetugasController;

// =========================================================================
// 1. GUEST ROUTES (Belum Login)
// =========================================================================

// Gerbang Login Pegawai
Route::middleware(['guest:pegawai'])->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');
    Route::post('/proseslogin', [AuthController::class, 'proseslogin']);
});

// Gerbang Login Pengelola (Admin, Petugas, Lurah)
Route::middleware(['guest:user'])->group(function () {
    Route::get('/panel', function () {
        return view('auth.loginadmin');
    })->name('loginadmin');
    Route::post('/panel', [AuthController::class, 'prosesloginadmin']);
    Route::post('/prosesloginadmin', [AuthController::class, 'prosesloginadmin']);
});


// =========================================================================
// 2. AUTH ROUTES : PEGAWAI (Tampilan Mobile App)
// =========================================================================
Route::middleware(['auth:pegawai'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/proseslogout', [AuthController::class, 'proseslogout']);

    // Presensi
    Route::get('/presensi/create', [PresensiController::class, 'create']);
    Route::post('/presensi/store', [PresensiController::class, 'store']);

    // Profil
    Route::get('/editprofile', [PresensiController::class, 'editprofile']);
    Route::post('/presensi/updateprofile', [PresensiController::class, 'updateprofile']);

    // Histori Presensi
    Route::get('/presensi/histori', [PresensiController::class, 'histori']);
    Route::post('/presensi/gethistori', [PresensiController::class, 'getHistori']);

    // Izin
    Route::get('/presensi/izin', [PresensiController::class, 'izin']);
    Route::get('/presensi/buatizin', [PresensiController::class, 'buatizin']);
    Route::post('/presensi/storeizin', [PresensiController::class, 'storeizin']);
});


// =========================================================================
// 3. AUTH ROUTES : PENGELOLA (Tampilan Desktop / Admin Panel)
// =========================================================================
Route::middleware(['auth:user'])->group(function () {

    // Bisa Diakses Semua Pengelola (Admin, Petugas, Lurah)
    Route::get('/proseslogoutadmin', [AuthController::class, 'proseslogoutadmin']);
    Route::get('/panel/dashboardadmin', [DashboardController::class, 'dashboardadmin']);

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

        // Verifikasi Cuti / Izin
        Route::get('/petugas/verifikasi-cuti', [PetugasController::class, 'verifikasiCuti']);
        Route::post('/petugas/verifikasi-cuti/update', [PetugasController::class, 'updateCuti']);

        // Validasi Presensi
        Route::get('/petugas/validasi-presensi', [PetugasController::class, 'validasiPresensi']);
        Route::post('/petugas/validasi-presensi/update', [PetugasController::class, 'updateValidasi']);
        Route::post('/getpresensi-validasi', [PetugasController::class, 'getpresensiValidasi']);
    });

    // --------------------------------------------------------
    // HAK AKSES LURAH & PETUGAS (Melihat Laporan)
    // --------------------------------------------------------
    Route::middleware(['role:lurah,petugas'])->group(function () {
        // (Nanti route laporan presensi, cuti, dll kita tambahkan di sini)
    });

});