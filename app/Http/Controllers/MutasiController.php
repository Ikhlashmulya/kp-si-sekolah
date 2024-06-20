<?php

namespace App\Http\Controllers;

use App\Models\MutasiKeluar;
use App\Models\MutasiMasuk;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

Carbon::setLocale('id');

class MutasiController extends Controller
{
    public function index(): View
    {
        $mutasiMasuk = MutasiMasuk::all()->map(function ($value) {
            $value->tgl_masuk = Carbon::parse($value->tgl_masuk)->format('d-F-Y');
            return $value;
        });

        $mutasiKeluar = MutasiKeluar::all()->map(function ($value) {
            $value->tgl_keluar = Carbon::parse($value->tgl_keluar)->format('d-F-Y');
            return $value;
        });

        $dateMutasiMasuk = $postsDates = MutasiMasuk::selectRaw('strftime(\'%Y\', tgl_masuk) as year, strftime(\'%m\', tgl_masuk) as month');
        $distinctMonthsAndYears = MutasiKeluar::selectRaw('strftime(\'%Y\', tgl_keluar) as year, strftime(\'%m\', tgl_keluar) as month')
            ->union($dateMutasiMasuk)
            ->distinct()
            ->get()
            ->map(function ($date) {
                return [
                    'year' => $date->year,
                    'month' => Carbon::createFromFormat('!m', $date->month)->locale('id')->translatedFormat('F') . ' ' . $date->year
                ];
            });

        // dd($distinctMonthsAndYears[0]['month']);

        return view('mutasi.index', compact('mutasiMasuk', 'mutasiKeluar', 'distinctMonthsAndYears'));
    }

    public function keluar(Siswa $siswa): View
    {
        return view('mutasi.keluar', compact('siswa'));
    }

    public function doMutasiKeluar(Request $request): RedirectResponse
    {
        $siswaId = $request->input('siswa_id');
        $tujuanSekolah = $request->input('tujuan_sekolah');
        $tglKeluar = $request->input('tgl_keluar');

        DB::table('mutasi_keluar')->insert([
            'siswa_id' => $siswaId,
            'tujuan_sekolah' => $tujuanSekolah,
            'tgl_keluar' => $tglKeluar
        ]);

        return redirect('/mutasi');
    }
}
