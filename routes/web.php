<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Middleware\AuthenticationMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->middleware([AuthenticationMiddleware::class]);

Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa')->middleware([AuthenticationMiddleware::class]);
Route::post('/siswa', [SiswaController::class, 'store'])->name('siswa.add')->middleware([AuthenticationMiddleware::class]);

Route::post('/login', [AuthenticationController::class, 'doLogin'])->name('doLogin');
Route::post('/logout', [AuthenticationController::class, 'doLogout'])->name('doLogout');
Route::post('/register', [AuthenticationController::class, 'doRegister'])->name('doRegister');

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/kelas', [KelasController::class, 'index'])->name('kelas')->middleware([AuthenticationMiddleware::class]);
Route::post('/kelas', [KelasController::class, 'store'])->name('addKelas')->middleware([AuthenticationMiddleware::class]);
Route::get('/kelas/delete', [KelasController::class, 'delete'])->middleware([AuthenticationMiddleware::class]);

Route::get('/mutasi', function () {
    return view('mutasi');
})->name('mutasi');
