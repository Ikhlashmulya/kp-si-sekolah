<?php

namespace App\Http\Controllers;

use App\Models\MutasiKeluar;
use App\Models\MutasiMasuk;
use App\Models\Siswa;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View {
        $siswa = Siswa::all()->count();
        $jmlMutasiMasuk = MutasiMasuk::whereRaw('strftime(\'%Y\', tgl_masuk) = ?', [date('Y')])->whereRaw('strftime(\'%m\', tgl_masuk) = ?', [date('m')])->count();
        $jmlMutasiKeluar = MutasiKeluar::whereRaw('strftime(\'%Y\', tgl_keluar) = ?', [date('Y')])->whereRaw('strftime(\'%m\', tgl_keluar) = ?', [date('m')])->count();

        return view('index', compact('siswa', 'jmlMutasiMasuk', 'jmlMutasiKeluar'));
    }
}
