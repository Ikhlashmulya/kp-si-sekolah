<?php

namespace App\Http\Controllers;

use App\Models\MutasiKeluar;
use App\Models\MutasiMasuk;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
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
