<?php

namespace App\Http\Controllers;

use App\Models\MutasiKeluar;
use App\Models\MutasiMasuk;
use Illuminate\View\View;

class MutasiController extends Controller
{
    public function index(): View
    {
        $mutasiMasuk = MutasiMasuk::get();
        $mutasiKeluar = MutasiKeluar::get();

        return view('mutasi.index', compact('mutasiMasuk', 'mutasiKeluar'));
    }
}
