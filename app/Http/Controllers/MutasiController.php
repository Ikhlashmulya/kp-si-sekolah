<?php

namespace App\Http\Controllers;

use App\Models\MutasiKeluar;
use App\Models\MutasiMasuk;
use App\Models\Siswa;
use App\Service\MutasiService;
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
        $filterForView = $filterMutasi;

        if ($filterMutasi !== 'semua') {
            $filterMutasi = Carbon::parse($filterMutasi)->format('m-Y');
        }

        $mutasiMasuk = MutasiService::getMutasiMasuk($filterMutasi);
        $mutasiKeluar = MutasiService::getMutasiKeluar($filterMutasi);
        $rekapMutasi = MutasiService::getRekap($filterMutasi); //nullable
        $dates = MutasiService::getDates();


        return view('mutasi.index', compact('mutasiMasuk', 'mutasiKeluar', 'dates', 'filterForView', 'rekapMutasi'));
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
        $keterangan = $request->input('keterangan');

        $siswa = Siswa::find($siswaId);

        DB::table('mutasi_keluar')->insert([
            'siswa_id' => $siswaId,
            'tujuan_sekolah' => $tujuanSekolah,
            'tgl_keluar' => $tglKeluar,
            'keterangan' => $keterangan,
            'kelas_id' => $siswa->kelas_id
        ]);

        $siswa->delete();

        return redirect('/mutasi');
    }
}
