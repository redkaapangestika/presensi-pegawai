<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PresensiController;
use Illuminate\Support\Facades\Route;



Route::middleware(['guest:pegawai'])->group(function() {
    Route::get('/', function () {
    return view('auth.login');
    })->name('login');
    Route::post('/proseslogin', [App\Http\Controllers\AuthController::class, 'proseslogin']);
});

Route::middleware(['guest:user'])->group(function() {
    Route::get('/panel', function () {
    return view('auth.loginadmin');
    })->name('loginadmin');

    Route::post('/prosesloginadmin', [App\Http\Controllers\AuthController::class, 'prosesloginadmin']);
});

Route::middleware(['auth:pegawai'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/proseslogout', [App\Http\Controllers\AuthController::class, 'proseslogout']);

    Route::get('/presensi/create', [App\Http\Controllers\PresensiController::class, 'create']);
    Route::post('/presensi/store', [App\Http\Controllers\PresensiController::class, 'store']);

    Route::get('/editprofile', [App\Http\Controllers\PresensiController::class, 'editprofile']);
    Route::post('/presensi/updateprofile', [App\Http\Controllers\PresensiController::class, 'updateprofile']);

    //Histori Presensi
    Route::get('/presensi/histori', [App\Http\Controllers\PresensiController::class, 'histori']);
    Route::post('/presensi/gethistori', [App\Http\Controllers\PresensiController::class, 'getHistori']);

    //Izin
    Route::get('/presensi/izin', [App\Http\Controllers\PresensiController::class, 'izin']);
    Route::get('/presensi/buatizin', [App\Http\Controllers\PresensiController::class, 'buatizin']);
    Route::post('/presensi/storeizin', [App\Http\Controllers\PresensiController::class, 'storeizin']);
});

Route::middleware(['auth:user'])->group(function () {
    Route::get('/proseslogoutadmin', [App\Http\Controllers\AuthController::class, 'proseslogoutadmin']);
    Route::get('/panel/dashboardadmin', [App\Http\Controllers\DashboardController::class, 'dashboardadmin']);

    //Pegawai
    Route::get('/pegawai', [App\Http\Controllers\PegawaiController::class, 'index']);
    Route::post('/pegawai/store', [App\Http\Controllers\PegawaiController::class, 'store']);
    Route::post('/pegawai/edit', [App\Http\Controllers\PegawaiController::class, 'edit']);
    Route::post('/pegawai/{id}/update', [App\Http\Controllers\PegawaiController::class, 'update']);
    Route::post('/pegawai/{id}/delete', [App\Http\Controllers\PegawaiController::class, 'delete']);

    //Departemen
    Route::get('/departemen', [App\Http\Controllers\DepartemenController::class, 'index']);
    Route::post('/departemen/store', [App\Http\Controllers\DepartemenController::class, 'store']);
    Route::post('/departemen/edit', [App\Http\Controllers\DepartemenController::class, 'edit']);
    Route::post('/departemen/{kode_dept}/update', [App\Http\Controllers\DepartemenController::class, 'update']);
    Route::post('/departemen/{kode_dept}/delete', [App\Http\Controllers\DepartemenController::class, 'delete']);

    //Presensi
    Route::get('/presensi/monitoring', [App\Http\Controllers\PresensiController::class, 'monitoring']);
    Route::post('/getpresensi', [App\Http\Controllers\PresensiController::class, 'getpresensi']);
});

