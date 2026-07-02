<?php

use App\Http\Controllers\DashboardController;
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

Route::get('/dashboardadmin', [App\Http\Controllers\DashboardController::class, 'dashboardadmin']);