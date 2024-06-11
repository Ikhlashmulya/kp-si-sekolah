<?php

use App\Http\Middleware\AuthenticationMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->middleware([AuthenticationMiddleware::class]);

Route::get('/datasiswa', function () {
    return view('data-siswa');
})->name('data-siswa');
