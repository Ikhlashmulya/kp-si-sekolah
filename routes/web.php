<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Middleware\AuthenticationMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->middleware([AuthenticationMiddleware::class]);

Route::get('/datasiswa', function () {
    return view('data-siswa');
})->name('data-siswa')->middleware([AuthenticationMiddleware::class]);

Route::post('/login', [AuthenticationController::class, 'doLogin'])->name('doLogin');
Route::post('/logout', [AuthenticationController::class, 'doLogout'])->name('doLogout');

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('login');
});
