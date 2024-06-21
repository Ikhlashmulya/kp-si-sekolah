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

class MutasiController extends Controller
{
    public function index(Request $request): View
    {
        $filterMutasi = $request->input('date', 'semua');
        $dataForViewFilterMutasi = $filterMutasi;

        if ($filterMutasi !== 'semua') {
            $filterMutasi = Carbon::parse($filterMutasi)->format('m-Y');
        }

        $mutasiMasuk = null;
        $mutasiKeluar = null;

        if ($filterMutasi === 'semua') {
            $mutasiMasuk = MutasiMasuk::all()->map(function ($value) {
                $value->tgl_masuk = Carbon::parse($value->tgl_masuk)->format('d-F-Y');
                return $value;
            });

            $mutasiKeluar = MutasiKeluar::all()->map(function ($value) {
                $value->tgl_keluar = Carbon::parse($value->tgl_keluar)->format('d-F-Y');
                return $value;
            });
        } else {
            list($month, $year) = explode('-', $filterMutasi);

            $mutasiMasuk = MutasiMasuk::whereRaw('strftime(\'%Y\', tgl_masuk) = ?', [$year])->whereRaw('strftime(\'%m\', tgl_masuk) = ?', [$month])->get()->map(function ($value) {
                $value->tgl_masuk = Carbon::parse($value->tgl_masuk)->format('d-F-Y');
                return $value;
            });

            $mutasiKeluar = MutasiKeluar::whereRaw('strftime(\'%Y\', tgl_keluar) = ?', [$year])->whereRaw('strftime(\'%m\', tgl_keluar) = ?', [$month])->get()->map(function ($value) {
                $value->tgl_keluar = Carbon::parse($value->tgl_keluar)->format('d-F-Y');
                return $value;
            });
        }

        $dateMutasiMasuk = $postsDates = MutasiMasuk::selectRaw('strftime(\'%Y\', tgl_masuk) as year, strftime(\'%m\', tgl_masuk) as month');
        $distinctMonthsAndYears = MutasiKeluar::selectRaw('strftime(\'%Y\', tgl_keluar) as year, strftime(\'%m\', tgl_keluar) as month')
            ->union($dateMutasiMasuk)
            ->distinct()
            ->get()
            ->map(function ($date) {
                return [
                    'year' => $date->year,
                    'month' => Carbon::createFromFormat('!m', $date->month)->translatedFormat('F') . ' ' . $date->year
                ];
            });


        return view('mutasi.index', compact('mutasiMasuk', 'mutasiKeluar', 'distinctMonthsAndYears', 'dataForViewFilterMutasi'));
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
