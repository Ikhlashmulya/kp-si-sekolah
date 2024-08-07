<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MutasiController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\SiswaController;
use App\Http\Middleware\AuthenticationMiddleware;
use App\service\UserService;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthenticationController::class, 'doLogin'])->name('doLogin');
Route::post('/logout', [AuthenticationController::class, 'doLogout'])->name('doLogout');
Route::post('/register', [AuthenticationController::class, 'doRegister'])->name('doRegister');

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

Route::middleware([AuthenticationMiddleware::class])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');

    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa');
    Route::post('/siswa', [SiswaController::class, 'store'])->name('siswa.add');
    Route::get('/siswa/{siswa}', [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::post('/siswa/{siswa}', [SiswaController::class, 'update'])->name('siswa.update');

    Route::get('/kelas', [KelasController::class, 'index'])->name('kelas');
    Route::post('/kelas', [KelasController::class, 'store'])->name('kelas.add');
    Route::get('/kelas/delete', [KelasController::class, 'delete']);

    Route::get('/mutasi', [MutasiController::class, 'index'])->name('mutasi');
    Route::get('/siswa/{siswa}/keluar', [MutasiController::class, 'keluar'])->name('siswa.keluar');
    Route::post('/mutasi/keluar', [MutasiController::class, 'doMutasiKeluar'])->name('mutasi.keluar');

    Route::get('/rekap', [RekapController::class, 'index'])->name('rekap');
    Route::get('/rekap/bulanan/export/{date}', [RekapController::class, 'exportRekapBulanan']);
    Route::get('/rekap/tahunan/export/{year}', [RekapController::class, 'exportRekapTahunan']);
});
