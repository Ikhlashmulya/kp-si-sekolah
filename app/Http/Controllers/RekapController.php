<?php

namespace App\Http\Controllers;

use App\Dto\GetMutasiByDateDto;
use App\Exports\RekapExport;
use App\Service\MutasiService;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RekapController extends Controller
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


        return view('rekap.index', compact('mutasiMasuk', 'mutasiKeluar', 'dates', 'filterForView', 'rekapMutasi', 'date', 'sumRekap', 'rekapTahunan'));
    }

    public function exportRekapBulanan(string $date)
    {
        $rekapMutasi = MutasiService::getRekapBulanan($date);
        $mutasiMasuk = MutasiService::getMutasiMasuk($date);
        $mutasiKeluar = MutasiService::getMutasiKeluar($date);
        list($month, $year) = explode('-', $date);
        $date = Carbon::create($year, $month)->format('F-Y');
        return Excel::download(new RekapExport($mutasiMasuk, $mutasiKeluar, $rekapMutasi, $date), "rekap-$date.xlsx");
    }
}
