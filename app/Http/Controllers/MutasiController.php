<?php

namespace App\Http\Controllers;

use App\Dto\GetMutasiByDateDto;
use App\Exports\RekapExport;
use App\Models\MutasiKeluar;
use App\Models\MutasiMasuk;
use App\Models\Siswa;
use App\Service\MutasiService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class MutasiController extends Controller
{
    public function index(Request $request): View
    {
        $date = $request->input('date', 'semua');
        $filterForView = $date;

        $mutasiMasuk = null;
        $mutasiKeluar = null;

        if ($date !== 'semua') {
            $date = Carbon::parse($date)->format('m-Y');
            
            list($month, $year) = explode('-', $date);

            $requestGetMutasiByDate = new GetMutasiByDateDto($month, $year);
            $mutasiMasuk = MutasiService::getMutasiMasukByDate($requestGetMutasiByDate);
            $mutasiKeluar = MutasiService::getMutasiKeluarByDate($requestGetMutasiByDate);
        } else {
            $mutasiMasuk = MutasiService::getAllMutasiMasuk();
            $mutasiKeluar = MutasiService::getAllMutasiKeluar();
        }

        $rekapMutasi = MutasiService::getRekapBulanan($date); //nullable
        $sumRekap = MutasiService::sumRekapBulanan($rekapMutasi);
        $dates = MutasiService::getDates();
        $rekapTahunan = MutasiService::getRekapTahunan(2024);


        return view('mutasi.index', compact('mutasiMasuk', 'mutasiKeluar', 'dates', 'filterForView', 'rekapMutasi', 'date', 'sumRekap', 'rekapTahunan'));
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

    public function export(string $date)
    {
        $rekapMutasi = MutasiService::getRekapBulanan($date);
        $mutasiMasuk = MutasiService::getMutasiMasuk($date);
        $mutasiKeluar = MutasiService::getMutasiKeluar($date);
        list($month, $year) = explode('-', $date);
        $date = Carbon::create($year, $month)->format('F-Y');
        return Excel::download(new RekapExport($mutasiMasuk, $mutasiKeluar, $rekapMutasi, $date), "rekap-$date.xlsx");
    }
}
