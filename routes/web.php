<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MutasiController;
use App\Http\Controllers\SiswaController;
use App\Http\Middleware\AuthenticationMiddleware;
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
    Route::get('/', function () {
        return view('index');
    });

    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa');
    Route::post('/siswa', [SiswaController::class, 'store'])->name('siswa.add');
    Route::get('/siswa/{siswa}', [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::post('/siswa/{siswa}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::get('/siswa/{siswa}/delete', [SiswaController::class, 'delete'])->name('siswa.delete');

    Route::get('/kelas', [KelasController::class, 'index'])->name('kelas');
    Route::post('/kelas', [KelasController::class, 'store'])->name('kelas.add');
    Route::get('/kelas/delete', [KelasController::class, 'delete']);

    Route::get('/mutasi', [MutasiController::class, 'index'])->name('mutasi');
});
